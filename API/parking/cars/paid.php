<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 08.05.2020
 * Time: 16:40
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом Product
include_once '../../Config/database.php';
include_once '../../objects/car.php';

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$car = new Car($db);

// получаем id товара для редактирования
$data = json_decode(file_get_contents("php://input"));

// установим id свойства товара для редактирования
$car->id = $data->id;

$car->readOne();
$car->transaction->paidTransaction();

// обновление товара
if ($car->update()) {

    // установим код ответа - 200 ok
    http_response_code(200);

    // создание массива
    $car_arr = array(
        "transactionId" => $car->transaction->id,
        "startTime" => $car->transaction->transactionStartTime,
        "endTime" => $car->transaction->transactionPaidTime,
        "total" => doubleval($car->transaction->total),
        "message" => "Успешно."
    );

    // код ответа - 200 OK
    http_response_code(200);

    // вывод в формате json
    echo json_encode($car_arr);
}

// если не удается обновить товар, сообщим пользователю
else {

    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщение пользователю
    echo json_encode(array("message" => "Невозможно обновить товар."), JSON_UNESCAPED_UNICODE);
}
?>