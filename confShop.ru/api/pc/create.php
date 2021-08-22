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
include_once '../objects/pc.php';

$database = new Database();
$db = $database->getConnection();

$pc = new Pc($db);
function guidv4($data)
{
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

// получаем отправленные данные
$cpu = $_POST['cpu'];
$gpu = $_POST['gpu'];
$pccase = $_POST['pccase'];
$ssd = $_POST['ssd'];
$drive = $_POST['drive'];
$fan = $_POST['fan'];
$power = $_POST['power'];
$motherboard = $_POST['motherboard'];
$network = $_POST['network'];
$os = $_POST['os'];
$ram = $_POST['ram'];
$description = $_POST['description'];
$gindex = $_POST['gindex'];
$price = $_POST['price'];
$guid = str_replace('-', '', guidv4(openssl_random_pseudo_bytes(16)));

// убеждаемся, что данные не пусты
if (
  !empty($cpu) &&
  !empty($gpu) &&
  !empty($pccase) &&
  !empty($ssd) &&
  !empty($drive) &&
  !empty($fan) &&
  !empty($power) &&
  !empty($motherboard) &&
  !empty($network) &&
  !empty($os) &&
  !empty($ram) &&
  !empty($description) &&
  !empty($gindex) &&
  !empty($price)

) {

    // устанавливаем значения свойств товара
    $pc->cpu = $cpu;
    $pc->gpu = $gpu;
    $pc->pccase = $pccase;
    $pc->ssd = $ssd;
    $pc->drive = $drive;
    $pc->fan = $fan;
    $pc->power = $power;
    $pc->motherboard = $motherboard;
    $pc->network = $network;
    $pc->os = $os;
    $pc->ram = $ram;
    $pc->guid = $guid;
    $pc->description = $description;
    $pc->gindex = $gindex;
    $pc->price = $price;

    $upload_image=$_FILES["myimage"]["name"];

    $filebasename=$_FILES["file"]["name"];
    $fileType=pathinfo($filebasename,PATHINFO_EXTENSION);
    $filenameNew = $guid . "$fileType";
    copy($_FILES["myimage"]["tmp_name"],'../../img/' . $filenameNew);


    // создание товара
    if($pc->create()){

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
