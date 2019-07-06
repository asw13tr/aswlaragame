<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConnectArticleCategory extends Model
{
    protected $table = 'conn_art_cat';
    protected $fillable = ['article_id', 'blog_category_id'];
}
