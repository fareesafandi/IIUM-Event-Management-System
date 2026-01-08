<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Sports',
                'description' => 'Sports and physical activities events',
                'icon' => '⚽',
                'slug' => 'sports',
            ],
            [
                'name' => 'Academic',
                'description' => 'Academic conferences, seminars, and workshops',
                'icon' => '📚',
                'slug' => 'academic',
            ],
            [
                'name' => 'Cultural',
                'description' => 'Cultural events, festivals, and performances',
                'icon' => '🎭',
                'slug' => 'cultural',
            ],
            [
                'name' => 'Religious',
                'description' => 'Religious events, talks, and gatherings',
                'icon' => '🕌',
                'slug' => 'religious',
            ],
            [
                'name' => 'Entertainment',
                'description' => 'Entertainment and recreational events',
                'icon' => '🎬',
                'slug' => 'entertainment',
            ],
            [
                'name' => 'Community Service',
                'description' => 'Community service and volunteer activities',
                'icon' => '🤝',
                'slug' => 'community-service',
            ],
            [
                'name' => 'Career & Development',
                'description' => 'Career development workshops and job fairs',
                'icon' => '💼',
                'slug' => 'career-development',
            ],
            [
                'name' => 'Social',
                'description' => 'Social gatherings and networking events',
                'icon' => '👥',
                'slug' => 'social',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
