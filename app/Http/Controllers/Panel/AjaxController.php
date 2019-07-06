<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Helpers\ASWHelper;
use App\Media;

class AjaxController extends Controller{

    protected $imageUploadPath;

    public function __construct(){
        $this->imageUploadPath = asw('path_media_upload');
    }

    public function imageUpload(Request $request){
        $datas = [  'status' => false   ];

        if( $img = $request->file('image') ){
            // GÖRSEL UPLOAD İŞLEMLERİ
            $imgname = str_slug(getImgInfo( $img->getClientOriginalName()));
            $uploadImgName = $imgname.'_'.time().'.'.$img->getClientOriginalExtension();
            $getImageName = 'lg_'.$uploadImgName;
            aswUploadImage($img->getRealpath(), 'lg', public_path($this->imageUploadPath .'/lg_' . $uploadImgName));
            aswUploadImage($img->getRealpath(), 'md', public_path($this->imageUploadPath .'/md_' . $uploadImgName));
            aswUploadImage($img->getRealpath(), 'sm', public_path($this->imageUploadPath .'/sm_' . $uploadImgName));
            if( asw('img_allow_original') == 1 ){
                aswUploadImage($img->getRealpath(), null, public_path($this->imageUploadPath.'/' . $uploadImgName));
                $getImageName = $uploadImgName;
            }

            $gis = getimagesize( public_path($this->imageUploadPath.'/' . $getImageName) );

            // DB İNFO ALANI BİLGİLERİ OLUŞTURULUYOR.
            $info = [
                'width' => $gis[0],
                'height' => $gis[1],
                'mime' => $gis['mime'],
                'ext' => $img->getClientOriginalExtension(),
                'size' => $img->getSize()
            ];

            // EKLEYEN VE UYGULAMA BİLGİLERİ ALINIYOR
            $preUrl = explode( asw('pre_panel_url').'/', url()->previous() );
            $preUrl = explode( '/', $preUrl[1] );


            // VERİ TABANINA KAYIT EDİLİYOR.
            $media = Media::create([
                'title' => $imgname,
                'alt'   => $imgname,
                'src'   => $uploadImgName,
                'type'  => $gis['mime'],
                'info'  => json_encode($info),
                'author'   => Auth::user()->id,
                'app'       => $preUrl[0],
                'app_id'    => (isset($preUrl[1]) && is_numeric($preUrl[1]))? $preUrl[1] : null
            ]);

            // JSON DÖNECEK BİLGİLER AYARLANIYOR
            $datas = [
                'status' => true,
                'src' =>  url($this->imageUploadPath.'/' . $getImageName),
                'alt' => $imgname,
                'data' => [
                            'id'    => $media->id,
                            'name'  => $media->src,
                            'src'   => getImageSrc($media->src, null, $this->imageUploadPath) ,
                            'sm'    => getImageSrc($media->src, 'sm', $this->imageUploadPath) ,
                            'md'    => getImageSrc($media->src, 'md', $this->imageUploadPath) ,
                            'lg'    => getImageSrc($media->src, 'lg', $this->imageUploadPath) ,
                            'alt'   => $media->alt,
                            'title' => $media->title,
                            'date'  => timestampToString($media->created_at),
                            'size'  => byteToStr($info['size']) ,
                            'width' => $info['width'],
                            'height'=> $info['height'],
                            'type'  => $info['mime'],
                            'ext'   => $info['ext'],
                        ]
            ];
        }// Resim dosyası seçilmiş ise koşul sonu

        $header = array (
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            );

        return response()->json($datas , 200, $header, JSON_UNESCAPED_UNICODE);
    }





    public function mediaBox(Request $request){
        $datas = [
            'items'  => Media::orderBy('id','desc')->offset($request->get('offset', 0))->limit(30)->get() ];
        if($request->get('offset', false)){
            return view('panel/media/popup-more', $datas);
        }else{
            return view('panel/media/popup', $datas);
        }
    }

    public function mediaBoxImageUpdate(Request $request){
        $datas = [ 'status'=>false ];
        if( $media = Media::find($request->get('id')) ){
            $media->update($request->all());
            $datas = [ 'status'=>true ];
        }
        return response()->json($datas);
    }

    public function mediaBoxImageDestroy(Request $request){
        $datas = [ 'status'=>false ];
        if( $media = Media::find($request->get('id')) ){
            $src = $media->src;
            $media->delete();
            ASWHelper::deleteCover($src, $this->imageUploadPath);
            $datas = [ 'status'=>true ];
        }
        return response()->json($datas);
    }




}
