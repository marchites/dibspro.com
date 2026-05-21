<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $properties = [
            [
                'title' => 'Rumah Minimalis Modern Bandung',
                'price' => 750000000,
                'location' => 'Bandung, Cimahi',
                'type' => 'rumah',
                'listing_type' => 'secondary',
                'bedroom' => 3,
                'bathroom' => 2,
                'land_size' => 100,
                'building_size' => 80,
                'description' => 'Rumah siap huni, dekat sekolah dan pusat kota.',
                'is_featured' => true,
                'phone' => '6287700755297'
            ],
            [
                'title' => 'Apartemen Strategis Dago',
                'price' => 500000000,
                'location' => 'Bandung, Dago',
                'type' => 'apartemen',
                'listing_type' => 'secondary',
                'bedroom' => 2,
                'bathroom' => 1,
                'land_size' => 50,
                'building_size' => 50,
                'description' => 'Cocok untuk mahasiswa dan investasi.',
                'is_featured' => false,
                'phone' => '6287700755297'
            ],
            [
                'title' => 'Tanah Kavling Murah Bandung Timur',
                'price' => 300000000,
                'location' => 'Bandung Timur',
                'type' => 'tanah',
                'listing_type' => 'primary',
                'bedroom' => null,
                'bathroom' => null,
                'land_size' => 120,
                'building_size' => null,
                'description' => 'Tanah siap bangun, akses jalan lebar.',
                'is_featured' => false,
                'phone' => '6287700755297'
            ],
        ];

        foreach ($properties as $data) {

            $property = Property::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'price' => $data['price'],
                'location' => $data['location'],
                'city' => 'Bandung',
                'type' => $data['type'],
                'listing_type' => $data['listing_type'],
                'bedroom' => $data['bedroom'],
                'bathroom' => $data['bathroom'],
                'land_size' => $data['land_size'],
                'building_size' => $data['building_size'],
                'description' => $data['description'],
                'is_featured' => $data['is_featured'],
                'phone' => $data['phone'],
            ]);

            // Tambahkan beberapa gambar
            for ($i = 1; $i <= 3; $i++) {
                PropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => 'https://via.placeholder.com/400x300?text=Property+' . $i
                ]);
            }
        }
    }
}
