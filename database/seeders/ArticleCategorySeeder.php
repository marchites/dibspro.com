<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ArticleCategory;
use Illuminate\Support\Str;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [

            'Tips Properti',

            'Investasi',

            'KPR',

            'Interior',

            'Berita Properti',

        ];

        foreach($categories as $category)
        {
            ArticleCategory::create([

                'name' => $category,

                'slug' => Str::slug($category),

            ]);
        }
    }
}
