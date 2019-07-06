<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model{

    protected $table = 'games';
    protected $fillable = [
        'title',            'slug',         'description',      'summary',          'cover',            'author',
        'game_file',        'game_url',     'game_code',        'game_video',       'game_screen',
        'game_scale',       'status',       'content',          'p_time',            'allow_comments' ];



    public function categories(){
        return $this->belongsToMany('App\GameCategory', 'conn_game_cat', 'game_id', 'game_category_id');
    }

    public function getCategoriesUrlAdmin(){
        $urls = array();
        if($this->categories()){
            foreach( $this->categories as $item ){
                $urls[] = '<a href="'.route('panel.game.games').'?c='.$item->id.'">'.$item->title.'</a>';
            }
        }
        return implode(', ', $urls);
    }


}
