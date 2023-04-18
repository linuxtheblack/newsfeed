<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'author',
        'subTitle',
        'article',
        'publishedAt',
    ];

    protected $casts = [
        'publishedAt' => 'datetime',
    ];
}
