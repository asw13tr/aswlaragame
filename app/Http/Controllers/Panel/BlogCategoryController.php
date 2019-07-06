<?php

namespace App\Http\Controllers\Panel;
use App\Http\Controllers\Controller;

use App\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{

    public function __construct(){
        $this->middleware('panelAccessPermission');
    }

    public function index(Request $request){
        return view('panel/blog/categories', ['headTitle'=>'Kategoriler']);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $category = BlogCategory::create($request->all());
        setAlertFixed("Kategori Oluşturuldu.");
        return redirect( route('panel.blog.categories') );
    }


    public function show(BlogCategory $blogCategory)
    {
        //
    }


    public function edit(BlogCategory $blogCategory)
    {
        $categories = BlogCategory::whereNotIn('status', ["trash"])->orderBy('id','DESC')->get();
        $datas = [
          'items' => $categories,
          'category' => $blogCategory,
          'headTitle' => 'Kategoriyi düzenle'
        ];
        return view('panel/blog/categories', $datas);
    }


    public function update(Request $request, BlogCategory $blogCategory)
    {
        $blogCategory->update( $request->all() );
        setAlertFixed("Kategori güncelleme başarılı.");
        return redirect( route('panel.blog.categories') );
    }


    public function destroy(BlogCategory $blogCategory)
    {
          if($blogCategory->status == "trash"){
              $blogCategory->delete();
              setAlertFixed("Kategori tamamen silindi.");
          }else{
             $blogCategory->update( ['status'=> "trash"] );
             setAlertFixed("Kategori çöpe taşındı.");
          }
          return redirect( url()->previous() );
    }

    public function published(BlogCategory $blogCategory){
         $blogCategory->update( ['status'=>'published'] );
         setAlertFixed("Kategori yayımlandı.");
         return redirect( url()->previous() );
    }
    public function draft(BlogCategory $blogCategory){
         $blogCategory->update( ['status'=>'draft'] );
         setAlertFixed("Kategori taslak olarak kaydedildi..");
         return redirect( url()->previous() );
    }
}
