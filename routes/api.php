<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/create-webhook',[\App\Http\Controllers\ShopifyController::class,'createWebhook'])->name('get.webhook');

Route::post('/create-webhook',[\App\Http\Controllers\ShopifyController::class,'createProduct'])->name('post.createWebhook');

Route::get('/delete-webhook',[\App\Http\Controllers\ShopifyController::class,'deleteWebhook'])->name('get.deleteWebhook');
Route::post('/delete-webhook',[\App\Http\Controllers\ShopifyController::class,'deleteWebhookProduct']);

Route::get('/update-webhook',[\App\Http\Controllers\ShopifyController::class,'updateWebhook'])->name('get.updateWebhook');
Route::post('/update-webhook',[\App\Http\Controllers\ShopifyController::class,'updateWebhookProduct']);

