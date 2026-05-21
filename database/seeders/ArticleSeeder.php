<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
          $articles = [
            [
                'title' => 'Tips Membeli Rumah Pertama',
                'content' => 'Membeli rumah pertama adalah langkah besar. Pastikan Anda mempertimbangkan lokasi, harga, dan fasilitas sekitar.',
            ],
            [
                'title' => 'Cara Investasi Properti di Bandung',
                'content' => 'Bandung adalah kota dengan potensi investasi properti yang tinggi. Pilih lokasi strategis untuk hasil maksimal.',
            ],
            [
                'title' => 'Perbedaan Rumah Primary dan Secondary',
                'content' => 'Rumah primary dibeli langsung dari developer, sedangkan secondary dari pemilik sebelumnya.',
            ],
        ];

        foreach ($articles as $data) {
            Article::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'content' => $data['content'],
                'thumbnail' => 'https://via.placeholder.com/150',
                'category_id' => 1
            ]);
        }
    }
}
