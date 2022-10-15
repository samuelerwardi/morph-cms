<?php
/**
 * Samuelerwardi samuelerwardi@gmail.com
 */

namespace App\Helper;


use Pimcore\Model\User;

class GeneralHelper
{
    /*
     * convert leading zero into 62
     * convert +62 into 62
     * keep 62 into 62
     * check prefix nomor tsel
     */
    public static function checkAndConvertMsisdnFormat($msisdn)
    {
        $reformat = false;
        if (preg_match('/^62/', $msisdn)) {
            $reformat = $msisdn;
        } elseif (preg_match('/^[+]62/', $msisdn)) {
            $reformat = preg_replace('/^[+]62/', '62', $msisdn);
        } elseif (preg_match('/^0/', $msisdn)) {
            $reformat = preg_replace('/^0/', '62', $msisdn);
        }

        $prefixNoTsel = ["62811", "62812", "62813", "62821", "62822", "62823", "62851", "62852", "62853"];
        if (in_array(substr($reformat, 0, 5), $prefixNoTsel) != true) {
            $reformat = false;
        }

        return $reformat;
    }

    public static function convertKbToMb($kb, $isFloor = false)
    {
        $mb = $kb / 1024;

        $result = $isFloor ? floor(self::minusToZero($mb)) : self::minusToZero($mb);

        return self::decimalPrecision($result);
    }

    public static function convertKbToGb($kb, $isFloor = false)
    {
        $gb = $kb / 1048576;

        $result = $isFloor ? floor(self::minusToZero($gb)) : self::minusToZero($gb);

        return self::decimalPrecision($result);
    }

    public static function decimalPrecision($val)
    {
        $convert = sprintf("%1.2f",$val);

        $cookedVal = (explode('.', $convert)[1] > 0) ? (double) $convert : (int) explode('.', $convert)[0];

        return $cookedVal;
    }

    public static function minusToZero($value)
    {
        $value = $value < 0 ? 0 : $value;
        return $value;
    }

    public static function isAdmin(){
        $session = \Pimcore\Tool\Session::getReadOnly();
        $user = $session->get('user');
        if($user instanceof User && $user->isAdmin()){
            return true;
        }
        return false;
    }

    /**
     * convert leading zero into 62
     * convert +62 into 62
     * keep 62 into 62
     */
    static function convertMsisdnFormatAllProvider($msisdn)
    {
        $reformat = false;
        if (preg_match('/^62/', $msisdn)) {
            $reformat = $msisdn;
        } elseif (preg_match('/^[+]62/', $msisdn)) {
            $reformat = preg_replace('/^[+]62/', '62', $msisdn);
        } elseif (preg_match('/^0/', $msisdn)) {
            $reformat = preg_replace('/^0/', '62', $msisdn);
        }
        return $reformat;
    }

    static function removeSpecialCharForSlug($str, $delimiter){
        $str = urldecode($str);
        return str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(" ", $delimiter, strtolower($str))));
    }

    static function clean($string) {
        $string = ltrim(rtrim($string));
        return preg_replace('/[^\da-z ]/i', '', $string);
    }
}
