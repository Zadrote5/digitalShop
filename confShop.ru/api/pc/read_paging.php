<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение файлов 
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/pc.php';

// utilities 
$utilities = new Utilities();

// создание подключения 
$database = new Database();
$db = $database->getConnection();

// инициализация объекта 
$pc = new Pc($db);

// запрос товаров 
$stmt = $pc->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();

// если больше 0 записей 
if ($num>0) {

    // массив товаров 
    $pcs_arr=array();
    $pcs_arr["records"]=array();
    $pcs_arr["paging"]=array();

    // получаем содержимое нашей таблицы 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // извлечение строки 
        extract($row);

        $pc_item=array(
            "id" => $id,
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

        array_push($pcs_arr["records"], $pc_item);
    }

    // подключим пагинацию 
    $total_rows=$pc->count();
    $page_url="{$home_url}pc/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $pcs_arr["paging"]=$paging;

    // установим код ответа - 200 OK 
    http_response_code(200);

    // вывод в json-формате 
    echo json_encode($pcs_arr);
} else {

    // код ответа - 404 Ничего не найдено 
    http_response_code(404);

    // сообщим пользователю, что товаров не существует 
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
?>