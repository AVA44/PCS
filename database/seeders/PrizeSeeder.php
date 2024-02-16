<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prize;

class PrizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $prize_data = [];
        $search_key = ['-ice-', '-cookie-', '-biscuit-', '-cake-', '-tart', '-chocolate-', '-pie-'];
        $category = ['A', 'B', 'C', 'D', 'E'];

        // データ保存
        for ($i = 1; $i <= 50; $i++) {

            Prize::insert([
                'name' => 'prize' . $search_key[array_rand($search_key, 1)] . $i,
                'category' => 'category' . $category[array_rand($category, 1)],
                'price_per_box' => rand(30000, 70000),// 一箱の値段
                'snp_per_box' => rand(30, 300),// 一箱に入ってる数
                'img' => '',// 画像のバイナリデータ
            ]);
        };
    }
}
