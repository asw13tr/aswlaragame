<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Media;

class MediaController extends Controller{


    public function index(){
        $datas = [
            'headTitle' => 'Medya dosyaları',
            'items'     => Media::orderBy('id', 'desc')->offset(0)->limit(30)->get()
        ];
        return view('panel/media/index', $datas);
    }


}
