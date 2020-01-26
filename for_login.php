<?php
 ## кусок #1
session_start(); // старт сессии
//require_once("dbconnect.php"); //Добавляем файл подключения к БД
require_once("bdconnect_pdo.php"); //Добавляем файл подключения к БД
function dd ($var, $die=1) {
	echo "<pre>";
	print_r ($var, true);
	echo "</pre>";
}
function redirect ($url='/'){
	header("Location: $url");
	exit();
}

if (isset($_POST['login'])) {
// NEW
	$email = $_POST['email'];
	$pass = $_POST['password'];
	$check = $_POST['remeber'];
	
//Validate START
$prepare_login_select = $link->prepare('SELECT * FROM register WHERE e_mail = :e_mail'); // ПРОВЕРИТЬ !!!
$prepare_login_select->execute([':e_mail' => $email]); // ПРОВЕРИТЬ !!!
$login_status = $prepare_login_select->fetch(); // ПРОВЕРИТЬ !!!
//echo "<pre>";
//print_r ($login_status);die;
	if (!empty($email) && !empty($pass) && strlen($pass > '6')) { //ВАЛИДАЦИЯ
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			echo "E-mail адрес " . $email . " указан неверно.\n";
			} elseif (empty($login_status['e_mail'])) {
				exit ("Извините, введённый вами email не зарегистрирован. Введите другой email."); // Делаем проверку в базе на существование такого же e_mail
			} elseif (!password_verify($pass, $login_status['hash_password'])) { // Сделать из хеша прежний пароль и сверить его с вводимым пользователем
				echo 'Пароль неправильный.'; // при ошибке
			}
			$_SESSION["user_ID"] = $login_status['id']; // присвоение массиву сесии данных из БД
			$_SESSION["name"] = $login_status['user_name']; // присвоение массиву сесии данных из БД
			$_SESSION["email"] = $login_status['e_mail']; // присвоение массиву сесии данных из БД
			if(isset($check)){
				setcookie("user_ID", $login_status['id'], time() + (1000 * 60 * 60 * 24 * 30)); // установка куки (данные из БД)
				setcookie("name", $login_status['user_name'], time() + (1000 * 60 * 60 * 24 * 30)); // установка куки (данные из БД)
				setcookie("email", $login_status['e_mail'], time() + (1000 * 60 * 60 * 24 * 30)); // установка куки (данные из БД)
			}
			redirect(); //Перенаправление на старницу index.php
		}
}
//Сделать проверну на заполненность полей с возвратом на ЛОГИН.php
if (empty($email) or empty($pass)){
	header("Location: /login.php");
}
// End NEW	
/*
	$email = trim(htmlspecialchars($_POST['email']));
	$pass = trim(htmlspecialchars($_POST['password']));
	$check = trim(htmlspecialchars($_POST['remeber']));

//Validate START
$exist_sql_db = ("SELECT * FROM register WHERE e_mail='".$_POST['email']."'"); // Делаем выборку в бд по email (запрос)
$exist = mysqli_query($link, $exist_sql_db); // Делаем выборку в бд по email (отправка запроса)
$data=mysqli_fetch_assoc($exist); // Делаем выборку в бд по email (вернуть результат запроса)
	if (!empty($_POST['email']) && !empty($_POST["password"]) && strlen($_POST["password"] > '6')) { //ВАЛИДАЦИЯ
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			echo "E-mail адрес " . $_POST['email'] . " указан неверно.\n";
			} elseif (empty($data['e_mail'])) {
				exit ("Извините, введённый вами email не зарегистрирован. Введите другой email."); // Делаем проверку в базе на существование такого же e_mail
			} elseif (!password_verify($_POST['password'], $data['hash_password'])) { // Сделать из хеша прежний пароль и сверить его с вводимым пользователем
				echo 'Пароль неправильный.'; // при ошибке
			}
			$_SESSION["user_ID"] = $data['id']; // присвоение массиву сесии данных из БД
			$_SESSION["name"] = $data['user_name']; // присвоение массиву сесии данных из БД
			$_SESSION["email"] = $data['e_mail']; // присвоение массиву сесии данных из БД
			if(isset($check)){
				setcookie("user_ID", $data['id'], time() + (1000 * 60 * 60 * 24 * 30)); // установка куки (данные из БД)
				setcookie("name", $data['user_name'], time() + (1000 * 60 * 60 * 24 * 30)); // установка куки (данные из БД)
				setcookie("email", $data['e_mail'], time() + (1000 * 60 * 60 * 24 * 30)); // установка куки (данные из БД)
			}
			redirect(); //Перенаправление на старницу index.php
		}
}

//Сделать проверну на заполненность полей с возвратом на ЛОГИН.php
if (empty($_POST['email']) or empty($_POST["password"])){
	header("Location: /login.php");
}*/
?>