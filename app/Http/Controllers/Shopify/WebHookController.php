<?php

namespace App\Http\Controllers\Shopify;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ShopifyController;
use App\Services\ProductService;
use Illuminate\Http\Request;

class WebHookController extends Controller
{
    //Phân chia luồng webhook khi xử lí
    function webhook(Request $request)
    {
        $topic = $request->header('X-Shopify-Topic');
        $payload = $request->all();

        switch ($topic) {
            case 'products/update':
                //Update data Product
                ShopifyController::updateFromShopify($payload);
                break;
            case 'products/create':
                //Create data Product
                ShopifyController::createFromShopify($payload);
                break;
            case 'products/delete':
                //Delete data Product
                ShopifyController::deleteFromShopify($payload);

        }

    }
}
