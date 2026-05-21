<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Article extends Model
{
    //
    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'content',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(
            ArticleCategory::class,
            'category_id'
        );
    }
}
