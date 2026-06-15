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
        $featuredProperties = Property::with('images')->where('is_featured', 1)->latest()->get();

        // Properti terbaru
        $properties = Property::where('approval_status', 'approved')->latest()->take(6)->get();

        // Artikel
        $articles = Article::latest()->take(3)->get();

        return view('frontend.home.index', compact('featuredProperties', 'properties', 'articles'));
    }
}
