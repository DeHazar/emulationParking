<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 14.04.2020
 * Time: 21:30
 */
// показывать сообщения об ошибках
ini_set('display_errors', 1);
error_reporting(E_ALL);

// URL домашней страницы
$home_url="http://localhost/api/";

// страница указана в параметре URL, страница по умолчанию одна
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// установка количества записей на странице
$records_per_page = 5;

$totalCount = 400;
$minutePrice = 1;


// расчёт для запроса предела записей
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>