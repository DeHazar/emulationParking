<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 14.04.2020
 * Time: 21:21
 */
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом
include_once '../config/database.php';
include_once '../objects/car.php';

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$car = new Car($db);

// установим свойство ID записи для чтения
$car->id = isset($_GET['id']) ? $_GET['id'] : die();

// прочитаем детали товара для редактирования
$car->readOne();

if ($car->name!=null) {

    // создание массива
    $car_arr = array(
        "id" =>  $car->id,
        "name" => $car->name,
        "description" => $car->description,
        "startDate" => $car->startDate,
        "endDate" => $car->endDate,
        "totalPrice" => $car->totalPrice
    );

    // код ответа - 200 OK
    http_response_code(200);

    // вывод в формате json
    echo json_encode($car_arr);
}

else {
    // код ответа - 404 Не найдено
    http_response_code(404);

    // сообщим пользователю, что товар не существует
    echo json_encode(array("message" => "Машина не существует."), JSON_UNESCAPED_UNICODE);
}
?>