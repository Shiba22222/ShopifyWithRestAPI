<?php

namespace App\Services\Webhooks;

use App\Models\Image;
use App\Models\Product;
use App\Models\Shopify;
use App\Models\Variants;
use GuzzleHttp\Client;

class SaveDataWebhookService
{
    //Lưu thông tin Shopify
    public function saveDataLogin($res, $access_token)
    {
        $saveData = $res['shop'];

        $findCreateAT = array('T', '+07:00');
        $replaceCreateAT = array(' ', '');
        $findUpdateAT = array('T', '+07:00');
        $replaceUpdateAT = array(' ', '');

        $created_at = str_replace($findCreateAT, $replaceCreateAT, $saveData->created_at);
        $updated_at = str_replace($findUpdateAT, $replaceUpdateAT, $saveData->updated_at);

        $dataPost = [
            'id' => $saveData->id,
            'name' => $saveData->name,
            'domain' => $saveData->domain,
            'email' => $saveData->email,
            'access_token' => $access_token,
            'plan_name' => $saveData->plan_name,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ];
        Shopify::create($dataPost);
        return $dataPost;
    }

    //Lưu sản phẩm vào DB
    public function saveDataProduct($getProduct, $access_token)
    {

        $saveProducts = $getProduct['products'];
        foreach ($saveProducts as $product) {
            Product::create([
                'id' => $product->id,
                'title' => $product->title,
                'description' => $product->body_html,
            ]);

            if ($product->variants) {
                foreach ($product->variants as $variant) {
                    Variants::create([
                        'id' => $variant->id,
                        'price' => $variant->price,
                        'old_price' => $variant->compare_at_price,
                        'quantity' => $variant->inventory_quantity,
                        'product_id' => $variant->product_id
                    ]);
                }
            }

            if ($product->images) {
                foreach ($product->images as $image) {
                    Image::create([
                        'id' => $image->id,
                        'image' => $image->src,
                        'product_id' => $image->product_id,
                    ]);
                }
            }
        }

    }
}
