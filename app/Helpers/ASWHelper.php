<?php
namespace app\Helpers;
use Illuminate\Http\Request;

class ASWHelper{

    static function deleteCover($cover=null, $path='media'){
        if($cover!=null){
            $paths = [
                 public_path($path.'/'.$cover),
                 public_path($path.'/lg_'.$cover),
                 public_path($path.'/md_'.$cover),
                 public_path($path.'/sm_'.$cover)
            ];
            deleteFile($paths);
        }
    }


    static function uploadCover(Request $request, $item=null, $coverImgName = null, $path = 'media'){
        if( $request->get('removeCover', 0)==1 && $item->cover ){
            ASWHelper::deleteCover($coverImgName, $path);
            $coverImgName = null;
        }

        if( $img = $request->file('cover') ){
            ASWHelper::deleteCover($coverImgName, $path);
            $coverImgName = substr($item->slug, 0, 60).'__'.time().'.'.$img->getClientOriginalExtension();
            aswUploadImage($img->getRealpath(), 'lg', public_path($path.'/lg_' . $coverImgName));
            aswUploadImage($img->getRealpath(), 'md', public_path($path.'/md_' . $coverImgName));
            aswUploadImage($img->getRealpath(), 'sm', public_path($path.'/sm_' . $coverImgName));
            if( asw('img_allow_original') == 1 ){
                aswUploadImage($img->getRealpath(), null, public_path($path.'/' . $coverImgName));
            }
        }

        return $coverImgName;
    }


}

?>
