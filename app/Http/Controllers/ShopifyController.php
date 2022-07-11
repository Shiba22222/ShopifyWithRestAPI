<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Jobs\CreateProduct;
use App\Jobs\DeleteProductJob;
use App\Jobs\EditProductJob;
use App\Models\Image;
use App\Models\Product;
use App\Models\Shopify;
use App\Models\Variants;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShopifyController extends Controller
{
    // Truyền ra ngoài view để nhập tên Shopify
    public function index(Request $request)
    {
        return view('index');
    }

    // Lấy link Shopify
    public function testShopify(Request $request)
    {
        $apiKey = 'b0579adb53c4c6f9ec27248709d62afb';
        $scope = 'read_customers,read_products,write_products';
        $shop = $request->shop;
//        $redirect_uri = 'http://127.0.0.1:8000/authen';
        $redirect_uri = 'https://94f4-171-252-44-222.ap.ngrok.io/authen';
        $url = 'https://' . $shop . '.myshopify.com/admin/oauth/authorize?client_id=' . $apiKey . '&scope=' . $scope . '&redirect_uri=' . $redirect_uri;
        return redirect($url);
    }

    //Lấy Access_token và đăng nhập vào shop
    public function authen(Request $request)
    {
        $code = $request->code;
        $shopName = $request->shop;
        $data = $this->getAccessToken($code, $shopName);
        $access_token = $data->access_token;
        $url = 'https://' . $shopName . '/admin/api/2022-07/shop.json?';

        $client = new Client();
        $dataAuthen = $client->request('GET', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => $access_token,
            ]
        ]);

        $res = (array)json_decode($dataAuthen->getBody());

        //Lưu thông tin Shopify
        if (!Shopify::find($res['shop']->id)) {
            $shopInfor = $this->saveData($res, $access_token);
        }

        //Lưu thông tin sản phẩm vào Shopify
        $createProduct = $this->create($shopName, $access_token);
        foreach ($createProduct['products'] as $item) {
            if (!Product::find($item->id)) {
                $saveProducts = $this->saveProduct($createProduct, $access_token);
            }
        }

        $this->createWebhook($shopName, $access_token);

        $this->updateWebhook($shopName,$access_token);

        $this->deleteWebhook($shopName,$access_token);

        return redirect()->route('admin.get.getProduct');

    }

    public function getShow(){

        return view('admins.register');
    }

    //Lấy access_token
    public function getAccessToken(string $code, string $domain)
    {
        $client2 = new Client();
        $response = $client2->post(
            "https://" . $domain . "/admin/oauth/access_token",
            [
                'form_params' => [
                    'client_id' => 'b0579adb53c4c6f9ec27248709d62afb',
                    'client_secret' => 'bcb759044e7b631293b5fe922a2eb30d',
                    'code' => $code,
                ]
            ]
        );


        return json_decode($response->getBody()->getContents());
    }

    //Lưu thông tin Shopify
    public function saveData($res, $access_token)
    {
        $saveData = $res['shop'];

        $findCreateAT = array('T', '+07:00');
        $replaceCreateAT = array(' ', '');
        $findUpdateAT = array('T', '+07:00');
        $replaceUpdateAT = array(' ', '');

        $created_at = str_replace($findCreateAT, $replaceCreateAT, $saveData->created_at);
        $updated_at = str_replace($findUpdateAT, $replaceUpdateAT, $saveData->updated_at);

        $dataPost = [
            'id' => $saveData->id,
            'name' => $saveData->name,
            'domain' => $saveData->domain,
            'email' => $saveData->email,
            'access_token' => $access_token,
            'plan_name' => $saveData->plan_name,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ];
        Shopify::create($dataPost);
        return $dataPost;
    }

    //Lấy thông tin sản phẩm từ Shopify về
    public function create($shop, $access_token)
    {
        $client = new Client();
        $url = 'https://' . $shop . '/admin/api/2022-07/products.json';
        $resProduct = $client->request('get', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => $access_token,
            ]
        ]);
        return (array)json_decode($resProduct->getBody()->getContents());
    }

    //Lưu sản phẩm vào DB
    public function saveProduct($getProduct, $access_token)
    {

        $saveProducts = $getProduct['products'];
        foreach ($saveProducts as $product) {
            Product::create([
                'id' => $product->id,
                'title' => $product->title,
                'description' => $product->body_html,
            ]);

            if ($product->variants) {
                foreach ($product->variants as $variant) {
                    Variants::create([
                        'id' => $variant->id,
                        'price' => $variant->price,
                        'old_price' => $variant->compare_at_price,
                        'quantity' => $variant->inventory_quantity,
                        'product_id' => $variant->product_id
                    ]);
                }
            }

            if ($product->images) {
                foreach ($product->images as $image) {
                    Image::create([
                        'id' => $image->id,
                        'url' => $image->src,
                        'product_id' => $image->product_id,
                    ]);
                }
            }
        }

    }

    //Đăng kí Webhook để lấy những sản phẩm đã được tạo trên Shopify về
    public function createWebhook($shop, $access_token)
    {
        $client = new Client();
        $url = 'https://' . $shop . '/admin/api/2022-07/webhooks.json';
        $resShop = $client->request('post', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => $access_token,
            ],
            'form_params' => [
                'webhook' => [
                    'topic' => 'products/create',
                    'format' => 'json',
                    'address' => 'https://94f4-171-252-44-222.ap.ngrok.io/api/create-webhook',
                ],
            ]
        ]);
    }

    //Đưa vào Queue để lưu những sản phẩm đã được tạo trên Shopify vào DB
    public function createProduct(Request $request)
    {
        $job = new CreateProduct($request->all());
        $this->dispatch($job)->delay(now()->addSecond(1));
    }

    //Đăng kí Webhook để lấy những sản phẩm đã được sửa trên Shopify về
    public function updateWebhook()
    {
        $client = new Client();
        $url = 'https://huskadian2.myshopify.com/admin/api/2022-07/webhooks.json';

        $client->request('POST', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => 'shpua_132e2aa272cd702b9c053538b101a360',
            ],
            'form_params' => [
                'webhook' => [
                    'topic' => 'products/update',
                    'format' => 'json',
                    'address' => 'https://94f4-171-252-44-222.ap.ngrok.io/api/update-webhook',
                ],
            ]
        ]);
    }

    //Đưa vào Queue để tự động lưu những sản phẩm đã được sửa trên Shopify vào DB
    public function updateWebhookProduct(Request $request)
    {
//        $job = new EditProductJob($request->all());
//        $this->dispatch($job)->delay(now()->addSecond(1));
        Product::where('id', $request->input('id'))->update([
            'id' =>    $request->input('id'),
            'description' =>  $request->input('body_html'),
            'title' =>  $request->input('title'),
        ]);


        if ($request['variants']){
            $variant = $request['variants'] ;
                Variants::update([
                    'id' => $variant->input('id'),
                    'price' => $variant->input('price'),
                    'old_price' => $variant->input('compare_at_price'),
                    'quantity' => $variant->input('inventory_quantity'),
                    'product_id' => $variant->input('product_id'),
                ]);
        }

        if ($request['images'])
        {
            foreach ($request['images'] as $image)
            {
                Image::update([
                    'id' => $image['id'],
                    'url' => $image['src'],
                    'product_id' => $image['product_id'],
                ]);
            }
        }
    }

    //Đăng kí Webhook để tự động xóa những sản phẩm đã xóa trên Shopify
    public function deleteWebhook($shop, $access_token)
    {
        $client = new Client();
        $url = 'https://'.$shop.'/admin/api/2022-07/webhooks.json';

        $client->request('POST', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => $access_token,
            ],
            'form_params' => [
                'webhook' => [
                    'topic' => 'products/delete',
                    'format' => 'json',
                    'address' => 'https://94f4-171-252-44-222.ap.ngrok.io/api/delete-webhook',
                ],
            ]
        ]);
    }

    //Xóa sản phẩm đã xóa trên Shopify trong DB
    public function deleteWebhookProduct(Request $request)
    {
        $id = $request->input('id');

        Product::where('id', $id)->delete();

    }

    //Xóa sản phẩm ở App Local đồng thời cũng xóa luôn sản phẩm đó trên Shopify
    public function deleteProductApp(Request $request, $id)
    {
        $client = new Client();
        $url = 'https://huskadian2.myshopify.com/admin/api/2022-07/products/' . $id . '.json';

        $client->request('DELETE', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => 'shpua_132e2aa272cd702b9c053538b101a360',
            ],
        ]);
        Product::find($id)->delete();
        return redirect()->back();
    }

    //Lấy ID của sản phẩm để vào trang chỉnh sửa sản phẩm
    public function editProductApp($id)
    {
        $product = Product::with('image')
            ->with('variants')
            ->find($id);
        return view('admins.products.edit')->with([
            'product' => $product,
        ]);
    }

    //Chỉnh sửa sản phẩm ở App Local nhưng đồng thời chỉnh sửa sản phẩm đó ở trên Shopify
    public function updateWebhookProductApp(ProductRequest $request, $id)
    {
//        DB::table('productslist')->where('id', $id)
//            ->update(
//                [
//                    'user_id' => $request->input('user_id'),
//                    'title' => $request->input('title'),
//                    'description' => $request->input('description'),
//                    'quantity' => $request->input('quantity'),
//                    'status' => $request->input('status'),
//                    'category_id' => $request->input('category_id'),
//                    'price' => $request->input('price')
//                ]
//            );

        $client = new Client();
        $url = 'https://huskadian2.myshopify.com/admin/api/2022-07/products/'.$id.'.json';

        $client->request('PUT', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => 'shpua_132e2aa272cd702b9c053538b101a360',
            ],
            'form_params' => [
                'product' => [
                    'id' => $id,
                    'title' => $request->input('title'),
                    'body_html' => $request->input('description'),
//                    'variants' => [
//                        'id' =>
//                    ]
                ],
            ]
        ]);
        $data = $request->validated();
        $product = Product::find($id);
        $product->update($data);


        return redirect()->route('admin.get.getProduct')->with('message','Sửa sản phẩm thành công');
    }
}
