<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    public function index()
    {
        return view('dashboard.agent.index');
    }

    public function properties()
    {
        $properties = Property::with('images')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view(
            'dashboard.agent.properties.index',
            compact('properties')
        );
    }

    public function createProperty()
    {
        return view('dashboard.agent.properties.create');
    }

    public function storeProperty(Request $request)
    {   
        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'location' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,heic|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi|max:51200',
        ]);

        $videoPath = null;

        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')
                ->store('property-videos', 'public');
        }

        $property = Property::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title . ' ' . $request->location . '-' . time()),
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
            'approval_status' => 'pending',
            'is_featured' => 0,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');

                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()
            ->route('agent.properties.index')
            ->with('success', 'Properti berhasil dibuat dan menunggu approval admin');
    }

    public function editProperty($id)
    {
        $property = Property::where('user_id', Auth::id())
            ->findOrFail($id);

        return view(
            'dashboard.agent.properties.edit',
            compact('property')
        );
    }

    public function updateProperty(Request $request, $id)
    {
        $property = Property::where('user_id', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'location' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'video' => 'nullable|mimes:mp4,mov,avi|max:51200',
        ]);

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
            'video' => $videoPath,
            'approval_status' => 'pending',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('properties', 'public');

                $property->images()->create([
                    'image_path' => $path
                ]);
            }
        }

        return redirect()
            ->route('agent.properties.index')
            ->with('success', 'Properti berhasil diupdate dan menunggu approval admin');
    }

    public function deleteProperty($id)
    {
        $property = Property::where('user_id', Auth::id())
            ->findOrFail($id);

        foreach ($property->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        if ($property->video) {
            Storage::disk('public')->delete($property->video);
        }

        $property->delete();

        return back()->with('success', 'Properti berhasil dihapus');
    }

    public function deletePropertyImage($id)
    {
        $image = PropertyImage::findOrFail($id);

        if ($image->property->user_id != Auth::id()) {
            abort(403);
        }

        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return back()->with('success', 'Foto berhasil dihapus');
    }

    public function togglePropertyStatus($id)
    {
        $property = Property::where('user_id', Auth::id())
            ->findOrFail($id);

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
}