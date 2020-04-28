<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 14.04.2020
 * Time: 21:05
 */
include_once  "transaction.php";
include_once "skud.php";

class Car {

    private $conn;
    private $table_name = "cars";

    // свойства объекта
    public $id;
    public $carNumber;
    public $description;
    public $transaction;
    public $parkingId;

    // конструктор для соединения с базой данных
    public function __construct($db){
        $this->conn = $db;
    }

    // метод read() - получение машин
    function read(){
        #$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // выбираем все записи
        $query = "SELECT
                 p.id, p.carNumber, p.description, p.parkingId, t.id as transactionId, t.transactionPaidTime, t.transactionStartTime, t.total
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    transactions t
                        ON p.transactionId = t.id
            ORDER BY
                p.id DESC";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }

    // метод create - заезд машины
    function create() {
        #$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // запрос для вставки (создания) записей
        $query = "INSERT INTO
                " . $this->table_name . " (carNumber,description, transactionId, parkingId)
            VALUES(:carNumber, :description, :transactionId, :parkingId)";

        $transaction = new Transaction($this->conn);
        $transaction->total = 0;
        $transaction->transactionStartTime =  date('Y-m-d H:i:s');
        $transactionId = $transaction->create();

        $skud = new Skud($this->conn);
        $skud->id = $this->parkingId;
        $skud->readOne();
        $skud->income();

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->carNumber=htmlspecialchars(strip_tags($this->carNumber));
        $this->description=htmlspecialchars(strip_tags($this->description));
        // привязка значений
        $stmt->bindParam(":carNumber", $this->carNumber);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":transactionId", $transactionId);
        $stmt->bindParam(":parkingId", $this->parkingId);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    function readOne() {
        // запрос для чтения одной записи

        $query = "SELECT *
            FROM
                " . $this->table_name . " 
            WHERE
                id = ?
            LIMIT
                0,1";

        // подготовка запроса
        $stmt = $this->conn->prepare( $query );
        // привязываем id товара, который будет обновлен
        $stmt->bindParam(1, $this->id);

        // выполняем запрос
        $stmt->execute();

        // получаем извлеченную строку
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // установим значения свойств объекта
        $this->carNumber = $row['carNumber'];
        $this->description = $row['description'];
        $transaction = new Transaction($this->conn);
        $transaction->id =  $row['transactionId'];
        $transaction -> readOne();

        $this->transaction = $transaction;
        $this->parkingId = $row['parkingId'];

    }

    // метод update() - обновление товара
    function update() {
        // запрос для обновления записи (товара)
        $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                totalPrice = :totalPrice,
                description = :description,
                endDate = :endDate
            WHERE
                id = :id";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->totalPrice=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->endDate=htmlspecialchars(strip_tags($this->category_id));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // привязываем значения
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->totalPrice);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category_id', $this->endDate);
        $stmt->bindParam(':id', $this->id);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // метод delete - удаление товара
    function delete(){

        // запрос для удаления записи (товара)
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->id=htmlspecialchars(strip_tags($this->id));

        // привязываем id записи для удаления
        $stmt->bindParam(1, $this->id);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Оплата
    function getPaySum() {
        $this->readOne();

        $parking = new Skud($this->conn);
        $parking->id = $this->parkingId;
        $parking->readOne();

        $this->transaction->transactionPaidTime = date('Y-m-d H:i:s');

        $timeMinute = (strtotime($this->transaction->transactionPaidTime )- strtotime($this->transaction->transactionStartTime)) / 60;

        $total = $parking->priceForMinute * $timeMinute;
        $this->transaction->total = $total;

        $this->transaction->update();
        return $total;
    }
}

?>