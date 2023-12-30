<?php

namespace App\Libraries;

use App\Models\Prize;

class Common
{
    public static function GetDaysLeft($startDay, $goalDay) // 使用期限までの日数取得
    {
        $daysLeft = (strtotime($goalDay) - strtotime($startDay)) / 86400;

        return $daysLeft;
    }


    public static function GetThoseDaysFirst($stockData, $prizeData) //景品ごとに一番早い賞味期限、使用期限、残り日数を取得
    {
        $first = 9999999999; // $first の初期化

        if (count($stockData) >= 1) { // stockデータが存在した場合、一番早いものだけ取得
            foreach ($stockData as $stock) {
                if ($first > strtotime($stock->expired_at)) {
                    $first = strtotime($stock->expired_at);
                }
            }

        } else {
            $first = null;
        }


        if ($first != null) { // データ作成
            $expired_at = date('Y-m-d', $first);
            $limit_at = date('Y-m-d', strtotime('-30 day', $first));
            $daysLeft = self::GetDaysLeft(date('Y-m-d'), $limit_at);

        } else {
            $expired_at = '~~~~';
            $limit_at = '~~~~';
            $daysLeft = '~~~~';
        }

        return [$expired_at, $limit_at, $daysLeft];
    }


    public static function GetThoseDays ($stocks) {
        if (count($stocks) >= 1) {
            $i = 0;
            foreach ($stocks as $stock) {
                $day = strtotime($stock->expired_at);

                $limit_at[] = date('Y-m-d', strtotime('-30 day', $day));
                $daysLeft[] = self::GetDaysLeft(date('Y-m-d'), $limit_at[$i]);

                $i++;
            }
        } else {
            $limit_at[] = '~~~~';
            $daysLeft[] = '~~~~';
        }

        return [$limit_at, $daysLeft];
    }


    public static function sortByKey($keyName, $sortOrder, $array)
    {
        foreach ($array as $key => $value) { // 二次元配列をキー($key)と配列($value)に分ける
            $standard_key_array[$key] = $value[$keyName];// 二次元配列のindex値をキーにして下層の配列の指定の値を入れる
        }

        $array = $array->all();

        array_multisort($standard_key_array, $sortOrder, $array);// 仮装の指定の値だけを並び替えてそのindexに合わせて二次元配列をソートする

        $array = collect($array);

        return $array;
    }

    public static function GetPrizeCategories () {
        $category = Prize::select('category')->get();

        $categories = [];
        for ($i = 0; $i < count($category); $i++) {
            $categories[] = $category[$i]['category'];;
        };

        $categories = array_unique($categories);
        sort($categories);

        return $categories;
    }

}

?>
