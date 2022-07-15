<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopifyController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Trang chủ
Route::get('/',[ShopifyController::class,'index'])
    ->name('index');

//Nhận thông tin access_token và bắt đầu xử lí các bước tiếp theo
Route::any('/authen',[ShopifyController::class,'authen'])->name('authen');

//Trang chủ cũng là trang nhập tên shopify
Route::any('/huskadian',[ShopifyController::class,'testShopify'])->name('huskadian');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function (){
    //Trang chủ
    Route::get('/',[ShopifyController::class,'index'])
    ->name('index');

    //Route hiển thị sản phẩm
    Route::get('/get-product',[\App\Http\Controllers\ProductController::class,'getProduct'])
        ->name('get.getProduct');

    //Route ấn vào để chuyển sang trang tạo sản phẩm
    Route::get('/create-product-app',[\App\Http\Controllers\ProductController::class,'getCreateProductWebhook'])
        ->name('get.createProduct');

    //Route để lưu lại sản phẩm đã tạo vào DB và Shopify
    Route::post('/create-product-app',[\App\Http\Controllers\ProductController::class,'postCreateProductWebhook'])
        ->name('post.createProduct');

    //Route xóa sản phẩm ở DB và Shopify
    Route::get('/delete-product-app/{id}',[\App\Http\Controllers\ProductController::class,'deleteProductApp'])
        ->name('get.deleteProductApp');

    //Route ấn vào để chuyển sang trang sửa sản phẩm
    Route::get('/update-product-app/{id}',[\App\Http\Controllers\ProductController::class,'editProductApp'])
        ->name('get.updateProductApp');

    //Route để lưu sản phẩm đã được chỉnh sửa vào DB và Shopify
    Route::post('/update-product-app/{id}',[\App\Http\Controllers\ProductController::class,'updateWebhookProductApp'])
        ->name('post.updateProductApp');
});



