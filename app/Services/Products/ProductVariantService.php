<?php

namespace App\Services\Products;

use GuzzleHttp\Client;

class ProductVariantService
{
    //Tạo variant của Sản phẩm trên shopify
    public function createDataProductVariant($request, $variant_id){
        $client =new Client();
        $urlProductVariant = config('shopify.shopify_domain').'/admin/api/2022-07/variants/' . $variant_id . '.json';
        $resCreateProductVariant = $client->request('PUT', $urlProductVariant, [
            'headers' => [
                'X-Shopify-Access-Token' => config('shopify.shopify_access_token'),
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'variant' => [
                    'id' => $variant_id,
                    'price' => $request->price,
//                    'compare_at_price' => $request->old_price,
//                    'inventory_quantity' => $request->quantity,
                ]
            ],
        ]);
        $dataCreateProductVariant = (array)json_decode($resCreateProductVariant->getBody());

        return $dataCreateProductVariant;
    }

    //Sửa variant của Sản phẩm trên shopify
    public function updateDataProductVariant($request, $variant_id){
        $client =new Client();
        $urlProductVariant = config('shopify.shopify_domain').'/admin/api/2022-07/variants/' . $variant_id . '.json';
        $resUpdateProductVariants = $client->request('PUT', $urlProductVariant, [
            'headers' => [
                'X-Shopify-Access-Token' => config('shopify.shopify_access_token'),
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'variant' => [
                    'id' => $variant_id,
                    'price' => $request->price,
//                    'compare_at_price' => $request->old_price,
//                    'inventory_quantity' => $request->quantity,
                ]
            ],
        ]);
        $updateProductVariant = (array)json_decode($resUpdateProductVariants->getBody());

        return $updateProductVariant;
    }
}
