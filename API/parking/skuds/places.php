<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 06.05.2020
 * Time: 21:20
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом Product
include_once '../../Config/database.php';
include_once '../../objects/car.php';


function GetStringAfterSecondSlashInURL($the_url)
{
    $parts = explode("/",$the_url,6);

    if(isset($parts[5]))
        return $parts[5];
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
$parking->readOne();

// обновление товара
if ($parking->emptyPlaces) {

    // установим код ответа - 200 ok
    http_response_code(200);

    // сообщим пользователю
    echo json_encode(array("message" => "Успешно.", "places" => $parking->emptyPlaces), JSON_UNESCAPED_UNICODE);
}

// если не удается обновить товар, сообщим пользователю
else {

    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщение пользователю
    echo json_encode(array("message" => "Невозможно получить данные."), JSON_UNESCAPED_UNICODE);
}
?>