<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/pc.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// инициализируем объект 
$pc = new Pc($db);
$get_category = $_GET['gindex'];
$stmt = $pc->read($get_category);
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей 
if ($num>0) {

    // массив товаров 
    $pcs_arr=array();
    //$pcs_arr["records"]=array();

    // получаем содержимое нашей таблицы 
    // fetch() быстрее, чем fetchAll() 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // извлекаем строку 
        extract($row);

        $pc_item=array(
            "id" => $id,
            "cpu" => $cpu,
            "gpu" => $gpu,
            "pccase" => $pccase,
            "ssd" => $ssd,
            "drive" => $drive,
            "fan" => $fan,
            "power" => $power,
            "motherboard" => $motherboard,
            "network" => $network,
            "os" => $os,
            "ram" => $ram,
            "guid" => $guid,
            "description" => html_entity_decode($description),
            "gindex" => $gindex,
            "price" => intval($price)
        );

        array_push($pcs_arr, $pc_item);
    }

    // устанавливаем код ответа - 200 OK 
    http_response_code(200);

    // выводим данные о товаре в формате JSON 
    echo json_encode($pcs_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(200);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}