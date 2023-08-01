<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $tabel = 'products';
    
    protected $fillabe = [
        'name',
        'description',
        'price',
        'qty',
    ];
}
