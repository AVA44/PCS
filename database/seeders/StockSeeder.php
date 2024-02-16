<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stock;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $taste = ['りんご', 'ぶどう', 'メロン', 'いちご', 'コーラ', 'ソーダ', 'チョコ', 'コーヒー', 'ココア', 'プレーン'];
        $start = strtotime(date('Y-m-d'));
        $end = strtotime(date('Y-m-d', strtotime('2025-12-31')));

        // データ保存
        for ($i = 1; $i <= 200; $i++) {
            $randDate = rand($start, $end);

            Stock::insert([
                'prize_id' => rand(1, 50),
                'taste' => $taste[array_rand($taste, 1)],
                'expired_at' => date('Y-m-d', $randDate),
                'memo' => '',
            ]);
        }
    }
}
