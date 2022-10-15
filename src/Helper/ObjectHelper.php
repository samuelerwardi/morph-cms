<?php
/**
 * Created by PhpStorm.
 * User: Malik Al Ichsan <malik.ichsan@salt.co.id>
 */

namespace App\Helper;


use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

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

    public static function generateKeyByUuid()
    {
        return Uuid::uuid4();
    }

    public static function checkAndConvertMsisdnFormat($msisdn) {
        if (empty($msisdn)) {
            return false;
        }

        $reformat = false;

        if (preg_match('/^62/', $msisdn)) {
            $reformat = $msisdn;
        } elseif (preg_match('/^[+]62/', $msisdn)) {
            $reformat = preg_replace('/^[+]62/', '62', $msisdn);
        } elseif (preg_match('/^0/', $msisdn)) {
            $reformat = preg_replace('/^0/', '62', $msisdn);
        } elseif(preg_match('/^\'0/', $msisdn)){
            $reformat = preg_replace('/^\'0/', '62', $msisdn);
        } else {
            return false;
        }

        return $reformat;
    }

    public static function checkEmailFormat($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            return false;
        }

        return true;
    }

    public static function checkEmailExisting($email)
    {
        $a = new MemberBulkPurchase\Listing();
        $a->setCondition('email = ? AND o_published = ?', [$email, 1]);
        $load = $a->load();

        if (!empty($load)) {
            return false;
        }

        return true;
    }
}
