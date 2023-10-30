<?php

namespace App\Libraries;

class Common
{
    public static function GetDaysLeft($startDay, $goalDay)
    {
        $daysLeft = (strtotime($goalDay) - strtotime($startDay)) / 86400;

        return $daysLeft;
    }


    public static function GetThoseDays($stockData, $prizeData)
    {
        $first = 9999999999; // $first の初期化

        if (count($stockData) >= 1) {
            foreach ($stockData as $stock) {
                if ($first > strtotime($stock->expired_at)) {
                    $first = strtotime($stock->expired_at);
                }
            }

        } else {
            $first = null;
        }


        if ($first != null) {
            $expired_at = date('Y-m-d', $first);
            $limit_at = date('Y-m-d', strtotime('-45 day', $first));
            $daysLeft = self::GetDaysLeft(date('Y-m-d'), $limit_at);

        } else {
            $expired_at = '~~~~';
            $limit_at = '~~~~';
            $daysLeft = '~~~~';
        }

        return [$expired_at, $limit_at, $daysLeft];
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

}

?>
