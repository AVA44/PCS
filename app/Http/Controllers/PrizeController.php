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

        foreach ($prizes as $prize) {  // 景品ごとに一番早い在庫の情報を追加
            $stocks = Prize::find($prize->id)->stocks;
            list(
                $prize['expired_at'],
                $prize['limit_at'],
                $prize['daysLeft']
                ) = Common::GetThoseDaysFirst($stocks, $prize);

            $prize['disabled'] = false;
        }

        if (!$prizes->isEmpty()) { // 景品を賞味期限順に並び替え
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
        $add = 'add';
        return $add;
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
}
