<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameCategory extends Model
{
     public  $table = 'game_categories';
     public  $fillable = [
          'title',
          'slug',
          'description',
          'parent',
          'cover',
          'status'
     ];


    public function games(){
        return $this->belongsToMany('App\Game', 'conn_game_cat', 'game_category_id', 'game_id');
    }

}
