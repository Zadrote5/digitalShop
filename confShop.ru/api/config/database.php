<?php
class Database {

    // укажите свои учетные данные базы данных 
    private $host = "localhost";
    private $db_name = "shop";
    private $username = "root";
    private $password = "root";
    public $conn;

    // получаем соединение с БД 
    public function getConnection(){

        $this->conn = null;
        
        try {
            $this->conn = new PDO("mysql:host=localhost; dbname=shop; charset=utf8", 'root','root');
            $this->conn->exec("set names utf8");
        
        } catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>