<?php
session_start();
if($_SESSION['admin']==false){
    header("Location: http://confshop/auth.php");
    exit;
   }
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// получаем соединение с базой данных
include_once '../config/database.php';

// создание объекта товара
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

function guidv4($data)
{
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}


// получаем отправленные данные
$name = $_POST['name'];
$price = $_POST['price'];
$description = $_POST['description'];
$category = $_POST['category'];
$socket = $_POST['socket'];
$guid = str_replace('-', '', guidv4(openssl_random_pseudo_bytes(16)));


// убеждаемся, что данные не пусты

if (
    !empty($name) &&
    !empty($price) &&
    !empty($description) &&
    !empty($category) 
     
  
) {

    // устанавливаем значения свойств товара
    $product->name = $name;
    $product->description = $description;
    $product->socket = $socket;

    $product->guid = $guid;
    $product->category = $category;
    $product->price = $price;

    $upload_image=$_FILES["myimage"]["name"];

    $filebasename=$_FILES["file"]["name"];
    $fileType=pathinfo($filebasename,PATHINFO_EXTENSION);
    $filenameNew = $guid . "$fileType";
    copy($_FILES["myimage"]["tmp_name"],'../../img/' . $filenameNew);
   


    // создание товара
    if($product->create()){

        // установим код ответа - 201 создано
        http_response_code(201);

        // сообщим пользователю
        echo json_encode(array("message" => "Товар был создан."), JSON_UNESCAPED_UNICODE);
    }

    // если не удается создать товар, сообщим пользователю
    else {

        // установим код ответа - 503 сервис недоступен
        http_response_code(503);

        // сообщим пользователю
        echo json_encode(array("message" => "Невозможно создать товар."), JSON_UNESCAPED_UNICODE);
    }
}

// сообщим пользователю что данные неполные
else {

    // установим код ответа - 400 неверный запрос
    http_response_code(400);

    // сообщим пользователю
    echo json_encode(array("message" => "Невозможно создать товар. Данные неполные."), JSON_UNESCAPED_UNICODE);
}
?>
