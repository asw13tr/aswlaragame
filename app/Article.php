<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = [
         'title',        'slug',        'keywords',         'description',
         'summary',      'author',      'status',           'content', 'views',
         'cover',        'video',       'hide_cover',      'allow_comments',    'p_time'
    ];

    public function categories(){
         return $this->belongsToMany('App\BlogCategory', 'conn_art_cat', 'article_id', 'blog_category_id');
    }

    public function getCategoriesUrlAdmin(){
        $urls = array();
        foreach( $this->categories as $item ){
            $urls[] = '<a href="'.route('panel.blog.articles').'?c='.$item->id.'">'.$item->title.'</a>';
        }
        return implode(', ', $urls);
    }

    public function getDescription(){
        if( strlen($this->description) > 1 ){
            return $this->description;
        }elseif( strlen($this->summary) ){
            return $this->summary;
        }else{
            return mb_substr( strip_tags($this->content), 0, 170, 'UTF-8' );
        }
    }

    public function getSummary(){
        if( strlen($this->summary) ){
            return $this->summary;
        }elseif( strlen($this->description) > 1 ){
            return $this->description;
        }else{
            return mb_substr( strip_tags($this->content), 0, 255, 'UTF-8' );
        }
    }

}
