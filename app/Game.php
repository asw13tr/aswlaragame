<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model{

    protected $table = 'games';
    protected $fillable = [
        'title',            'slug',         'description',      'summary',          'cover',            'author',
        'game_file',        'game_url',     'game_code',        'game_video',       'game_screen',
        'game_scale',       'status',       'content',          'p_time',            'allow_comments',
    'like', 'dislike', 'views' ];



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

    public function getGame(){
        $result = null;
        if(isset($this->game_file)){
            $result = $this->gameObject( url(asw('path_media_game_files').'/'.$this->game_file) );
        }elseif(isset($this->game_url)){
            $result = '<iframe id="objGame" src="'.$this->game_url.'" style="border: none;" allowfullscreen></iframe>';
            if(strpos($this->game_url, ".swf")){
                $result = $this->gameObject($this->game_url);
            }
        }else{
            $result = $this->game_code;
        }
        return $result;
    }

    private function gameObject($swf){
        echo '<object codebase="https://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0"
            id="objGame" align="middle"
            class="item-direct-container resizable">
            <param name="allowScriptAccess" value="never" />
            <param name="movie" value="'.$swf.'" />
            <param name="quality" value="high" />
            <param name="wmode" value="window" />
            <param name="allowfullscreen" value="false" />
            <param name="allowfullscreeninteractive" value="false" />
            <param name="fullScreenAspectRatio" value="" />
            <param name="quality" value="" />
            <param name="play" value="true" />
            <param name="loop" value="true" />
            <param name="menu" value="" />
            <param name="hasPriority" value="true" />
            <embed src="'.$swf.'"
            class="item-direct-container resizable"
            id="objGame"
            name="flash-content"
            align="middle"
            wmode="window"
            allowfullscreen="false"
            allowfullscreeninteractive="false"
            fullScreenAspectRatio=""
            quality="high"
            play="true"
            loop="true"
            allowScriptAccess="never"
            hasPriority="true"
            type="application/x-shockwave-flash"
            pluginspage="https://www.adobe.com/go/getflashplayer"></embed>
            </object>';
    }

    public function getLike(){
       $toplamOy = $this->like + $this->dislike;
       $result = 0;
       if($toplamOy > 0){
           $herYuzde = 100 / $toplamOy;
           $result = round( $herYuzde * $this->like );
       }
        return $result;
    }

    public function getDislike(){
       $toplamOy = $this->like + $this->dislike;
       $result = 0;
       if($toplamOy > 0){
           $herYuzde = 100 / $toplamOy;
           $result = round( $herYuzde * $this->dislike );
       }
        return $result;
    }

    public function getUrl(){
        return route('game', ['slug'=>$this->slug]);
    }


}
