<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Article;
use App\Models\Setting;
use App\Models\PropertyImage;
use App\Models\ArticleCategory;
use App\Models\PropertyView;
use App\Models\PropertyClick;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function index()
    {
        $totalProperties = Property::count();

        $totalViews = PropertyView::count();

        $totalWhatsappClicks = PropertyClick::where(
            'type',
            'whatsapp'
        )->count();

        $todayViews = PropertyView::whereDate(
            'created_at',
            today()
        )->count();

        $monthViews = PropertyView::whereMonth(
            'created_at',
            now()->month
        )
            ->whereYear(
                'created_at',
                now()->year
            )
            ->count();

        $todayWhatsapp = PropertyClick::where(
            'type',
            'whatsapp'
        )
            ->whereDate(
                'created_at',
                today()
            )
            ->count();

        $monthWhatsapp = PropertyClick::where(
            'type',
            'whatsapp'
        )
            ->whereMonth(
                'created_at',
                now()->month
            )
            ->whereYear(
                'created_at',
                now()->year
            )
            ->count();

        $dailyViews = PropertyView::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total')
        )
            ->whereDate(
                'created_at',
                '>=',
                now()->subDays(30)
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $topProperties = Property::withCount('views')
            ->orderByDesc('views_count')
            ->take(10)
            ->get();

        $yearViews = PropertyView::whereYear(
            'created_at',
            now()->year
        )->count();

        $yearWhatsapp = PropertyClick::where('type', 'whatsapp')
            ->whereYear('created_at', now()->year)
            ->count();

        $dailyViews = PropertyView::select(
            DB::raw('DATE(created_at) as label'),
            DB::raw('COUNT(*) as total')
        )
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        $monthlyViews = PropertyView::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as label'),
            DB::raw('COUNT(*) as total')
        )
            ->whereDate('created_at', '>=', now()->subMonths(12))
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        $yearlyViews = PropertyView::select(
            DB::raw('YEAR(created_at) as label'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('label')
            ->orderBy('label')
            ->get();

        $pendingProperties = Property::with('user')
            ->where('approval_status', 'pending')
            ->latest()
            ->get();

        return view('dashboard.admin.index', [
            'totalProperties' => $totalProperties,
            'totalViews' => $totalViews,
            'totalWhatsappClicks' => $totalWhatsappClicks,
            'todayViews' => $todayViews,
            'monthViews' => $monthViews,
            'todayWhatsapp' => $todayWhatsapp,
            'monthWhatsapp' => $monthWhatsapp,
            'dailyViews' => $dailyViews,
            'topProperties' => $topProperties,
            'featuredProperties' => Property::where('is_featured', true)->count(),
            'totalArticles' => Article::count(),
            'latestProperties' => Property::latest()->take(5)->get(),
            'yearViews' => $yearViews,
            'yearWhatsapp' => $yearWhatsapp,
            'monthlyViews' => $monthlyViews,
            'yearlyViews' => $yearlyViews,
            'pendingProperties' => $pendingProperties,
        ]);
    }

    public function properties()
    {
        $properties = Property::with(['images', 'user'])->latest()->paginate(10);
        return view('dashboard.admin.properties.index', compact('properties'));
    }

    public function createProperty()
    {
        return view('dashboard.admin.properties.create');
    }

    public function storeProperty(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,heic|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi|max:51200',
        ]);

        $videoPath = null;

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')
                ->store('property-videos', 'public');
        }

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
            'phone' => $request->phone,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'available',
            'user_id' => Auth::id(),
            'video' => $videoPath,
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

        return view('dashboard.admin.properties.edit', compact('property'));
    }

    public function updateProperty(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $request->validate(['title' => 'required', 'price' => 'required|numeric', 'location' => 'required', 'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',]);

        $videoPath = $property->video;

        if ($request->hasFile('video')) {
            if ($property->video) {
                Storage::disk('public')->delete($property->video);
            }

            $videoPath = $request->file('video')
                ->store('property-videos', 'public');
        }

        $property->update([
            'title' => $request->title,
            'price' => $request->price,
            'location' => $request->location,
            'description' => $request->description,
            'bedroom' => $request->bedroom,
            'bathroom' => $request->bathroom,
            'land_size' => $request->land_size,
            'building_size' => $request->building_size,
            'phone' => $request->phone,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_featured' => $request->is_featured ? 1 : 0,
            'video' => $videoPath,
        ]);

        /* |-------------------------------------------------------------------------- | UPLOAD MULTIPLE IMAGE |-------------------------------------------------------------------------- */
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');
                $property->images()->create(['image_path' => $path]);
            }
        }

        return redirect('/dashboard/properties')
            ->with('success', 'Properti berhasil diupdate');
    }

    public function deleteProperty($id)
    {
        $property = Property::findOrFail($id);

        // Hapus video
        if ($property->video) {
            Storage::disk('public')->delete($property->video);
        }

        // Hapus semua image
        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $property->delete();

        return back()->with('success', 'Properti berhasil dihapus');
    }


    public function deletePropertyImage($id)
    {
        $image = PropertyImage::findOrFail($id);

        /*
    |--------------------------------------------------------------------------
    | DELETE FILE STORAGE
    |--------------------------------------------------------------------------
    */

        if (Storage::disk('public')->exists($image->image_path)) {

            Storage::disk('public')->delete($image->image_path);
        }

        /*
    |--------------------------------------------------------------------------
    | DELETE DATABASE
    |--------------------------------------------------------------------------
    */

        $image->delete();

        return back()->with('success', 'Foto berhasil dihapus');
    }

    public function approveProperty($id)
    {
        $property = Property::findOrFail($id);

        $property->update([
            'approval_status' => 'approved'
        ]);

        return back()->with('success', 'Properti berhasil disetujui');
    }

    public function rejectProperty($id)
    {
        $property = Property::findOrFail($id);

        $property->update([
            'approval_status' => 'rejected'
        ]);

        return back()->with('success', 'Properti ditolak');
    }


    public function articles()
    {
        $articles = Article::latest()->paginate(10);
        return view('dashboard.admin.articles.index', compact('articles'));
    }

    public function createArticle()
    {
        $categories = ArticleCategory::latest()->get();

        return view(
            'dashboard.admin.articles.create',
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
            'dashboard.admin.articles.edit',
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

        return view('dashboard.admin.settings.index', compact('settings'));
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

    public function deletePropertyVideo($id)
    {
        $property = Property::findOrFail($id);

        if ($property->video) {
            Storage::disk('public')->delete($property->video);

            $property->update([
                'video' => null
            ]);
        }

        return back()->with('success', 'Video berhasil dihapus');
    }
}
