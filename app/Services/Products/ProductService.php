<?php

namespace App\Services\Products;

use GuzzleHttp\Client;

class ProductService
{

    //Tạo sản phẩm trên Shopify
    public function createDataProduct($request)
    {
        $client =new Client();
        $urlProduct = config('shopify.shopify_domain').'/admin/api/2022-07/products.json';
        $resCreateProduct = $client->request('POST', $urlProduct, [
            'headers' => [
                'X-Shopify-Access-Token' => config('shopify.shopify_access_token'),
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'product' => [
                    'title' => $request->title,
                    'body_html' => $request->description,
                ]
            ]
        ]);
        $dataCreateProduct = (array)json_decode($resCreateProduct->getBody());

        return $dataCreateProduct;
    }

    //Sửa sản phẩm trên Shopify
    public function updateDataProduct($request, $id)
    {
        $client =new Client();
        $url = config('shopify.shopify_domain').'/admin/api/2022-07/products/' . $id . '.json';
        $resUpdateProduct = $client->request('PUT', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => config('shopify.shopify_access_token'),
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'product' => [
                    'id' => $id,
                    'title' => $request->title,
                    'body_html' => $request->description,
                ]
            ],
        ]);
        $updateProductWebhook = (array)json_decode($resUpdateProduct->getBody());

        return $updateProductWebhook;
    }

    //Xóa sản phẩm ở App Local đồng thời cũng xóa luôn sản phẩm đó trên Shopify
    public function deleteDataProduct($id){
        $client = new Client();
        $url = config('shopify.shopify_domain').'/admin/api/2022-07/products/' . $id . '.json';

        $client->request('DELETE', $url, [
            'headers' => [
                'X-Shopify-Access-Token' => config('shopify.shopify_access_token'),
            ],
        ]);
    }
}
