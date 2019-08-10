<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use App\Game;
use App\Page;
use App\GameCategory;

class MainController extends Controller{

    public $rootGames = null;
    public function __construct(){
        $this->rootGames = Game::where('status', 'published');
    }




    public function page($slug){
        $page = Page::where('status', 'published')->where('slug', $slug)->first();
        $datas = [
            'page' =>$page,
            'cclass' => 'page',
            'headTitle' => $page->title,
            'headDescription' => $page->description
        ];
        return view('page', $datas);
    }



    public function index(Request $request){
        if($request->get('ara', false)){
            $aranan = $request->get('ara');
            $games = Game::orderBy('id', 'desc')
                        ->where('status', 'published')
                        ->where('title', 'like', "%{$aranan}%")
                        ->orWhere('description', 'like', "%{$aranan}%")
                        ->orWhere('summary', 'like', "%{$aranan}%");
            $datas = [
                'games' =>$games->paginate(30),
                'totalGameCount' => $games->count(),
                'cclass' => 'game frontpage'
            ];
        }else{
            $games = Game::orderBy('id', 'desc')->where('status', 'published');
            $datas = [
                'games' => $games->paginate(30),
                'totalGameCount' => $games->count(),
                'cclass' => 'game frontpage'
            ];
        }
        return view('index', $datas);
    }//index


    public function bestGames(){
        $games = $this->rootGames->orderBy('like', 'DESC')->orderBy('dislike');
        $datas = [
            'games' => $games->paginate(30),
            'totalGameCount' => $games->count(),
            'cclass' => 'game frontpage',
            'headTitle' => 'En iyi oyunlar'
        ];
        return view('index', $datas);
    }//bestGames


    public function popularGames(){
        $games = $this->rootGames->orderBy('views', 'DESC');
        $datas = [
            'games' => $games->paginate(30),
            'totalGameCount' => $games->count(),
            'cclass' => 'game frontpage',
            'headTitle' => 'Popüler oyunlar'
        ];
        return view('index', $datas);
    }//popularGames


    public function lastGames(){
        $games = $this->rootGames->orderBy('p_time', 'DESC');
        $datas = [
            'games' => $games->paginate(30),
            'totalGameCount' => $games->count(),
            'cclass' => 'game frontpage',
            'headTitle' => 'En yeni oyunlar'
        ];
        return view('index', $datas);
    }


    public function game(Request $request, $slug){
        $game = Game::where('slug',$slug)->where('status','published')->first();

        // BENZER İÇERİKLERİ BUL
        $categoryids = array();
        foreach($game->categories as $c){ $categoryids[] = $c->id; }
        $relatedGames = Game::whereHas('categories', function($q) use($categoryids){
            $q->whereIn('game_category_id', $categoryids);
        })->orderBy('id', 'desc')->where('status', 'published')->where('id', '!=', $game->id)->limit(8)->get();
        if($relatedGames->count() < 8){
            $gereken = 8 - $relatedGames->count();
            $oneriler = Game::where('status', 'published')->orderBy('views', 'DESC')->limit(20)->get()->random($gereken);
            $relatedGames = $relatedGames->merge($oneriler);
        }

        $datas = [
            'game' => $game,
            'cclass' => 'single',
            'headTitle' => $game->title,
            'headDescription' => $game->description,
            'relatedGames' => $relatedGames,
            'voteCookie' =>$request->session()->get('voteGame_'.$game->id, false)
        ];

        if(!$request->session()->get('view_'.$game->id, false)){
            $game->update(['views' => $game->views + 1]);
            $request->session()->put('view_'.$game->id, true);
        }

        if($game->game_screen == "fullsize"){
            return view('gamefullscreen', $datas);
        }else{
            return view('game', $datas);
        }
    }

    public function category($slug){
        $category = GameCategory::where('slug', $slug)->where('status', 'published')->first();
        $games = Game::whereHas('categories', function($q) use($slug){
            $q->where('slug', $slug)->where('status', 'published');
        })->orderBy('id', 'desc')->where('status', 'published');
        $datas = [
            'games' => $games->paginate(30),
            'category' => $category,
            'totalGameCount' => $games->count(),
            'cclass' => 'game category'
        ];
        return view('index', $datas);
    }




    public function ajaxGameVote(Request $request, $id, $oy){
        $game = Game::find($id);
        $islem = 0;
        if($oy=="olumlu"){ $game->update([ 'like' => $game->like+1 ]); $islem=1; }
        if($oy=="olumsuz"){ $game->update([ 'dislike' => $game->dislike+1 ]); $islem=1; }
        if($islem == 1){
            $request->session()->put('voteGame_'.$id, $oy);
        }
        echo $islem;
    }

}
