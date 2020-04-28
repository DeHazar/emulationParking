<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 28.04.2020
 * Time: 23:34
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
$total = $car->getPaySum();
// обновление товара
if ($total > 0) {

    // установим код ответа - 200 ok
    http_response_code(200);

    // сообщим пользователю
    echo json_encode(array("total" => $total, "startTime" => $car->transaction->transactionStartTime, "message" => "Успешно."), JSON_UNESCAPED_UNICODE);
}

// если не удается обновить товар, сообщим пользователю
else {

    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщение пользователю
    echo json_encode(array("message" => "Невозможно получить сумму для оплаты."), JSON_UNESCAPED_UNICODE);
}
?>