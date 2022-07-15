<?php

namespace App\Http\Controllers;

use App\Jobs\CreateProduct;
use App\Jobs\DeleteProductJob;
use App\Jobs\EditProductJob;
use App\Models\Product;
use App\Models\Shopify;
use App\Services\Webhooks\CreateDataWebhookService;
use App\Services\Webhooks\GetAccessTokenService;
use App\Services\Webhooks\RegisterProductWebhookService;
use App\Services\Webhooks\SaveDataWebhookService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ShopifyController extends Controller
{
    // Truyền ra ngoài view để nhập tên Shopify
    public function index(Request $request)
    {
        return view('admins.products.input');
    }

    // Lấy link Shopify
    public function testShopify(Request $request)
    {
        $apiKey = config('shopify.shopify_api_key');
        $scope = 'read_customers,read_products,write_products';
        $shop = $request->shop;
        $redirect_uri = config('shopify.ngrok') . '/authen';
        $url = 'https://' . $shop . '.myshopify.com/admin/oauth/authorize?client_id=' . $apiKey . '&scope=' . $scope . '&redirect_uri=' . $redirect_uri;
        return redirect($url);
    }

    //Lấy Access_token và đăng nhập vào shop
    public function authen(Request $request)
    {
        $code = $request->code;
        $shopName = $request->shop;

        //Lấy Access_token gọi về từ GetAccessTokenService
        $getAccess_token = GetAccessTokenService::getAccessToken($code, $shopName);
        $access_token = $getAccess_token->access_token;

        //Lấy thông tin đăng nhập
        $url = 'https://' . $shopName . '/admin/api/2022-07/shop.json?';
        $client = new Client();
        $dataAuthen = $client->request('GET', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => $access_token,
            ]
        ]);
        $getDataLogin = (array)json_decode($dataAuthen->getBody());


        //Lưu thông tin Shopify lấy về từ SaveDataWebhookService vào DB
        if (!Shopify::find($getDataLogin['shop']->id)) {
            $webhookLogin = SaveDataWebhookService::saveDataLogin($getDataLogin, $access_token);
        }

        //Lưu thông tin sản phẩm ở Shopify lấy về từ SaveDataWebhookService vào DB
        $createProduct = CreateDataWebhookService::createDataProduct($shopName, $access_token);
        foreach ($createProduct['products'] as $item) {
            if (!Product::find($item->id)) {
                $saveProducts = SaveDataWebhookService::saveDataProduct($createProduct, $access_token);
            }
        }

        //Đăng kí ProductWebhooks thêm, xóa, sửa
        $this->registerProductWebhook($shopName, $access_token);

        return redirect()->route('admin.get.getProduct');
    }

    //Đăng kí ProductWebhooks thêm, xóa, sửa
    public function registerProductWebhook($shop, $access_token)
    {
        RegisterProductWebhookService::registerProductWebhookService($shop, $access_token);
    }

    //Đưa vào Queue để lưu những sản phẩm đã được tạo trên Shopify vào DB
    public static function createFromShopify($payload)
    {
        dispatch(new CreateProduct($payload));

        return;
    }

    //Đưa vào Queue để tự động lưu những sản phẩm đã được sửa trên Shopify vào DB
    public static function updateFromShopify($payload)
    {
        dispatch(new EditProductJob($payload));

        return;
    }

    //Đưa vào Queue để tự động xóa sản phẩm đã xóa trên Shopify trong DB
    public static function deleteFromShopify($payload)
    {
        dispatch(new DeleteProductJob($payload));

        return;
    }

}
