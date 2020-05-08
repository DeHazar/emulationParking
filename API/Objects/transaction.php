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
    private $isPaid;


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
                " . $this->tableName ." (transactionStartTime, total) VALUES (:transactionStartTime, 0)";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':transactionStartTime', $this->transactionStartTime);

        $this->conn->beginTransaction();
        // выполняем запрос
        if ($stmt->execute()) {
            $id = $this->conn->lastInsertId();
            $this->conn->commit();
            return $id;
        }
        $this->conn->commit();

        return -1;
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
        $this->transactionStartTime = $row['transactionStartTime'];
        $this->transactionPaidTime = $row['transactionPaidTime'];
        $this->total = $row['total'];
        $this->isPaid = $row['$isPaid'];

    }

    // метод update() - обновление товара
    function update(){

        // запрос для обновления записи (товара)
        $query = "UPDATE
                " . $this->tableName . "
            SET
                transactionStartTime = :transactionStartTime,
                transactionPaidTime = :transactionPaidTime,
                total = :total
                isPaid = :isPaid
            WHERE
                id = :id";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->transactionStartTime=htmlspecialchars(strip_tags($this->transactionStartTime));
        $this->transactionPaidTime=htmlspecialchars(strip_tags($this->transactionPaidTime));
        $this->total=htmlspecialchars(strip_tags($this->total));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // привязываем значения
        $stmt->bindParam(':transactionStartTime', $this->transactionStartTime);
        $stmt->bindParam(':transactionPaidTime', $this->transactionPaidTime);
        $stmt->bindParam(':total', $this->total);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':isPaid', $this->isPaid);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function paidTransaction() {
        $this->readOne();
        $this->isPaid = true;
        $this->update();
        return true;
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
