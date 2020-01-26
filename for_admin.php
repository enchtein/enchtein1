<?php
session_start ();
require_once("bdconnect_pdo.php"); //Добавляем файл подключения к БД
function redirect ($url='/admin.php'){
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
$id_message = $_GET['id_message'];
//echo $id_message; die;
/*$_SESSION['status'] = $admin_status;*/
if (isset($_GET['allow'])) { // если статус РАЗРЕШИТЬ
//ЗАПРОС НА АПДЕЙТ В БД
$change_status = $link->prepare('UPDATE users SET status=:status WHERE id_message=:id_message'); //user_id - НУЖНО ПОСТАВИТЬ НОМЕР КОММЕНТИРИЯ !!! // апдейтим таблицу users - заменяем старый status новым
$new_status = $change_status->execute([':status' => 1, ':id_message' => $id_message]); //user_id - НУЖНО ПОСТАВИТЬ НОМЕР КОММЕНТИРИЯ !!! // апдейтим таблицу users - заменяем старый status новым
}
if (isset($_GET['deny'])) { // если статус ЗАПРЕТИТЬ
//ЗАПРОС НА АПДЕЙТ В БД
$change_status = $link->prepare('UPDATE users SET status=:status WHERE id_message=:id_message'); //user_id - НУЖНО ПОСТАВИТЬ НОМЕР КОММЕНТИРИЯ !!! // апдейтим таблицу users - заменяем старый status новым
$new_status = $change_status->execute([':status' => 0, ':id_message' => $id_message]); //user_id - НУЖНО ПОСТАВИТЬ НОМЕР КОММЕНТИРИЯ !!! // апдейтим таблицу users - заменяем старый status новым
}
if (isset($_GET['delete'])) { // если статус УДАЛИТЬ
//ЗАПРОС НА УДАЛЕНИЕ В БД
$change_status = $link->prepare('DELETE FROM users WHERE id_message=:id_message'); //user_id - НУЖНО ПОСТАВИТЬ НОМЕР КОММЕНТИРИЯ !!! // апдейтим таблицу users - заменяем старый status новым
$new_status = $change_status->execute([':id_message' => $id_message]); //user_id - НУЖНО ПОСТАВИТЬ НОМЕР КОММЕНТИРИЯ !!! // апдейтим таблицу users - заменяем старый status новым
}
redirect(); //Перенаправление на старницу admin.php
?>