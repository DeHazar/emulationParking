<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 28.04.2020
 * Time: 22:58
 */


// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты
include_once '../../Config/database.php';
include_once '../../objects/skud.php';

// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$skud = new Skud($db);

// запрашиваем машины все
$stmt = $skud->readAll();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
if ($num>0) {

    // массив товаров
    $cars_arr=array();


    // получаем содержимое нашей таблицы
    // fetch() быстрее, чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // извлекаем строку
        extract($row);

        $car_item=array(
            "id" => $id,
            "carNumber" => $emptyPlaces,
                        "address" => $address
        );

        array_push($cars_arr, $car_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о товаре в формате JSON
    echo json_encode($cars_arr);
} else {

    // установим код ответа - 404 Не найдено
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены
    echo json_encode(array("message" => "Машины не найдены."), JSON_UNESCAPED_UNICODE);
}
