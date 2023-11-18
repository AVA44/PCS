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

        foreach ($prizes as $prize) {
            $stocks = Prize::find($prize->id)->stocks;
            list(
                $prize['expired_at'],
                $prize['limit_at'],
                $prize['daysLeft']
                ) = Common::GetThoseDays($stocks, $prize);

            $prize['disabled'] = false;
        }

        if (!$prizes->isEmpty()) {
            $prizes = Common::sortByKey('expired_at', SORT_ASC, $prizes);
        }

        return [
            'prizes' => $prizes,
        ];
    }

    public function PrizeCreate(Request $request) {
        $prize = new Prize();
        $prize->create([
            'name' => $request->name,
            'category' => $request->category,
            'price_per_box' => $request->pricePerBox,
            'snp_per_box' => $request->snpPerBox,
            'img' => $request->img,
        ]);
    }
}
