<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/product.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// инициализируем объект 
$product = new Product($db);
$get_category = $_GET['category'];
$stmt = $product->read($get_category);
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей 
if ($num>0) {

    // массив товаров 
    $products_arr=array();
    //$products_arr["records"]=array();

    // получаем содержимое нашей таблицы 
    // fetch() быстрее, чем fetchAll() 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // извлекаем строку 
        extract($row);

        $product_item=array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "price" => intval($price),
            "category" => $category,
            "guid" => $guid,
            "socket" => $socket
        );

        array_push($products_arr, $product_item);
    }

    // устанавливаем код ответа - 200 OK 
    http_response_code(200);

    // выводим данные о товаре в формате JSON 
    echo json_encode($products_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(200);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}