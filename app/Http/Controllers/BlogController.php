<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use App\BlogCategory;

class BlogController extends Controller{


    public function index(){
        $datas = [
                'headTitle' => 'Blog',
                'headDescription' => 'Asw lara game description',
                'cclass' => 'blog',
                'items' => Article::where('status', 'published')->orderBy('id', 'desc')->paginate(10)
        ];
        return view('blog', $datas);
    }

    public function filterCategory($slug){
        $category = BlogCategory::where('status', 'published')->where('slug', $slug)->first();
        $articles = Article::whereHas('categories', function($q) use($slug){
            $q->where('slug', $slug);
        })->where('status', 'published')->orderBy('id', 'desc')->paginate(10);
        $datas = [
                'headTitle' => $category->title,
                'headDescription' => $category->description,
                'cclass' => 'blog',
                'items' => $articles,
                'category' => $category
        ];
        return view('blog', $datas);
    }

    public function detail(Request $request, $slug){
        $article = Article::where('status', 'published')->where('slug', $slug)->first();
        $datas = [
                'headTitle' => $article->title,
                'headDescription' => $article->getDescription(),
                'cclass' => 'single',
                'item' => $article
        ];

        if(!$request->session()->get('viewblog_'.$article->id, false)){
            $article->update(['views' => $article->views + 1]);
            $request->session()->put('viewblog_'.$article->id, true);
        }

        return view('blog-detail', $datas);
    }


}
