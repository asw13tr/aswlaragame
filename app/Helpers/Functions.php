<?php
// TABLO ÜSTÜ NAVİGASYON
function listTableNavigation($url, $furl=null){
     $pars = [ ""     => "Tümü",
               "?s=published" => "Yayımlanan",
               "?s=draft"   => "Taslak",
               "?s=trash"   => "Çöp Kutusu"     ];
     $result = '<div class="asw-table-nav">';
     foreach ($pars as $k => $v) {
          $jurl = $url.$k;
          $class = $furl==$jurl? 'class="active"' : null ;
          $result .= '<a href="'.$jurl.'" '.$class.'>'.$v.'</a>';
     }
     $result .= '</div>';
     return $result;
}


// UYARI MESAJLARI
function setAlert($msg, $class="success", $location="main"){
     Session::flash("{$location}-flash-alert-message", $msg);
     Session::flash("{$location}-flash-alert-class", $class);
}
function setAlertFixed($msg, $class="success"){
     Session::flash("fixed-flash-alert-message", $msg);
     Session::flash("fixed-flash-alert-class", $class.' alert-fixed');
}
function getAlert($location = "main"){
     $result = null;
     if(Session::has("{$location}-flash-alert-message")){
          $msg = Session::get("{$location}-flash-alert-message");
          $class = Session::get("{$location}-flash-alert-class");
          $result = '<div class="alert alert-'.$class.' p10">'.$msg;
          $result .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
     }
     return $result;
}


// ALT KATEGORİLİ SİSTEM
function getCategoriesWithSub($parent = 0, $repeat = -1, $status='published'){
     $items = null;
     $categories = App\BlogCategory::where('parent', $parent);
     if($status!=null){ $categories = $categories->where('status',  $status); }
     $categories = $categories->orderBy('title', 'asc');
     if($categories->count() > 0){
          $items = array();
          $repeat++;
          foreach($categories->cursor() as $category){
               array_push($items, [
                    'id' => $category->id,
                    'title' => $category->title,
                    'description' => $category->description,
                    'slug' => $category->slug,
                    'status' => $category->status,
                    'parent' => $category->parent,
                    'repeat' => $repeat
               ]);
               $subItems = getCategoriesWithSub($category->id, $repeat, $status);
               if($subItems != null){
                    $items = array_merge($items, $subItems);
               }
          }
     }
     return $items;
}


// ALT KATEGORİLİ SİSTEM OYUN KATEGORİLERİ
function getGameCategoriesWithSub($parent = 0, $repeat = -1, $status='published'){
     $items = null;
     $categories = App\GameCategory::where('parent', $parent);
     if($status!=null){ $categories = $categories->where('status',  $status); }
     $categories = $categories->orderBy('title', 'asc');
     if($categories->count() > 0){
          $items = array();
          $repeat++;
          foreach($categories->cursor() as $category){
               array_push($items, [
                    'id' => $category->id,
                    'title' => $category->title,
                    'description' => $category->description,
                    'slug' => $category->slug,
                    'status' => $category->status,
                    'parent' => $category->parent,
                    'cover' => $category->cover,
                    'repeat' => $repeat
               ]);
               $subItems = getGameCategoriesWithSub($category->id, $repeat, $status);
               if($subItems != null){
                    $items = array_merge($items, $subItems);
               }
          }
     }
     return $items;
}


function getUsers($level = null, $status = null){
    $users = App\User::orderBy('name', 'asc');
    if($level != null){
        $level = is_array($level)? $level : array($level);
        $users = $users->whereIn('level', $level);
    }
    if($status != null){
        $status = is_array($status)? $status : array($status);
        $users = $users->whereIn('status', $status);
    }
    return $users->get();
}


// KÜÇÜK SERİM OLUŞTURMAK
function aswUploadImage($s, $size, $p){
    $ext = explode('.', $p);
    $ext = end($ext);
    if( in_array($size, ['lg', 'large', 'big', 'xl', 'xlarge', 'buyuk', 'l']) ){
        $w = asw('img_lg_w');       $h = asw('img_lg_h');       $crop = asw('img_lg_crop');     $q = asw('img_lg_quality');
    }elseif( in_array($size, ['md', 'medium', 'med', 'm', 'orta']) ){
        $w = asw('img_md_w');       $h = asw('img_md_h');       $crop = asw('img_md_crop');     $q = asw('img_md_quality');
    }elseif( in_array($size, ['sm', 'small', 'xs', 'xsmall', 'thumb', 'thumbnail', 's', 'kucuk', 'mini']) ){
        $w = asw('img_sm_w');       $h = asw('img_sm_h');       $crop = asw('img_sm_crop');     $q = asw('img_sm_quality');
    }else{
        $w=null; $h=null; $crop=null; $q=null;
    }

    if($crop != 1){
        if(!$size){
            $img = Image::make($s);
        }else{
            $img = Image::make($s)->resize($w, $h, function($constraint){    $constraint->aspectRatio();    });
        }
    }else{
        $img = Image::make($s)->fit($w, $h);
    }
    return $img->save($p, $q, $ext);
}



