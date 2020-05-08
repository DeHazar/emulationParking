<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 28.04.2020
 * Time: 23:03
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
$parking = new Skud($db);
$car = new Car($db);

// получаем id товара для редактирования
$data = json_decode(file_get_contents("php://input"));

// установим id свойства товара для редактирования
$parking->id = $data->id;
$car->carNumber = $data->carNumber;
$car->parkingId = $data->id;

$car->readCarWithCarNumber();
$parking->readOne();

if ($car->transaction->isPaid) {
    $parking->outcoming();
    http_response_code(200);

    // сообщим пользователю
    echo json_encode(array("message" => "Открывай."), JSON_UNESCAPED_UNICODE);

} else {
    http_response_code(500);

    // сообщим пользователю
    echo json_encode(array("message" => "Не оплатил."), JSON_UNESCAPED_UNICODE);

}
?>