<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 28.04.2020
 * Time: 22:50
 */
class Skud
{

    private $conn;
    private $table_name = "skuds";

    // свойства объекта
    public $id;
    public $emptyPlaces;
    public $priceForMinute;

    // конструктор для соединения с базой данных
    public function __construct($db)
    {
        $this->conn = $db;
    }

    private function open() {
        //TODO: - Something open request
        return true;
    }

    function income() {
        $this->emptyPlaces = $this->emptyPlaces - 1;
        $this->open();
        $this->update();
    }

    function outcoming() {
        $this->emptyPlaces = $this->emptyPlaces + 1;
        $this->open();
        $this->update();

    }

    function readAll() {
        $query = "SELECT
                *
            FROM
                " . $this->table_name . " 
            ORDER BY
                id DESC";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
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
        $this->emptyPlaces = $row['emptyPlaces'];
        $this->priceForMinute = $row['priceForMinute'];
    }

    function update() {
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // запрос для обновления записи (товара)
            $query = "UPDATE
                    " . $this->table_name . "
              SET emptyPlaces = :emptyPlaces
                WHERE
                    id = :id";

            // подготовка запроса
            $stmt = $this->conn->prepare($query);

            // очистка
            $this->emptyPlaces=htmlspecialchars(strip_tags($this->emptyPlaces));
            $this->id=htmlspecialchars(strip_tags($this->id));

            // привязываем значения
            $stmt->bindParam(':emptyPlaces', $this->emptyPlaces);
            $stmt->bindParam(':id', $this->id);

            // выполняем запрос
            if ($stmt->execute()) {
                return true;
            }

            return false;
    }
}