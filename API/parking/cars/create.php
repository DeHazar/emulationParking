<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 14.04.2020
 * Time: 21:16
 */
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных 
include_once '../../Config/database.php';
include_once '../../objects/car.php';
include_once '../../objects/skud.php';

$database = new Database();
$db = $database->getConnection();

$car = new Car($db);
 
// получаем отправленные данные 
$data = json_decode(file_get_contents("php://input"));
 
// убеждаемся, что данные не пусты 
if (!empty($data->carNumber)
) {

    // устанавливаем значения свойств товара 
    $car->carNumber = $data->carNumber;
    $car->description = $data->description;
    $car->parkingId = $data->parkingId;

    $skud = new Skud($db);
    $skud->id = $data->parkingId;
    $skud->readOne();

    if ($skud->emptyPlaces <= 0) {
        // установим код ответа - 403 неверный запрос
        http_response_code(403);

        // сообщим пользователю
        echo json_encode(array("message" => "Парковка заполнена."), JSON_UNESCAPED_UNICODE);
        return;
    }

    // создание товара
    if($car->create()) {

        // установим код ответа - 201 создано 
        http_response_code(201);

        // сообщим пользователю 
        echo json_encode(array("message" => "Машина была создана."), JSON_UNESCAPED_UNICODE);
    }

    // если не удается создать товар, сообщим пользователю 
    else {

        // установим код ответа - 503 сервис недоступен 
        http_response_code(503);

        // сообщим пользователю 
        echo json_encode(array("message" => "Невозможно создать машину."), JSON_UNESCAPED_UNICODE);
    }
}

// сообщим пользователю что данные неполные 
else {

    // установим код ответа - 400 неверный запрос 
    http_response_code(400);

    // сообщим пользователю 
    echo json_encode(array("message" => "Невозможно создать машину. Данные неполные."), JSON_UNESCAPED_UNICODE);
}
?>