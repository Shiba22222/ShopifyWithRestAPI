<?php

namespace App\Jobs;

use App\Models\Image;
use App\Models\Product;
use App\Models\Variants;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class EditProductJob implements ShouldQueue
{
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
        $product_id = $product['id'];

        Product::where('id', $product_id)->update([
            'description' => $product['body_html'],
            'title' => $product['title'],
        ]);

        if ($product['variants']) {
            $variants = $product['variants'];
            foreach ($variants as $variant) {
                Variants::where('product_id', $product_id)
                    ->update([
                        'price' => $variant['price'],
                        'old_price' => $variant['compare_at_price'],
                        'quantity' => $variant['inventory_quantity'],
                    ]);
            }
        }

        if ($product['images']) {
            foreach ($product['images'] as $image) {
                Image::where('product_id', $product_id)->update([
                    'image' => $image['src']
                ]);
            }
        }
    }
}
