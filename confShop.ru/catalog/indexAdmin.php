<?
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
?>