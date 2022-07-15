<?php

namespace App\Services;

use App\Jobs\CreateProduct;
use App\Jobs\DeleteProductJob;
use App\Jobs\EditProductJob;

class ProductService
{
    public static function updateFromShopify($payload)
    {
        dispatch(new EditProductJob($payload));
        return ;
    }

    //
    public static function createFromShopify($payload)
    {
        dispatch(new CreateProduct($payload));
        return ;
    }

    public static function deleteFromShopify($payload)
    {
        dispatch(new DeleteProductJob($payload));
        return ;
    }

}
