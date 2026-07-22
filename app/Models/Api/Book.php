<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Attributes\UseResourceCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\Api\BookFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'page_count',
    ];


}
