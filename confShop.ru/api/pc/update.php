<?php
session_start();
if($_SESSION['admin']==false){
    header("Location: auth.php");
    exit;
   }
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключаем файл для работы с БД и объектом pc 
include_once '../config/database.php';
include_once '../objects/pc.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

// подготовка объекта 
$pc = new Pc($db);

// получаем id товара для редактирования 
$data = json_decode(file_get_contents("php://input"));

// установим id свойства товара для редактирования 
$pc->guid = $data->guid;

// установим значения свойств товара 
$pc->cpu = $data->cpu;
$pc->gpu = $data->gpu;
$pc->pccase = $data->pccase;
$pc->ssd = $data->ssd;
$pc->drice = $data->drive;
$pc->fan = $data->fan;
$pc->power = $data->power;
$pc->motherboard = $data->motherboard;
$pc->network = $data->network;
$pc->os = $data->os;
$pc->ram = $data->ram;
$pc->guid = $data->guid;
$pc->description = $data->description;
$pc->gindex = $data->gindex;
$pc->price = $data->price;
// обновление товара 
if ($pc->update()) {

    // установим код ответа - 200 ok 
    http_response_code(200);

    // сообщим пользователю 
    echo json_encode(array("message" => "Товар был обновлён."), JSON_UNESCAPED_UNICODE);
}

// если не удается обновить товар, сообщим пользователю 
else {

    // код ответа - 503 Сервис не доступен 
    http_response_code(503);

    // сообщение пользователю 
    echo json_encode(array("message" => "Невозможно обновить товар."), JSON_UNESCAPED_UNICODE);
}
?>