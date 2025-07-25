<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'description',
        'image_url',
        'price',
        'category',
        'is_available',
    ];
}
