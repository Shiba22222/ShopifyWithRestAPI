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

class EditProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $request;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $product = $this->request;

        Product::where('id', $product->input('id'))->update([
            'id' =>    $product->input('id'),
            'description' =>  $product->input('body_html'),
            'title' =>  $product->input('title'),
        ]);

        if ($product['variants']){
            foreach ($product['variants'] as $variant)
            {
                Variants::update([
                    'id' => $variant['id'],
                    'price' => $variant['price'],
                    'old_price' => $variant['compare_at_price'],
                    'quantity' => $variant['inventory_quantity'],
                    'product_id' => $variant['product_id'],
                ]);
            }
        }

        if ($product['images'])
        {
            foreach ($product['images'] as $image)
            {
                Image::update([
                    'id' => $image['id'],
                    'url' => $image['src'],
                    'product_id' => $image['product_id'],
                ]);
            }
        }
    }
}
