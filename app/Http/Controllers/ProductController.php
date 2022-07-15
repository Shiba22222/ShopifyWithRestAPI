<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Image;
use App\Models\Product;
use App\Models\Variants;
use App\Services\Products\ProductImageService;
use App\Services\Products\ProductService;
use App\Services\Products\ProductVariantService;

class ProductController extends Controller
{
    //Trang show toàn bộ sản phẩm
    public function getProduct(){
        $getProducts = Product::with('image')
                                ->with('variants')
                                ->simplePaginate(10);
        return view('admins.products.index')->with([
            'getProducts' => $getProducts,
        ]);
    }

    //Vào trang tạo sản phẩm
    public function getCreateProductWebhook()
    {
        return view('admins.products.create');
    }

    //Tạo sản phẩm ở local App đồng thời cũng tạo sản phẩm đó trên Shopify
    public function postCreateProductWebhook(ProductRequest $request)
    {
        $data = $request->validated();

        //Tạo sản phẩm trên Shopify
        $dataCreateProduct = ProductService::createDataProduct($request);

        //Lấy id của product trên Shopify
        $id = $dataCreateProduct['product']->id;

        //Lưu sản phẩm vào DB
        Product::create($data + [
                'id' => $id,
            ]);

        //Lấy id của variant trên Shopify
        $variant_id = $dataCreateProduct['product']->variants[0]->id;

        //Tạo variant của Sản phẩm trên shopify
        ProductVariantService::createDataProductVariant($request, $variant_id);

        //Lưu variant của sản phẩm vào DB
        Variants::create($data + [
                'id' => $variant_id,
                'product_id' => $id,
            ]);
        //Tạo ảnh của Sản phẩm lên trên Shopify
        $dataCreateImage = ProductImageService::createDataProductImage($request, $id);

        //Lưu image của sản phẩm vào DB
        $data['id'] = $dataCreateImage['image']->id;
        $data['image'] = $dataCreateImage['image']->src;
        Image::create($data + [
                'id' => $data['id'],
                'product_id' => $id,
            ]);

        return redirect()->route('admin.get.getProduct')->with('message', 'Tạo sản phẩm thành công');
    }

    //Xóa sản phẩm ở App Local đồng thời cũng xóa luôn sản phẩm đó trên Shopify
    public function deleteProductApp($id)
    {
        Product::find($id)->delete();
        ProductService::deleteDataProduct($id);

        return back()->with('message', 'Xóa sản phẩm thành công');
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
        $data = $request->validated();

        //Sửa sản phẩm trên Shopify
        $updateDataProduct = ProductService::updateDataProduct($request, $id);

        //Update thông tin sản phẩm vào DB local
        $updateProduct = Product::with('variants')
            ->with('image')
            ->find($id);

        $updateProduct->update($data);

        //Lấy id của variant
        $variants = $updateProduct->variants;
        foreach ($variants as $variant) {
            $variant_id = $variant->id;
        }

        //Sửa variant của Sản phẩm trên shopify
        ProductVariantService::updateDataProductVariant($request, $variant_id);

        //Lưu dữ liêu Variant của sản phẩm vào DB Local
        $data['price'] = $request->price;
        $variant = Variants::find($variant_id)->update($data);

        //Lấy id của image
        $images = $updateProduct->image;
        foreach ($images as $image) {
            $image_id = $image->id;
        }
        $image = $request->image;

        //Sửa ảnh của Sản phẩm lên trên Shopify
        $updateProductImage = ProductImageService::updateDataProductImage($request, $id, $image_id);

        //Lưu ảnh của sản phẩm vào DB Local
        $data['image'] = $updateProductImage['image']->src;
        Image::find($image_id)->update($data);

        return redirect()->route('admin.get.getProduct')->with('message', 'Sửa sản phẩm thành công');
    }

}
