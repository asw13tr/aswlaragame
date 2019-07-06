<?php

namespace App\Http\Controllers\Panel;

use App\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller{

    public $settings = array();
    public function __construct(){
        if(Config::all()->count() > 0){
            foreach(Config::all() as $item){
                $this->settings[$item->key] = $item->val;
            }
        }
        $this->settings = json_decode( json_encode($this->settings), false );
    }

    public function general(){
        $datas = [
            'headTitle' => "Genel Ayarlar",
            'setting'   => $this->settings
        ];
        return view('panel/setting/general', $datas);
    }
    public function generalPost(Request $request){
        $datas = $request->all();
        unset($datas['_token']);
        $datas['site_offline'] = $request->get('site_offline', 0);
        $datas['allow_register'] = $request->get('allow_register', 0);
        $datas['allow_register_panel'] = $request->get('allow_register_panel', 0);
        foreach($datas as $k => $v){ Config::where('key', $k)->update(['val' => $v]); }
        setAlertFixed('Ayarlar Güncellendi.');
        return redirect()->route('panel.setting.general');
    }







    public function content(){
        $datas = [
            'headTitle' => "İçerik Ayarları",
            'setting'   => $this->settings
        ];
        return view('panel/setting/content', $datas);
    }
    public function contentPost(Request $request){
        $datas = $request->all();
        unset($datas['_token']);
        $datas['pages_allow_comments'] = $request->get('pages_allow_comments', 0);
        $datas['articles_allow_commens'] = $request->get('articles_allow_commens', 0);
        $datas['games_allow_commens'] = $request->get('games_allow_commens', 0);
        $datas['games_allow_detail_page'] = $request->get('games_allow_detail_page', 0);
        foreach($datas as $k => $v){ Config::where('key', $k)->update(['val' => $v]); }
        setAlertFixed('Ayarlar Güncellendi.');
        return redirect()->route('panel.setting.content');
    }








    public function media(){
        $datas = [
            'headTitle' => "Medya Ayarları",
            'setting'   => $this->settings
        ];
        return view('panel/setting/media', $datas);
    }
    public function mediaPost(Request $request){
        $datas = $request->all();
        unset($datas['_token']);
        $datas['img_allow_original'] = $request->get('img_allow_original', 0);
        $datas['img_lg_crop'] = $request->get('img_lg_crop', 0);
        $datas['img_md_crop'] = $request->get('img_md_crop', 0);
        $datas['img_sm_crop'] = $request->get('img_sm_crop', 0);
        foreach($datas as $k => $v){ Config::where('key', $k)->update(['val' => $v]); }
        setAlertFixed('Ayarlar Güncellendi.');
        return redirect()->route('panel.setting.media');
    }











    public function contact(){
        $datas = [
            'headTitle' => "İletişim Ayarları",
            'setting'   => $this->settings
        ];
        return view('panel/setting/contact', $datas);
    }
    public function contactPost(Request $request){
        $datas = $request->all();
        unset($datas['_token']);
        foreach($datas as $k => $v){ Config::where('key', $k)->update(['val' => $v]); }
        setAlertFixed('Ayarlar Güncellendi.');
        return redirect()->route('panel.setting.contact');
    }






}
