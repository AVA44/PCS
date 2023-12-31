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
        }

        $prizes = Common::sortByKey('expired_at', SORT_ASC, $prizes);

        return [
            'prizes' => $prizes,
        ];
    }
}
