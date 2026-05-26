<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Article;
use App\Models\Category;
use App\Models\Setting;
use App\Models\PropertyImage;
use App\Models\ArticleCategory;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    //
    public function index()
    {
        return view('dashboard.index', [
            'totalProperties' => Property::count(),
            'featuredProperties' => Property::where('is_featured', true)->count(),
            'totalArticles' => Article::count(),
            'latestProperties' => Property::latest()->take(5)->get(),
        ]);
    }

    public function properties()
    {
        $properties = Property::latest()->paginate(10);

        return view('dashboard.properties.index', compact('properties'));
    }

    public function createProperty()
    {
        return view('dashboard.properties.create');
    }

    public function storeProperty(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,heic|max:2048',
        ]);

        /*
    |--------------------------------------------------------------------------
    | CREATE PROPERTY
    |--------------------------------------------------------------------------
    */

        $property = Property::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title . ' ' . $request->location),
            'price' => $request->price,
            'location' => $request->location,
            'description' => $request->description,
            'bedroom' => $request->bedroom,
            'bathroom' => $request->bathroom,
            'building_size' => $request->building_size,
            'land_size' => $request->land_size,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'available',
        ]);

        /*
    |--------------------------------------------------------------------------
    | MULTIPLE IMAGE UPLOAD
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store(
                    'properties',
                    'public'
                );

                PropertyImage::create([

                    'property_id' => $property->id,

                    'image_path' => $path,

                ]);
            }
        }

        return redirect('/dashboard/properties')
            ->with('success', 'Properti berhasil dibuat');
    }

    public function editProperty($id)
    {
        $property = Property::findOrFail($id);

        return view('dashboard.properties.edit', compact('property'));
    }

    public function updateProperty(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $property->update([
            'title' => $request->title,
            'price' => $request->price,
            'location' => $request->location,
            'description' => $request->description,
            'bedroom' => $request->bedroom,
            'bathroom' => $request->bathroom,
            'land_size' => $request->land_size,
            'building_size' => $request->building_size,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'phone' => $request->phone,
            'is_featured' => $request->is_featured ? 1 : 0,
        ]);

        return redirect('/dashboard/properties')
            ->with('success', 'Properti berhasil diupdate');
    }

    public function deleteProperty($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return back()->with('success', 'Properti berhasil dihapus');
    }

    public function articles()
    {
        $articles = Article::latest()->paginate(10);
        return view('dashboard.articles.index', compact('articles'));
    }

    public function createArticle()
    {
        $categories = ArticleCategory::latest()->get();

        return view(
            'dashboard.articles.create',
            compact('categories')
        );
    }

    public function storeArticle(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'required|image',
        ]);

        /*
    |--------------------------------------------------------------------------
    | UPLOAD IMAGE
    |--------------------------------------------------------------------------
    */

        $thumbnail = $request->file('thumbnail')
            ->store('articles', 'public');

        /*
    |--------------------------------------------------------------------------
    | CREATE ARTICLE
    |--------------------------------------------------------------------------
    */
        Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title . '-' . time()),
            'thumbnail' => $thumbnail,
            'content' => $request->content,
            'category_id' => $request->category_id,
        ]);

        return redirect('/dashboard/articles')
            ->with('success', 'Artikel berhasil dibuat');
    }

    public function editArticle($id)
    {
        $article = Article::findOrFail($id);
        $categories = ArticleCategory::latest()->get();
        return view(
            'dashboard.articles.edit',
            compact('article', 'categories')
        );
    }

    public function updateArticle(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        /*
    |--------------------------------------------------------------------------
    | DEFAULT IMAGE
    |--------------------------------------------------------------------------
    */

        $thumbnail = $article->thumbnail;

        /*
    |--------------------------------------------------------------------------
    | IF UPLOAD NEW IMAGE
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')
                ->store('articles', 'public');
        }

        /*
    |--------------------------------------------------------------------------
    | UPDATE ARTICLE
    |--------------------------------------------------------------------------
    */

        $article->update([

            'title' => $request->title,

            'thumbnail' => $thumbnail,

            'content' => $request->content,

            'category_id' => $request->category_id,

        ]);

        return redirect('/dashboard/articles')
            ->with('success', 'Artikel berhasil diupdate');
    }

    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);

        $article->delete();

        return back()->with('success', 'Artikel berhasil dihapus');
    }

    public function togglePropertyStatus($id)
    {
        $property = Property::findOrFail($id);

        $property->status =
            $property->status == 'available'
            ? 'sold'
            : 'available';

        $property->save();

        return back()->with(
            'success',
            'Status properti berhasil diubah'
        );
    }

    public function settings()
    {
        $settings = Setting::pluck('value', 'key');

        return view('dashboard.settings.index', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $data = [

            'site_name' => $request->site_name,

            'tagline' => $request->tagline,

            'whatsapp' => $request->whatsapp,

            'email' => $request->email,

            'logo' => $request->logo,

        ];

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with(
            'success',
            'Setting berhasil diupdate'
        );
    }
}
