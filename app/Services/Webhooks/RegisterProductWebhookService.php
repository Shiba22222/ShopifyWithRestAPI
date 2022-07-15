<?php

namespace App\Services\Webhooks;

use GuzzleHttp\Client;

class RegisterProductWebhookService
{
    //Đăng kí Webhook
    public static function registerProductWebhookService($shop, $access_token){
        self::createProductWebhook($shop, $access_token);
        self::updateProductWebhook($shop, $access_token);
        self::deleteProductWebhook($shop, $access_token);
    }

    //Lấy thông tin sản phẩm từ Shopify về
    public function createDataProduct($shop, $access_token)
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

    //Đăng kí Webhooks để lấy những sản phẩm đã được sửa trên Shopify về
    public static function createProductWebhook($shop, $access_token)
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
                    'address' => config('shopify.ngrok').'/api/shopify/webhook',
                ],
            ]
        ]);
    }

    //Đăng kí Webhooks để lấy những sản phẩm đã được tạo trên Shopify về
    public static function updateProductWebhook($shop, $access_token)
    {
        $client = new Client();
        $url = 'https://' . $shop . '/admin/api/2022-07/webhooks.json';
        $resShop = $client->request('post', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => $access_token,
            ],
            'form_params' => [
                'webhook' => [
                    'topic' => 'products/update',
                    'format' => 'json',
                    'address' => config('shopify.ngrok').'/api/shopify/webhook',
                ],
            ]
        ]);
    }

    //Đăng kí Webhooks để lấy những sản phẩm đã được sửa trên Shopify về
    public static function deleteProductWebhook($shop, $access_token)
    {
        $client = new Client();
        $url = 'https://' . $shop . '/admin/api/2022-07/webhooks.json';

        $client->request('POST', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => $access_token,
            ],
            'form_params' => [
                'webhook' => [
                    'topic' => 'products/delete',
                    'format' => 'json',
                    'address' => config('shopify.ngrok').'/api/shopify/webhook',
                ],
            ]
        ]);
    }
}
