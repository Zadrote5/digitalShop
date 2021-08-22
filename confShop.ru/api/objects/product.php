<?php
class Product {

    // подключение к базе данных и таблице 'products'
    private $conn;
    private $table_name = "products";

    // свойства объекта
    public $id;
    public $name;
    public $description;
    public $price;
    public $category;
    public $guid;
    public $socket;

    // конструктор для соединения с базой данных
    public function __construct($db){
        $this->conn = $db;
    }

    function read($category){

        // выбираем все записи
        $query = "SELECT * FROM shop.products";

        if ($category != "all" && isset($category) ) {
            $query = $query." WHERE category LIKE '$category'";

        }

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }

    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }
    // чтение товаров с пагинацией
public function readPaging($from_record_num, $records_per_page){

    // выборка
    $query = "SELECT * FROM shop.products";

    // подготовка запроса
    $stmt = $this->conn->prepare( $query );

    // свяжем значения переменных
    $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

    // выполняем запрос
    $stmt->execute();

    // вернём значения из базы данных
    return $stmt;
}



    function delete(){

        // запрос для удаления записи (товара)
        $query = "DELETE FROM " . $this->table_name . " WHERE guid LIKE '". $this->guid ."'";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->guid=htmlspecialchars(strip_tags($this->guid));

        // привязываем id записи для удаления
        $stmt->bindParam(1, $this->guid);

        // выполняем запрос
        $stmt->execute();
        $count = $stmt->rowCount();
        return ($count > 0);

    }

    function update(){

        // запрос для обновления записи (товара)
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    name = :name,
                    price = :price,
                    description = :description,
                    category = :category,
                    guid = :guid,
                    socket = :socket
                WHERE
                    id = :id";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category=htmlspecialchars(strip_tags($this->category));
        $this->guid=htmlspecialchars(strip_tags($this->guid));
        $this->socket=htmlspecialchars(strip_tags($this->socket));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // привязываем значения
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':guid', $this->guid);
        $stmt->bindParam(':socket', $this->socket);
        $stmt->bindParam(':id', $this->id);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    function readOne() {


        // запрос для чтения одной записи (товара)
        $query = "SELECT
        c.name as category_name, p.id, p.name, p.description, p.price, p.category, p.guid, p.socket
    FROM
        " . $this->table_name . " p
    WHERE
        p.id = ?
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
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->description = $row['description'];
        $this->category = $row['category'];
        $this->guid = $row['guid'];
        $this->socket = $row['socket'];
    }


    function create(){

        // запрос для вставки (создания) записей
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, price=:price, description=:description, category=:category, guid=:guid, socket=:socket ";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category=htmlspecialchars(strip_tags($this->category));
        $this->guid=htmlspecialchars(strip_tags($this->guid));
        $this->socket=htmlspecialchars(strip_tags($this->socket));

        // привязка значений
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":guid", $this->guid);
        $stmt->bindParam(":socket", $this->socket);

        // выполняем запрос
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
