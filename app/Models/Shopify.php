<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopify extends Model
{
    use HasFactory;

    protected $table = 'shopifies';
    protected $fillable = [
        'id',
        'name',
        'domain',
        'email',
        'access_token',
        'plan_name',
        'created_at',
        'updated_at',
    ];
}
