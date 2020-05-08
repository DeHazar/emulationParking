<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 14.04.2020
 * Time: 20:43
 */

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $ip = "188.225.25.41";
    $url = "sallattov.ru";
    $host = "dasd";
    $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, "http://".$ip."/".$url);
     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: '.$host));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if(curl_exec($ch) === false)
     {
         echo 'Ошибка curl: ' . curl_error($ch);
     }
     else
     {
         echo 'Операция завершена без каких-либо ошибок';
     }
?>
