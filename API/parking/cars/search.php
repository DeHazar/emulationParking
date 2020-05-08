<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 08.05.2020
 * Time: 14:13
 */
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


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
$car->carNumber = $data->carNumber;
$car->parkingId = $data->parkingId;

// запрашиваем машины все
$stmt = $car->readCarsWithCarNumber();
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
            "carNumber" => $carNumber,
            "description" => html_entity_decode($description),
            "transactionId" => $transactionId,
            "start_date" => $transactionStartTime,
            "end_date" => $transactionPaidTime,
            "total" => $total,
            "isPaid" => boolval($isPaid)
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
?>