<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProduct(){
        $getProducts = Product::with('image')
                                ->with('variants')
                                ->simplePaginate(10);
        return view('admins.products.index')->with([
            'getProducts' => $getProducts,
        ]);
    }

}
