<?php ## Данные для БД
/* Подключение к базе данных MySQL с помощью вызова драйвера */
$dsn = 'mysql:dbname=ecnhtein_1;host=mysql.zzz.com.ua'; // имя базы данных и адрес сервера 
$user = 'enchtein1'; // имя пользователя
$password = '3424197sS'; // пароль

try {
    $link = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}
?>