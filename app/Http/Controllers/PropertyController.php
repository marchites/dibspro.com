<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\PropertyClick;
use App\Models\PropertyView;

class PropertyController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Property::query();

        // 🔍 Keyword search
        if ($request->keyword) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                    ->orWhere('location', 'like', '%' . $request->keyword . '%');
            });
        }

        // 📍 Lokasi
        if ($request->city) {
            $query->where('city', $request->city);
        }

        // 🏠 Tipe properti
        if ($request->type) {
            $query->where('type', $request->type);
        }

        // 💰 Harga
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Urutan terbaru + pagination
        $properties = $query->latest()->paginate(10);

        return view('property.index', compact('properties'));
    }

    public function show($slug)
    {
        $property = Property::where('slug', $slug)->firstOrFail();

         $sessionKey = 'property_viewed_'.$property->id;

        if (!session()->has($sessionKey)) {

            PropertyView::create([
                'property_id' => $property->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            session([$sessionKey => true]);
        }
        
        return view('property.show', compact('property'));
    }

    public function toggleFavorite(Request $request)
    {
        $favorites = session()->get('favorites', []);

        $id = $request->property_id;

        if (in_array($id, $favorites)) {
            // remove
            $favorites = array_diff($favorites, [$id]);
        } else {
            // add
            $favorites[] = $id;
        }

        session(['favorites' => $favorites]);

        return response()->json([
            'status' => 'success',
            'favorites' => $favorites
        ]);
    }

    public function favoriteList()
    {
        $favorites = session()->get('favorites', []);

        $properties = Property::whereIn('id', $favorites)->get();

        return view('property.favorite', compact('properties'));
    }

    public function whatsapp(Property $property)
    {
        PropertyClick::create([
            'property_id' => $property->id,
            'type' => 'whatsapp',
            'ip_address' => request()->ip(),
        ]);

        return redirect()->away(
            'https://wa.me/' . preg_replace('/[^0-9]/', '', $property->phone)
        );
    }
}
