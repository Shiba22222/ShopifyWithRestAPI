<?php

namespace App\Services\Products;

use GuzzleHttp\Client;

class ProductImageService
{
    //Tạo ảnh của Sản phẩm lên trên Shopify
    public function createDataProductImage($request, $id){
        $client =new Client();
        $image = $request->url;
        if (isset($image)){
            $image = $request->url;
        }else
        {
            return "";
        }
        $urlProductImage = config('shopify.shopify_domain').'/admin/api/2022-07/products/' . $id . '/images.json';
        $resCreateImage = $client->request('POST', $urlProductImage, [
            'headers' => [
                'X-Shopify-Access-Token' => config('shopify.shopify_access_token'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'image' => [
                    'attachment' => base64_encode(file_get_contents($image)),
                    'filename' => $image->getClientOriginalName(),
                ]
            ]
        ]);
        $dataCreateImage = (array) json_decode($resCreateImage->getBody());

        return $dataCreateImage;
    }

    //Sửa ảnh của Sản phẩm lên trên Shopify
    public function updateDataProductImage($request ,$id, $image_id){
        $image =$request->image;
        if (isset($image)){
            $image =$request->image;
        }
        else{
            return "";
        }
        $client =new Client();
        $urlProductImage = config('shopify.shopify_domain').'/admin/api/2022-07/products/' . $id . '/images/' . $image_id . '.json';
        $resUpdateProductImage = $client->request('PUT', $urlProductImage, [
            'headers' => [
                'X-Shopify-Access-Token' => config('shopify.shopify_access_token'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'image' => [
                    'attachment' => base64_encode(file_get_contents($image)),
                    'filename' => $image->getClientOriginalName()],
            ]
        ]);

        $updateProductImage = (array) json_decode($resUpdateProductImage->getBody());

        return $updateProductImage;
    }
}
