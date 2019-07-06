<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConnectGameCategory extends Model
{
    protected $table = 'conn_game_cat';
    protected $fillable = ['game_id', 'game_category_id'];
}
