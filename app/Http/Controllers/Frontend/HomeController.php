<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Article;

class HomeController extends Controller
{
    //
    public function index()
    {
        // Properti unggulan
        $featured = Property::where('is_featured', 1)
                    ->latest()
                    ->take(1)
                    ->get();

        // Properti terbaru
        $properties = Property::latest()->take(5)->get();

        // Artikel
        $articles = Article::latest()->take(3)->get();

        return view('frontend.home.index', compact('featured', 'properties', 'articles'));
    }
}
