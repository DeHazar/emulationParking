<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 17.04.2020
 * Time: 22:52
 */
class Transaction {

    private $conn;
    private $tableName = "transactions";

    // свойства объекта
    public $id;
    public $transactionStartTime;
    public $transactionPaidTime;
    public $total;

    // конструктор для соединения с базой данных
    public function __construct($db){
        $this->conn = $db;
    }

    // метод read() - получение товаров
    function read(){

        // выбираем все записи
        $query = "SELECT
               *
            FROM
                " . $this->tableName . "
            ORDER BY
                transactionTime DESC";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }

    // метод create - создание товаров
    function create(){

        // запрос для вставки (создания) записей
        $query = "INSERT INTO
                " . $this->tableName . "
            SET
                carId=:carId, transactionTime=:transactionTime, price=:price";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->carId=htmlspecialchars(strip_tags($this->carId));
        $this->transactionTime=htmlspecialchars(strip_tags($this->transactionTime));
        $this->price=htmlspecialchars(strip_tags($this->price));

        // привязка значений
        $stmt->bindParam(":carId", $this->carId);
        $stmt->bindParam(":price", $this->transactionTime);
        $stmt->bindParam(":startDate", $this->price);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // используется при заполнении формы обновления товара
    function readOne() {

        // запрос для чтения одной записи (товара)
        $query = "SELECT
               *
            FROM
                " . $this->tableName . "
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
        $this->carId = $row['carId'];
        $this->transactionTime = $row['transactionTime'];
        $this->price = $row['price'];
    }

    // метод update() - обновление товара
    function update(){

        // запрос для обновления записи (товара)
        $query = "UPDATE
                " . $this->tableName . "
            SET
                carId = :carId,
                transactionTime = :transactionTime,
                price = :price
            WHERE
                id = :id";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->carId=htmlspecialchars(strip_tags($this->carId));
        $this->transactionTime=htmlspecialchars(strip_tags($this->transactionTime));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // привязываем значения
        $stmt->bindParam(':carId', $this->carId);
        $stmt->bindParam(':price', $this->transactionTime);
        $stmt->bindParam(':price', $this->price);
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
        $query = "DELETE FROM " . $this->tableName . " WHERE id = ?";

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
}


?>