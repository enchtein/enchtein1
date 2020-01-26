<?php
session_start ();
require_once("bdconnect_pdo.php");
if (!$_COOKIE['user_ID']){
    $user_id = $_SESSION['user_ID'];
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];
} else {
    $user_id = $_COOKIE['user_ID'];
    $email = $_COOKIE['email'];
    $name = $_COOKIE['name'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comments</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    Project
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
												<?php if (!empty($user_id)): ?> <!-- НАСТРОЙКА ВЫПАДАЮЩЕГО СПИСКА -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo $name;?><!-- /*НАЧАЛО*/ Настройка выпадающего списка-->
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="profile.php">Profile</a>
        <a class="dropdown-item" href="register.php">Register</a>
        <a class="dropdown-item" href="logout.php">LogOut</a>
</li>
						<?php
						else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>
							<?php endif; ?> <!-- /*КОНЕЦ*/ Настройка выпадающего списка-->
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h3>Админ панель</h3></div>

                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Аватар</th>
                                            <th>Имя</th>
                                            <th>Дата</th>
                                            <th>Комментарий</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <!--<form action="for_admin.php" method="post" enctype="multipart/form-data">-->
                                    <form action="for_admin.php" method="GET" enctype="multipart/form-data">
                                    										<!--<td> 		БЫЛО!!!!!!!
                                                <img src="img/no-user.jpg" alt="" class="img-fluid" width="64" height="64">
                                            </td>
                                            <td>John</td>
                                            <td>12/08/2045</td>
                                            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta aut quam cumque libero reiciendis, dolor.</td>
                                            <td>
											?php if ($_SESSION['status'] == 1) : ?>  ПРОВЕРКА status
                                                    <a href="" class="btn btn-success" name = "allow">Разрешить</a> status into BD: 1
											?php else : ?>  ПРОВЕРКА status
                                                    <a href="" class="btn btn-warning" name = "deny">Запретить</a status into BD: 0
											?php endif; ?>  ПРОВЕРКА status
                                                <a href="" onclick="return confirm('are you sure?')" class="btn btn-danger" name = "delete">Удалить</a>
                                            </td> -->
<?php /*$prepare_get_data = $link->prepare('SELECT * FROM users ORDER BY id_message DESC;'); // ПРОВЕРИТЬ РАБОТОСПОСОБНОСТЬ
//$prepare_get_data = $link->prepare('SELECT id_message, id, Date, text, status, (SELECT user_name FROM register WHERE id = users.id) FROM users ORDER BY id_message DESC;'); // ПРОВЕРИТЬ РАБОТОСПОСОБНОСТЬ
$prepare_get_data->execute(); // ПРОВЕРИТЬ РАБОТОСПОСОБНОСТЬ
$get_data = $prepare_get_data->fetchAll(); echo "<pre>";
*/
$prepare_get_data = $link->prepare('SELECT id_message, id, Date, text, status, (SELECT user_name FROM register WHERE id = users.id) FROM users ORDER BY id_message DESC;'); // ПРОВЕРИТЬ РАБОТОСПОСОБНОСТЬ
$prepare_get_data->execute(); // ПРОВЕРИТЬ РАБОТОСПОСОБНОСТЬ

while ($get_data = $prepare_get_data->fetch()): // ПРОВЕРИТЬ РАБОТОСПОСОБНОСТЬ // должен быть массив всех сообщений
$newROW[] = $get_data; // ПРОВЕРИТЬ РАБОТОСПОСОБНОСТЬ
endwhile; // ПРОВЕРИТЬ РАБОТОСПОСОБНОСТЬ
foreach ($newROW as $key => $data) { // Вытаскиваем все логины пользователей среди сообщений
    $login[] = $data['(SELECT user_name FROM register WHERE id = users.id)'];
}
foreach ($login as $key => $user_name) { // Вытаскиваем все изображения по логину пользователя
$prepare_image_for_select = $link->prepare('SELECT image, user_name FROM register WHERE user_name= :user_name'); // ПРОВЕРИТЬ РАБОТОСПОСОБНОСТЬ
$prepare_image_for_select->execute([':user_name' => $user_name]); // ПРОВЕРИТЬ РАБОТОСПОСОБНОСТЬ
$admin_status = $prepare_image_for_select->fetch();  // ПРОВЕРИТЬ РАБОТОСПОСОБНОСТЬ // должен быть массив всех изображений
$user_im_for_message[$admin_status['user_name']]=$admin_status['image']; // вытягиваем картинки из БД register по login
} // можно удалить дубликаты и пробовать тянуть в зависимости от логина изображения

for ($i=0; $i<count($newROW); $i++):


//echo "<pre>";
//print_r ($newROW);die;
//while ($get_data):?>
                                        <tr>
                                            <td>
											<?php 
											if (array_key_exists($newROW[$i]['(SELECT user_name FROM register WHERE id = users.id)'], $user_im_for_message)){ // проверка на наличие ключа в массиве
											$m = $user_im_for_message[$newROW[$i]['(SELECT user_name FROM register WHERE id = users.id)']];
											};
											if ($m==''): /* НАЧАЛО >>> НАСТРОЙКА ВЫВОДА КАРТИНКИ */?> 
                                                <img src="img/no-user.jpg" alt="" class="img-fluid" width="64" height="64">
												<? else: ?>
												<img src="<?php echo $m; ?>" alt="" class="img-fluid" width="64" height="64">
											<?php endif; /* КОНЕЦ >>> НАСТРОЙКА ВЫВОДА КАРТИНКИ */?>
                                            </td>
                                            <td><?php echo $newROW[$i]['(SELECT user_name FROM register WHERE id = users.id)']; /* >>> НАСТРОЙКА ВЫВОДА login */?></td>
                                            <td><?php echo $newROW[$i]['Date']; /* >>> НАСТРОЙКА ВЫВОДА date */?></td>
                                            <td><?php echo $newROW[$i]['text']; /* >>> НАСТРОЙКА ВЫВОДА text */?></td>
                                            <td>
<?php $id_message = $newROW[$i]['id_message'];
//var_dump($id_message); die; ?>
											<?php if ($newROW[$i]['status'] == 0) : ?> <!-- ПРОВЕРКА status -->
                                                    <a href="/for_admin.php?id_message=<?php echo $id_message;?>&allow=allow" class="btn btn-success" name = "allow">Разрешить</a><!-- status into BD: 1 -->

											<?php else : ?> <!-- ПРОВЕРКА status -->
                                                    <a href="/for_admin.php?id_message=<?php echo $id_message;?>&deny=deny" class="btn btn-warning" name = "deny">Запретить</a><!-- status into BD: 0 -->

											<?php endif; ?> <!-- ПРОВЕРКА status -->
                                                <a href="/for_admin.php?id_message=<?php echo $id_message;?>&delete=delete" onclick="return confirm('are you sure?')" class="btn btn-danger" name = "delete">Удалить</a>
                                            </td>
                                        </tr>
                                        <?php
endfor; 
?>
									</form>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
