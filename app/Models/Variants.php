<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variants extends Model
{
    use HasFactory;

    protected $table = 'variants';
    protected $fillable = [
        'id', 'price', 'old_price', 'quantity', 'product_id'
    ];
    public $timestamps = false;

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
