<?php
/**
 * Created by PhpStorm.
 * User: Malik Al Ichsan <malik.ichsan@salt.co.id>
 */

namespace App\Helper;


use Carbon\Carbon;

class ObjectHelper
{
    public static function generateBashPathAssets($name)
    {
        $order = Folder::checkAndCreateAssets($name);
        $year = Folder::checkAndCreateAssets(Carbon::now()->format('Y'), $order);
        $month = Folder::checkAndCreateAssets(Carbon::now()->format('m'), $year);
        $day = Folder::checkAndCreateAssets(Carbon::now()->format('d'), $month);

        return $day;
    }

    public static function generateBashPath($name)
    {
        $order = Folder::checkAndCreate($name);
        $year = Folder::checkAndCreate(Carbon::now()->format('Y'), $order);
        $month = Folder::checkAndCreate(Carbon::now()->format('m'), $year);
        $day = Folder::checkAndCreate(Carbon::now()->format('d'), $month);

        return $day;
    }
}
