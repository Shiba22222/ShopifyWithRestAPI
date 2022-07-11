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
Route::get('/',[ShopifyController::class,'index']);

//Nhận thông tin access_token và bắt đầu xử lí các bước tiếp theo
Route::any('/authen',[ShopifyController::class,'authen'])->name('authen');

//Trang chủ cũng là trang nhập trên shopify
Route::any('/huskadian',[ShopifyController::class,'testShopify'])->name('huskadian');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function (){

    Route::get('/get-product',[\App\Http\Controllers\ProductController::class,'getProduct'])
        ->name('get.getProduct');

    Route::get('/delete-product-app/{id}',[\App\Http\Controllers\ShopifyController::class,'deleteProductApp'])
        ->name('get.deleteProductApp');

    Route::get('/update-product-app/{id}',[ShopifyController::class,'editProductApp'])
        ->name('get.updateProductApp');

    Route::post('/update-product-app/{id}',[ShopifyController::class,'updateWebhookProductApp'])
        ->name('post.updateProductApp');
});

Route::get('/show',[\App\Http\Controllers\ShopifyController::class,'getShow'])->name('get.show');


