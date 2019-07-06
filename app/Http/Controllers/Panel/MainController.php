<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class mainController extends Controller{

     public function index(){
         $datas = array(
            'lastArticles' =>  \App\Article::orderBy('id', 'desc')->limit(7)->get(),
            'lastGames' =>  \App\Game::orderBy('id', 'desc')->limit(7)->get()
         );
          return view("panel/index", $datas);
     }


}
