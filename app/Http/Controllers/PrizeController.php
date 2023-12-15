<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prize;
use App\Models\Stock;
use App\Libraries\Common;
use Illuminate\Support\Collection;


class PrizeController extends Controller
{
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


        return [
            'prizes' => $prizes,
        ];
    }

    public function PrizeCreate(Request $request) { // 景品作成
        $prize = new Prize();
        $prize->create([
            'name' => $request->name,
            'category' => $request->category,
            'price_per_box' => $request->pricePerBox,
            'snp_per_box' => $request->snpPerBox,
            'img' => $request->img,
        ]);
    }

    public function PrizeDetail($id) {
        $prizes = Prize::find($id);

        return view('prize_detail', compact('id', 'prizes'));
    }

    public function StockAdd(Request $request) {
        $stock = new Stock();
        $stock->create([
            'prize_id' => $request->submitPrize_id,
            'taste' => $request->submitTaste,
            'expired_at' => $request->submitExpired_at,
            'memo' => $request->submitMemo,
        ]);


        return true;
    }

    public function StockEdit(Request $request) {
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

    public function StockDelete(Request $request) {
        $id = $request->submitId;
        $memo = $request->submitMemo;

        for ($i = 0; $i < count($id); $i++) {
            $stocks = Stock::find($id[$i]);
            $stocks->delete();
        };

        return true;
    }

    public function GetStockJsonData(Request $request) {
        $stocks = Prize::find($request->prizeId)->stocks;

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

    public function PrizeDelete() {
        return view('prize_delete');
    }

    public function PrizeDestroy(Request $request) {
        $prizes = Prize::whereIn('id', $request->id)->get();
        foreach ($prizes as $prize) {
            $prize->stocks;
            $prize->delete();
        }


        return $prizes;
    }
}
