<?php

namespace App\Jobs;

use App\Models\Image;
use App\Models\Product;
use App\Models\Variants;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $product;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $product = $this->product;

        Product::create([
            'id' =>   $product['id'],
            'description' => $product['body_html'],
            'title' => $product['title'],
        ]);

        if (!empty($product['variants'])){
            foreach ($product['variants'] as $variant)
            {
                Variants::create([
                    'id' => $variant['id'],
                    'price' => $variant['price'],
//                    'old_price' => $variant['compare_at_price'],
//                    'quantity' => $variant['inventory_quantity'],
                    'product_id' => $variant['product_id'],
                ]);
            }
        }

        if (!empty($product['images']))
        {
            foreach ($product['images'] as $image)
            {
                Image::create([
                    'id' => $image['id'],
                    'image' => $image['src'],
                    'product_id' => $image['product_id'],
                ]);
            }
        }

    }
}
