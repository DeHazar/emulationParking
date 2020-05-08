<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 07.05.2020
 * Time: 17:52
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом Product
include_once '../Config/database.php';
include_once '../objects/car.php';

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// подготовка объекта
$transaction = new Transaction($db);

// получаем id товара для редактирования
$data = json_decode(file_get_contents("php://input"));

// установим id свойства товара для редактирования
$transaction->id = $data->id;
$isPaid = $transaction->paidTransaction();

// обновление товара
if ($isPaid) {

    // установим код ответа - 200 ok
    http_response_code(200);

    // сообщим пользователю
    echo json_encode(array( "message" => "Успешно."), JSON_UNESCAPED_UNICODE);
}

// если не удается обновить товар, сообщим пользователю
else {

    // код ответа - 503 Сервис не доступен
    http_response_code(503);

    // сообщение пользователю
    echo json_encode(array("message" => "Невозможно оплатить."), JSON_UNESCAPED_UNICODE);
}
?>