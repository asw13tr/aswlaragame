<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model{

    protected $table = 'pages';
    protected $fillable = [
            'title',            'slug',         'description',      'content',
            'cover',            'parent',       'status',           'hide_cover',
            'allow_comments',   'p_time',       'video'         ];

}
