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
        $featuredProperties = Property::with('images')
            ->where('approval_status', 'approved')
            ->where('is_featured', 1)
            ->latest()
            ->get();

        // Properti terbaru
        $properties = Property::with('images')
            ->where('approval_status', 'approved')
            ->latest()
            ->take(6)
            ->get();

        // Tambahkan bg_image ke setiap property
        foreach ($properties as $property) {
            $imagePath = $property->images->first()?->image_path;

            $property->bg_image = $imagePath
                ? asset('storage/' . $imagePath)
                : 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1470&auto=format&fit=crop';
        }

        foreach ($featuredProperties as $property) {
            $imagePath = $property->images->first()?->image_path;

            $property->bg_image = $imagePath
                ? asset('storage/' . $imagePath)
                : 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1470&auto=format&fit=crop';
        }

        // Artikel
        $articles = Article::latest()->take(3)->get();

        return view('frontend.home.index', compact(
            'featuredProperties',
            'properties',
            'articles'
        ));
    }
}
