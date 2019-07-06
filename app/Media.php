<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    protected $fillable = ['title', 'alt', 'src', 'type', 'info', 'author', 'app', 'app_id'];
}
