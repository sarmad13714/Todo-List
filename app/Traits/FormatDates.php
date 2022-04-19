<?php

namespace App\Traits;

trait FormatDates
{
    public static function get_local_time(){
        $ip = file_get_contents("https://ipecho.net/plain");
        $url = 'http://ip-api.com/json/'.$ip;
        $tz = file_get_contents($url);
        $tz = json_decode($tz,true)['timezone'];
        return $tz;
    }

    //this function convert string to UTC time zone
    public static function convertTimeToUTCzone($str, $userTimezone, $format = 'Y-m-d H:i:s'){

        $new_str = new \DateTime($str, new \DateTimeZone(  $userTimezone  ) );
        $new_str->setTimeZone(new \DateTimeZone('UTC'));
        return $new_str->format( $format);
    }

//this function converts string from UTC time zone to current user timezone
    public static function convertTimeToUSERzone($str, $userTimezone, $format = 'Y-m-d H:i:s'){
        if(empty($str)){
            return '';
        }

        $new_str = new \DateTime($str, new \DateTimeZone('UTC') );
        $new_str->setTimeZone(new \DateTimeZone( $userTimezone ));
        return $new_str->format( $format);
    }
}
