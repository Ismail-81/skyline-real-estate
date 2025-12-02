<?php 
session_start();

header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if(!isset($_SESSION['admin']) && !isset($_SESSION['user_id'])){
    header('location: login.php');
    exit();
}



?>