<?php

namespace App;

class FormatDate
{
    public static $arrMonth = [
        "January" => "Январь",
        "February" => "Февраль",
        "March" => "Март",
        "April" => "Апрель",
        "May" => "Май",
        "June" => "Июнь",
        "July" => "Июль",
        "August" => "Август",
        "September" => "Сентябрь",
        "October" => "Октябрь",
        "November" => "Ноябрь",
        "December" => "Декабрь",
    ];

    public static function formatDate($date)
    {
        $date = explode(' ', $date);
        $result= self::$arrMonth[$date[0]] . ' ' . $date[1];
        return $result;
    }

    public static function getMonth($date)
    {
        $arrM = array_flip(self::$arrMonth);

        return date('m', strtotime($arrM[explode('_', $date)[0]]));
    }

    public static function getYear($date)
    {
        return intval(explode('_', $date)[1]);
    }
}