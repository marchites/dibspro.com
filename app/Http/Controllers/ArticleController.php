<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    //
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        $categories = Category::all();
        return view('article.index', compact('articles', 'categories'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return view('article.show', compact('article'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $articles = $category->articles()->latest()->paginate(10);
        return view('article.index', compact('articles', 'category'));
    }
}
