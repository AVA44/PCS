<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $taste = [
            'いちご', 'ぶどう', 'メロン', 'りんご', 'ストロベリー', 'ソーダ', 'コーラ', 'アップル', 'グレープ', 'レモン'
        ];
        $date = mt_rand(strtotime('2024-6-1'), strtotime('2025-6-1'));
        return [
                'prize_id' => mt_rand(1, 50),
                'taste' => $taste[array_rand($taste, 1)],
                'expired_at' => date('Y-m-d', $date),
                'created_at' => date("Y-m-d"),
                'updated_at' => date("Y-m-d"),
        ];
    }
}
