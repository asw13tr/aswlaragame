<?php

namespace App\Http\Middleware;

use Closure;
//use Illuminate\Support\Facades\Auth;

class PanelAccessPermission{

    public function handle($request, Closure $next, $id=null){
        $result = $next($request);
        if( $request->user()->level < 3 ){
            $goUrl = route('panel.dashboard');
            $item = null;
            
            if($request->route('article')){
                $item = $request->route('article');
                $goUrl = route('panel.blog.articles');
            }

            if($request->route('game')){
                $item = $request->route('game');
                $goUrl = route('panel.game.games');
            }
            if(!$item || $request->user()->id != $item->author){
                $result = redirect( $goUrl );
            }
        }
        return $result;
    }
}
