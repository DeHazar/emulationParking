<?php
/**
 * Created by PhpStorm.
 * User: macpro
 * Date: 14.04.2020
 * Time: 20:35
 */
class Database {

    // укажите свои учетные данные базы данных
    private $host = "localhost";

    private $db_name = "parking";
    private $username = "root";
    private $password = "123456";

    public $conn;

    // получаем соединение с БД
    public function getConnection(){

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
