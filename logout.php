<?php //Добавляем файл подключения к БД // Удаление данных куки
session_start();
setcookie('name', '', time()-1);
setcookie('email', '', time()-1);
setcookie('user_ID', '', time()-1);
unset ($_SESSION['name']);
unset ($_SESSION['email']);
unset ($_SESSION['user_ID']);
function redirect ($url='/'){
	header("Location: $url");
	exit();
}
redirect();
//$_COOKIE['name']=;
/*
require_once("dbconnect.php");



if(isset($_COOKIE["password_cookie_token"])){
 
    $update_password_cookie_token = $mysqli->query("UPDATE users SET password_cookie_token = '' WHERE email = '".$_SESSION["email"]."'");
     
    if(!$update_password_cookie_token){
        echo "Ошибка ".$mysqli->error();
    }else{
        setcookie("password_cookie_token", "", time() - 3600);
    }
}*/
?>