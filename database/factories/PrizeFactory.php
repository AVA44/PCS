<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prize>
 */
class PrizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category = ['category1', 'category2', 'category3', 'category4', 'category5', 'category6'];
        return [
            'name' => Str::random('10'),
            'category' => $category[array_rand($category, 1)],
            'price_per_box' => mt_rand(20000, 40000),
            'snp_per_box' => mt_rand(15, 100),
            'img' => 000000,
            'created_at' => date("Y-m-d"),
            'updated_at' => date("Y-m-d"),
        ];
    }
}
