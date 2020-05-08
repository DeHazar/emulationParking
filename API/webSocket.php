<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 06.05.2020
 * Time: 22:16
 */
date_default_timezone_set("America/New_York");
header("Content-Type: text/event-stream");
include_once '../API/Config/database.php';
include_once 'Objects/car.php';


function GetStringAfterSecondSlashInURL($the_url)
{
    $parts = explode("/",$the_url,4);

    if(isset($parts[3]))
        return $parts[3];
}

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$parking = new Skud($db);

$str = $_SERVER['REQUEST_URI'];
$id = GetStringAfterSecondSlashInURL($str);

// установим id свойства товара для редактирования
$parking->id = $id;

//while (true) {
//    $parking->readOne();
//    // Every second, send a "ping" event.
//    echo "event: ping\n";
//    $curDate = date(DATE_ISO8601);
//    echo 'data: {"places": "' . $parking->emptyPlaces . '"}';
//    echo "\n\n";
//
//    // flush the output buffer and send echoed messages to the browser
//
//    while (ob_get_level() > 0) {
//        ob_end_flush();
//    }
//    flush();
//
//    // break the loop if the client aborted the connection (closed the page)
//
//    if ( connection_aborted() ) break;
//
//    // sleep for 1 second before running the loop again
//
//    sleep(1);
//}

$counter = rand(1, 10); // a random counter
while (1) {
// 1 is always true, so repeat the while loop forever (aka event-loop)

    $curDate = date(DATE_ISO8601);
    echo "event: ping\n",
        'data: {"time": "' . $curDate . '"}', "\n\n";

    // Send a simple message at random intervals.

    $counter--;

    if (!$counter) {
        $parking->readOne();
        echo  "data:".$parking->emptyPlaces."\n\n";
        $counter = rand(1, 10); // reset random counter
    }

    // flush the output buffer and send echoed messages to the browser

    while (ob_get_level() > 0) {
        ob_end_flush();
    }
    flush();

    // break the loop if the client aborted the connection (closed the page)

    if ( connection_aborted() ) break;

    // sleep for 1 second before running the loop again

    sleep(1);

}