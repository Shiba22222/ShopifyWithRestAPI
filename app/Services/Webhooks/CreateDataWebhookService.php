<?php

namespace App\Services\Webhooks;

use GuzzleHttp\Client;

class CreateDataWebhookService
{
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
}
