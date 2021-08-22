<?php
class Pc {
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
    $query = "SELECT * FROM shop.pc";

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
        $query = "DELETE FROM " . $this->table_name . " WHERE guid = ?";
    
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
                    cpu = :cpu,
                    gpu = :gpu,
                    pccase = :pccase,
                    ssd = :ssd,
                    drive = :drive,
                    fan = :fan,
                    power = :power,
                    motherboard = :motherboard,
                    network= :network,
                    os = :os,
                    ram = :ram,
                    description = :description,
                    gindex = :gindex,
                    price = :price
                WHERE
                    guid = :guid";
    
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
    
        // очистка 
        $this->cpu=htmlspecialchars(strip_tags($this->cpu));
        $this->gpu=htmlspecialchars(strip_tags($this->gpu));
        $this->pccase=htmlspecialchars(strip_tags($this->pccase));
        $this->ssd=htmlspecialchars(strip_tags($this->ssd));
        $this->drive=htmlspecialchars(strip_tags($this->drive));
        $this->fan=htmlspecialchars(strip_tags($this->fan));
        $this->power=htmlspecialchars(strip_tags($this->power));
        $this->motherboard=htmlspecialchars(strip_tags($this->motherboard));
        $this->network=htmlspecialchars(strip_tags($this->network));
        $this->os=htmlspecialchars(strip_tags($this->os));
        $this->ram=htmlspecialchars(strip_tags($this->ram));
        $this->guid=htmlspecialchars(strip_tags($this->guid));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->gindex=htmlspecialchars(strip_tags($this->gindex));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // привязываем значения 
        $stmt->bindParam(':cpu', $this->cpu);
        $stmt->bindParam(':gpu', $this->gpu);
        $stmt->bindParam(':pccase', $this->pccase);
        $stmt->bindParam(':ssd', $this->ssd);
        $stmt->bindParam(':drive', $this->drive);
        $stmt->bindParam(':fan', $this->fan);
        $stmt->bindParam(':power', $this->power);
        $stmt->bindParam(':motherboard', $this->motherboard);
        $stmt->bindParam(':network', $this->network);
        $stmt->bindParam(':os', $this->os);
        $stmt->bindParam(':ram', $this->ram);
        $stmt->bindParam(':guid', $this->guid);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':gindex', $this->gindex);
        $stmt->bindParam(':price', $this->price);
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
        c.name as category_name, p.id, p.cpu, p.gpu, p.pccase, p.ssd, p.drive, p.fan, p.power, p.motherboard, p.network, p.os, p.ram, p.guid, p.description, p.gindex, p.price
    FROM
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
        $this->cpu = $row['cpu'];
        $this->gpu = $row['gpu'];
        $this->pccase= $row['pccase'];
        $this->ssd = $row['ssd'];
        $this->drive = $row['drive'];
        $this->power = $row['power'];
        $this->motherboard = $row['motherboard'];
        $this->network = $row['network'];
        $this->os = $row['os'];
        $this->ram = $row['ram'];
        $this->guid = $row['guid'];
        $this->description = $row['description'];
        $this->gindex = $row['gindex'];
        $this->price = $row['price'];

    }


    function create(){

        // запрос для вставки (создания) записей 
        $query = "INSERT INTO
                    " . $this->table_name . "
        SET cpu = :cpu, gpu = :gpu, pccase = :pccase, ssd = :ssd, drive = :drive, fan = :fan, power = :power, motherboard = :motherboard, network= :network, os = :os, ram = :ram, guid = :guid, description = :description, gindex = :gindex, price = :price ";
    
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
    
        // очистка 
        $this->cpu=htmlspecialchars(strip_tags($this->cpu));
        $this->gpu=htmlspecialchars(strip_tags($this->gpu));
        $this->pccase=htmlspecialchars(strip_tags($this->pccase));
        $this->ssd=htmlspecialchars(strip_tags($this->ssd));
        $this->drive=htmlspecialchars(strip_tags($this->drive));
        $this->fan=htmlspecialchars(strip_tags($this->fan));
        $this->power=htmlspecialchars(strip_tags($this->power));
        $this->motherboard=htmlspecialchars(strip_tags($this->motherboard));
        $this->network=htmlspecialchars(strip_tags($this->network));
        $this->os=htmlspecialchars(strip_tags($this->os));
        $this->ram=htmlspecialchars(strip_tags($this->ram));
        $this->guid=htmlspecialchars(strip_tags($this->guid));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->gindex=htmlspecialchars(strip_tags($this->gindex));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // привязка значений 
        $stmt->bindParam(':cpu', $this->cpu);
        $stmt->bindParam(':gpu', $this->gpu);
        $stmt->bindParam(':pccase', $this->pccase);
        $stmt->bindParam(':ssd', $this->ssd);
        $stmt->bindParam(':drive', $this->drive);
        $stmt->bindParam(':fan', $this->fan);
        $stmt->bindParam(':power', $this->power);
        $stmt->bindParam(':motherboard', $this->motherboard);
        $stmt->bindParam(':network', $this->network);
        $stmt->bindParam(':os', $this->os);
        $stmt->bindParam(':ram', $this->ram);
        $stmt->bindParam(':guid', $this->guid);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':gindex', $this->gindex);
        $stmt->bindParam(':price', $this->price);


    
        // выполняем запрос 
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }
    
    // подключение к базе данных и таблице 'pc' 
    private $conn;
    private $table_name = "pc";

    // свойства объекта 
    public $id;
    public $cpu;
    public $gpu;
    public $pccase;
    public $ssd;
    public $drive;
    public $fan;
    public $power;
    public $motherboard;
    public $network;
    public $os;
    public $ram;
    public $guid;
    public $description;
    public $gindex;
    public $price;


    // конструктор для соединения с базой данных 
    public function __construct($db){
        $this->conn = $db;
    }

    function read($gindex){
        
        // выбираем все записи 
        $query = "SELECT * FROM shop.pc";

        if ($gindex != "all" && isset($gindex) ) {
            $query = $query." WHERE gindex LIKE '$gindex'";
            
        }
    
        // подготовка запроса 
        $stmt = $this->conn->prepare($query);
    
        // выполняем запрос 
        $stmt->execute();
    
        return $stmt;
    }
}
?>