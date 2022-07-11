<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'id','title', 'description'
    ];
    public $timestamps = false;

    public function image(){
        return $this->hasMany(Image::class);
    }

    public function variants(){
        return $this->hasMany(Variants::class);
    }
}
