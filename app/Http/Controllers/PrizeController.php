<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prize;
use App\Models\Stock;
use App\Libraries\Common;
use Illuminate\Support\Collection;


class PrizeController extends Controller
{

    // 景品のデータ取得
    public function GetPrizeJsonData(Request $request) {

        // データ取得
        if ($request->key && $request->cate) {
            $prizes =
            Prize::where('name', 'LIKE', '%' . $request->key . '%')
            ->where('category', $request->cate)
            ->get();

        } else if ($request->key) {
            $prizes =
            Prize::where('name', 'LIKE', '%' . $request->key . '%')
            ->get();

        } else if ($request->cate) {
            $prizes =
            Prize::where('category', $request->cate)
            ->get();

        } else {
            $prizes = Prize::all();
        }

        // 景品ごとに一番早い在庫の情報を追加
        foreach ($prizes as $prize) {
            $stocks = Prize::find($prize->id)->stocks;
            list(
                $prize['expired_at'],
                $prize['limit_at'],
                $prize['daysLeft']
                ) = Common::GetThoseDaysFirst($stocks, $prize);

            $prize['disabled'] = false;
        }

        // 景品を賞味期限順に並び替え
        if (!$prizes->isEmpty()) {
            $prizes = Common::sortByKey('expired_at', SORT_ASC, $prizes);
        }

        $categories = Common::GetPrizeCategories();

        return [
            'prizes' => $prizes,
            'categories' => $categories,
        ];
    }

    // 景品作成
    public function PostPrizeCreate(Request $request) {
        $prize = new Prize();
        $prize->create([
            'name' => $request->name,
            'category' => $request->category,
            'price_per_box' => $request->pricePerBox,
            'snp_per_box' => $request->snpPerBox,
            'img' => $request->img,
        ]);
    }

    // 景品の詳細
    public function GetPrizeDetail($id) {
        $prizes = Prize::find($id);
        return view('prize_detail', compact('id', 'prizes'));
    }

    // 景品削除
    public function PostPrizeDelete(Request $request) {

        // 景品の情報取得、削除
        $prizes = Prize::whereIn('id', $request->id)->get();
        foreach ($prizes as $prize) {
            $prize->stocks;
            $prize->delete();
        }

        return true;
    }

    // 指定した景品の在庫の情報を全取得
    public function GetStockJsonData(Request $request) {

        // 景品のidから在庫のデータを取得
        $stocks = Prize::find($request->prizeId)->stocks;

        // 使用期限、残り日数を作成
        // ボタンに付与するdisabled属性の値を付与
        list($thoseDays['limit_at'], $thoseDays['daysLeft']) = Common::GetThoseDays($stocks);
        $i = 0;
        foreach ($stocks as $stock) {
            $stock['limit_at'] = $thoseDays['limit_at'][$i];
            $stock['daysLeft'] = $thoseDays['daysLeft'][$i];

            $stock['disabled'] = false;

            $i++;
        }

        return [
            'stocks' => $stocks,
        ];
    }

    // 在庫追加
    public function PostStockAdd(Request $request) {
        $stock = new Stock();
        $stock->create([
            'prize_id' => $request->submitPrize_id,
            'taste' => $request->submitTaste,
            'expired_at' => $request->submitExpired_at,
            'memo' => $request->submitMemo,
        ]);

        return true;
    }

    // 在庫の概要編集
    public function PostStockEdit(Request $request) {

        // 変更するデータのid、変更内容を配列で取得
        $id = $request->submitId;
        $memo = $request->submitMemo;

        for ($i = 0; $i < count($id); $i++) {
            $stocks = Stock::find($id[$i]);
            $stocks->update([
                'memo' => $memo[$i],
            ]);
        };

        return true;
    }

    // 在庫削除
    public function PostStockDelete(Request $request) {

        // 削除するデータのidを配列で取得
        $id = $request->submitId;

        for ($i = 0; $i < count($id); $i++) {
            $stocks = Stock::find($id[$i]);
            $stocks->delete();
        };

        return true;
    }
}
