<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// подключение файла для соединения с базой и файл с объектом 
include_once '../config/database.php';
include_once '../objects/pc.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$pct = new Pc($db);

// установим свойство ID записи для чтения 
$pc->id = isset($_GET['id']) ? $_GET['id'] : die();

// прочитаем детали товара для редактирования 
$pc->readOne();

if ($pc->name!=null) {

    // создание массива 
    $pc_arr = array(
        "id" =>  $pc->id,
        "cpu" => $pc->cpu,
        "gpu" => $pc->gpu,
        "pccase" => $pc->pccase,
        "ssd" => $pc->ssd,
        "drive" => $pc->drive,
        "fan" => $pc->fan,
        "power" => $pc->power,
        "motherboard" => $pc->motherboard,
        "network" => $pc->network,
        "os" => $pc->os,
        "ram" => $pc->ram,
        "guid" => $pc->guid,
        "description" => $pc->description,
        "gindex" => $pc->name,
        "price" => $pc->price


    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($pc_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(200);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Товар не существует."), JSON_UNESCAPED_UNICODE);
}
?>