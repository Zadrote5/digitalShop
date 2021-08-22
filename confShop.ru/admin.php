<?php
session_start();
//авторизация
if($_SESSION['admin']==false){
  header("Location: auth.php");
  exit;
 }
if($_GET['do'] == 'logout'){
 unset($_SESSION['admin']);
 session_destroy();
 header("Location: index.php");
}


function guidv4($data)
{
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

$connect = new PDO("mysql:host=localhost; dbname=shop; charset=utf8", 'root','root');
if (isset($_POST["submitted1"])){
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $socket = $_POST['socket'];
    $upload_image=$_FILES["myimage"]["name"];
    $folder="/img/";
    $filebasename=$_FILES["file"]["name"];
    $fileType=pathinfo($filebasename,PATHINFO_EXTENSION);
    $my_uuid = str_replace('-', '', guidv4(openssl_random_pseudo_bytes(16)));
    $filenameNew = $my_uuid . "$fileType";
    copy($_FILES["myimage"]["tmp_name"],'img/'. $filenameNew);
    $query = $connect->query("INSERT INTO shop.products(name, guid, description, price, socket, category) VALUES ('$name', '$my_uuid', '$description', '$price', '$socket', '$category' )");

    //проверка на успешность выполненной выше операции
if ($query) {
  echo '<script language="javascript">';
  echo 'alert("Product successfully added")';
  echo '</script>';
}
  else {
    echo "<pre>";
    var_dump($connect->errorInfo());
    echo "</pre>";
  }
}



if (isset($_POST["submitted2"])){
  $cpu = $_POST['cpu'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $gpu = $_POST['gpu'];
  $case = $_POST['case'];
  $ssd = $_POST['ssd'];
  $drive = $_POST['drive'];
  $fan = $_POST['fan'];
  $power = $_POST['power'];
  $motherboard = $_POST['motherboard'];
  $network = $_POST['network'];
  $os = $_POST['os'];
  $ram = $_POST['ram'];
  $gindex = $_POST['gindex'];
  $upload_image=$_FILES["myimage"]["name"];
  $folder="/img/";
  $filebasename=$_FILES["file"]["name"];
  $fileType=pathinfo($filebasename,PATHINFO_EXTENSION);
  $my_uuid = str_replace('-', '', guidv4(openssl_random_pseudo_bytes(16)));
  $filenameNew = $my_uuid . "$fileType";
  copy($_FILES["myimage"]["tmp_name"],'img/'. $filenameNew);
  $query = $connect->query("INSERT INTO shop.pc (cpu, gpu, pccase, ssd, drive, fan, power, motherboard, network, os, ram, guid, description, gindex, price) VALUES ('$cpu', '$gpu', '$case', '$ssd', '$drive', '$fan', '$power', '$motherboard', '$network', '$os', '$ram', '$my_uuid', '$description', '$gindex', '$price ')");

  //проверка на успешность выполненной выше операции
if ($query) {
echo '<script language="javascript">';
echo 'alert("PC successfully added")';
echo '</script>';
}
else {
  echo "<pre>";
  var_dump($connect->errorInfo());
  echo "</pre>";
}
}





?>
 <!DOCTYPE html>
<html lang='ru'>
<title>MYsite</title>
 <meta charset="utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=0.8">

  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>MYsite</title>
 </head>

<style>
.form-control{margin-bottom:13px}
legend{color: white;}

</style>

<div class="container">
 <div class="row">
 <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4 well well-sm">
 <legend><i class="glyphicon glyphicon-home"></i></a>Добавление процессора</legend>
 <form action="" method="POST" class="form" role="form" enctype="multipart/form-data">
  <input class="form-control" name="name" id="name" placeholder="Название товара" type="text" required="required"/>
  <input class="form-control" name="socket" id="socket" placeholder="Сокет" type="text" />
  <input class="form-control" name="price" id="price" placeholder="Цена товара" type="number" required="required"/>
  <input class="form-control" name="category" id="category" placeholder="Категория " type="text" required="required"/>
  <input class="form-control" type="file" name="myimage" id="myimage" accept=".jpg,.png,.jpeg,.pic" required="required">
  <textarea name="description" id="description" class="form-control" rows="9" cols="25" required="required" placeholder="Описание товара"></textarea>
  <button class="btn btn-lg btn-primary btn-block" name="submitted1" type="submit" value="Upload">Отправить</button>
 </form>
 </div>
 </div>
</div>

<div class="container">
 <div class="row">
 <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4 well well-sm">
 <legend><i class="glyphicon glyphicon-home"></i></a>Добавление компа</legend>
 <form action="" method="POST" class="form" role="form" enctype="multipart/form-data">
  <input class="form-control" name="cpu" id="cpu" placeholder="Название cpu" type="text" required="required"/>
  <input class="form-control" name="gpu" id="gpu" placeholder="gpu" type="text" />
  <input class="form-control" name="case" id="case" placeholder="case" type="text" required="required"/>
  <input class="form-control" name="ssd" id="ssd" placeholder="ssd" type="text" required="required"/>
  <input class="form-control" name="drive" id="drive" placeholder="drive" type="text" />
  <input class="form-control" name="fan" id="fan" placeholder="fan" type="text" required="required"/>
  <input class="form-control" name="power" id="power" placeholder="power" type="text" required="required"/>
  <input class="form-control" name="motherboard" id="motherboard" placeholder="motherboard" type="text" required="required"/>
  <input class="form-control" name="network" id="network" placeholder="network" type="text" />
  <input class="form-control" name="os" id="os" placeholder="os" type="text" />
  <input class="form-control" name="ram" id="ram" placeholder="ram" type="text" required="required"/>
  <input class="form-control" name="gindex" id="gindex" placeholder="gindex" type="text" required="required"/>
  <input class="form-control" name="price" id="price" placeholder="price" type="text" required="required"/>
  <input class="form-control" type="file" name="myimage" id="myimage" accept=".jpg,.png,.jpeg,.pic" required="required">
  <textarea name="description" id="description" class="form-control" rows="9" cols="25" required="required" placeholder="Описание товара"></textarea>
  <button class="btn btn-lg btn-primary btn-block" name="submitted2" type="submit" value="Upload">Отправить</button>
 </form>
 </div>
 </div>
</div>




<?


$allItems =  $connect->query("SELECT * FROM shop.products ");



foreach ($allItems as $allItems){
?>
<div class="card1 bg-dark mt-5 mb-5">
  <div class="img-wrap1">
  <img  src="img/<?=$allItems['guid'];?>" width=300 height=300 alt="picture">
  </div>
  <div class="content-wrap1">
    <h3 class="title1"><?=$allItems['name'];?></h3>
      <p class="price1"><?=$allItems['price'];?>$</p>
      <p class="description1"><?=$allItems['description'];?></p>
        <div class="toggle-wrap1">
          <a class="toggle-buy1" href="#">BUY</a>
          <a class="toggle-info1" href="?del=<?=$allItems['id'];?>">Delete</a>
        </div>
  </div>
</div>


<?
}
?>













</html>
