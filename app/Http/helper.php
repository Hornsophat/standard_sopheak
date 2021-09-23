<?php
/**
 * Created by PhpStorm.
 * User: Voeun So
 * Date: 7/11/2018
 * Time: 8:47 PM
 */

if(!function_exists('expense_type')){

    function expense_type($key)
    {
        $ouput =[
            '1' =>'Material',
            '2' =>'Employee'

        ];

        return $ouput[$key];
    }
}

if(!function_exists('gender')){

    function gender($key)
    {
        $ouput =[
            '0' => "",
            '1' =>'Male',
            '2' =>'Female'

        ];

        return $ouput[$key];
    }
}


if(!function_exists('GUID')) {
    function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}
