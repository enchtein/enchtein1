<?php 
session_start(); // 09.12.2019 (Для Работы сессии)

require_once("bdconnect_pdo.php"); //NEW

session_start ();
function redirect ($url='/index.php'){
    header("Location: $url");
	exit();
}

if (!$_COOKIE['user_ID']){
    $user_id = $_SESSION['user_ID'];
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];
} else {
    $user_id = $_COOKIE['user_ID'];
    $email = $_COOKIE['email'];
    $name = $_COOKIE['name'];
}
if(!empty($name && $_POST['text'])){
// NEW
	$date = date("Y-m-d H:i:s");
    $text = $_POST['text'];
    $status = 1; // настройка по умолчанию
$add_data = [
    'id' => $user_id, 
    'Date' => $date,
    'text' => $text,
    'status' => $status,
];
$add_message = $link->prepare ("INSERT INTO users (id_message, id, Date, text, status) VALUES (NULL, :id, :Date, :text, :status)");
$add_message->execute($add_data); // Передаем подготовленный выше массив !!!
}
redirect(); //Перенаправление на старницу index.php
?>