<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    //
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        $categories = Category::all();
        return view('frontend.article.index', compact('articles', 'categories'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return view('frontend.article.show', compact('article'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $articles = $category->articles()->latest()->paginate(10);
        return view('frontend.article.index', compact('articles', 'category'));
    }
}