// DOSYA SİLME FONKSİYONU
function deleteFile($paths){
     if( !is_array($paths) ){ $paths = [$paths]; }
     foreach( $paths as $path ){
          if( file_exists($path) ){ @unlink($path); }
     }
}

// KAPAK FOTOĞRAFINI GETİR
function getImageSrc($img, $which=null, $before='media'){
    switch ($which) {
        case 'sm':          case 'small':     case 'xs':
        case 'kucuk':       case 'küçük':     case 'thumb':
        case 'thumbnail':   case 's':         case 'mini':
            $file = $before.'/sm_'.$img;
            $result = !file_exists(public_path($file))? getImageSrc($img, 'md', $before) : url($file);
            break;

        case 'md':          case 'medium':     case 'med':
        case 'orta':        case 'm':
            $file = $before.'/md_'.$img;
            $result = !file_exists(public_path($file))? getImageSrc($img, 'lg', $before) : url($file);
            break;

        case 'lg':          case 'large':     case 'lar':
        case 'buyuk':       case 'büyük':     case 'l':
            $file = $before.'/lg_'.$img;
            $result = !file_exists(public_path($file))? getImageSrc($img, null, $before) : url($file);
            break;

        default:
            $file = $before.'/'.$img;
            $result = !file_exists(public_path($file))? getImageSrc($img, 'lg', $before) : url($file);
            //$result = asw('img_allow_original')==1? url($before.'/'.$img) : $result = url($before.'/lg_'.$img);
            break;
    }
    return $result;
}
function getArticleCover($img, $which=null){        return getImageSrc($img, $which, asw('path_media_article'));             }
function getGameCategoryCover($img, $which=null){   return getImageSrc($img, $which, asw('path_media_game_category'));       }
function getGameCover($img, $which=null){           return getImageSrc($img, $which, asw('path_media_game'));                }
function getPageCover($img, $which=null){           return getImageSrc($img, $which, asw('path_media_page'));                }
function getUserCover($img, $which=null){           return getImageSrc($img, $which, asw('path_media_user'));                }

// TRUE VE FALSE SONUÇLARI İÇİN FONKSİYON
function getBool($v1, $v2, $t=true, $f=false){ return $v1==$v2? $t : $f; }

// DATABASEDEN GELEN TIMESTAMP VERİLERİNİ DATETIME-LOCAL İNPUTUNA GÖRE DÜZENLEME
function timestampToDatetime($getDate=null){
    if($getDate != null){
        list($date, $time) = explode(' ', $getDate);
        $getDate = date( $date.'\T'.substr($time, 0, 5) );
    }
    return $getDate;
}

// DB TIMESTAMP DAN GELEN VERİYİ ANLAŞILIR ŞEKİLDE YAZDIRMAK
function moonToString($m=1){
    $aylar = array(
        1 => 'Ocak',        2 => 'Şubat',       3 => 'Mart',        4 => 'Nisan',
        5 => 'Mayıs',       6 => 'Haziran',     7 => 'Temmuz',      8 => 'Ağustos',
        9 => 'Eylül',       10 => 'Ekim',       11 => 'Kasım',      12 => 'Aralık',
    );
    return $aylar[(int)$m];
}
function timestampToString($getDate=null){
    global $aylar;
    list($date, $time) = explode(' ', $getDate);
    list($y, $m, $d) = explode('-', $date);
    $moon = moonToString($m);
    return "{$d} {$moon} {$y} ".substr($time, 0, 5);
}

function getStatusLabel($status){
    switch($status){
        case "published":   $r = '<span class="label label-success">Yayımlanmış</span>'; break;
        case "draft":   $r = '<span class="label label-warning">Taslak</span>'; break;
        case "trash":   $r = '<span class="label label-danger">Çöp</span>'; break;
        default: $r = '<span class="label label-danger">Hata</span>'; break;
    }
    return $r;
}


function getImgInfo($img, $info = 'name'){
    $result = null;
    switch($info){
        case 'name':
        case 'title':
            $img = explode('/', str_replace('\\', '/', $img));
            $img = explode('.', end($img));
            array_pop($img);
            $result = implode('-', $img);
        break;

        case 'size':
            list($w, $h) = getimagesize($img);
            $result = [ 'width' => $w, 'height' => $h ];
        break;



        default:
            $result = null;



    }
    return $result;
}



function byteToStr($bytes){
    if ($bytes >= 1073741824){
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }elseif ($bytes >= 1048576){
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }elseif ($bytes >= 1024){
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }elseif ($bytes > 0){
        $bytes = $bytes . ' byte';
    }else{
        $bytes = '0 bytes';
    }
    return $bytes;
}
?>
