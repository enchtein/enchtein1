<?php 
session_start();
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
        <?php echo $name;?>
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="profile.php">Profile</a>
        <a class="dropdown-item" href="register.php">Register</a>
        <a class="dropdown-item" href="logout.php">LogOut</a>
        <a class="dropdown-item" href="admin.php">AdminPanel</a>
</li>
						<?php
						else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>
						<?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h3>Комментарии</h3></div>
                            <div class="card-body">
<?php
// NEW
$prepare_get_data = $link->prepare('SELECT id_message, id, Date, text, status, (SELECT user_name FROM register WHERE id = users.id) FROM users WHERE status= 1 ORDER BY id_message DESC;');
$prepare_get_data->execute();
while ($get_data = $prepare_get_data->fetch()):// должен быть массив всех сообщений
$newROW[] = $get_data;
endwhile;
foreach ($newROW as $key => $data) { // Вытаскиваем все логины пользователей среди сообщений
    $login[] = $data['(SELECT user_name FROM register WHERE id = users.id)'];
}
foreach ($login as $key => $user_name) { // Вытаскиваем все изображения по логину пользователя
$prepare_image_for_select = $link->prepare('SELECT image, user_name FROM register WHERE user_name= :user_name');
$prepare_image_for_select->execute([':user_name' => $user_name]);
$admin_status = $prepare_image_for_select->fetch(); // должен быть массив всех изображений
$user_im_for_message[$admin_status['user_name']]=$admin_status['image']; // вытягиваем картинки из БД register по login
} // можно удалить дубликаты и пробовать тянуть в зависимости от логина изображения
?>

<?php if (isset ($_POST['sub'])) :  
if(!empty($name && $_POST['text'])) : ?>
							<div class="alert alert-success" role="alert">
                               <?php echo "Комментарий успешно добавлен";?>
                            </div>

                            
<?php endif;
endif;
$position = 0;
$arrayLength = count($newROW);
$limiter = 5;
function poh($currentPosition, $newROW, $limiter)
{
  global $position, $arrayLength, $user_im_for_message;
  //global $new_param, $arrayLength, $user_im_for_message;
    for($i = 0; $i < $limiter; $i++): // вывод по 5 сообщений за раз
	  if($currentPosition >= $arrayLength)
	  {
		  global $s; // установка статуса для кнопки
		  $s = "Done";
		  return;
	  }; 
        if ($newROW[$currentPosition]['status'] == 1) : // /* НАЧАЛО */ условие для вывода сообщений в зависимости от status (устанавливается на admin.php)
            ?>
                                <div class="media">
                                    <?php 
                                    if (array_key_exists($newROW[$currentPosition]['(SELECT user_name FROM register WHERE id = users.id)'], $user_im_for_message)){ // проверка на наличие ключа в массиве
                                        $m = $user_im_for_message[$newROW[$currentPosition]['(SELECT user_name FROM register WHERE id = users.id)']];
                                    };
                                    if ($m==''): ?> <!-- если пользователь не залогинен -->
                                  <img src="img/no-user.jpg" class="mr-3" alt="..." width="64" height="64">
                                    <?php else: 
                                    ?> 				<!-- если пользователь залогинен -->
                                  <img src="<?php echo $m; ?>" class="mr-3" alt="..." width="64" height="64">
                                    <?php endif; ?>
                                  <div class="media-body">  
                                  <h5 class="mt-0"><?php echo $newROW[$currentPosition]['(SELECT user_name FROM register WHERE id = users.id)'];?></h5>
                                    <span><small><?php echo $newROW[$currentPosition]['Date'];?></small></span>
                                    <p><?php echo nl2br($newROW[$currentPosition]['text']);?></p>   <!-- Добавил перенос строки nl2br при выводе-->
                                  </div>
                                </div>
<?php
		endif; // /* КОНЕЦ */ условие для вывода сообщений в зависимости от status (устанавливается на admin.php)
      $currentPosition++;
	endfor;
 $position = $currentPosition;
};

poh($position, $newROW, $limiter);
//poh($new_param, $newROW, $limiter);

if (isset($_POST['upload'])) {
poh($position, $newROW, $arrayLength);
}
?>						             
<form action =""  method="post">
<?php if ($s == ''): // кнопка активна?>
<button type="submit" name="upload" class="btn btn-success">Загрузить все</button>
<?php else: // кнопка НЕ активна?>
<button type="submit" name="upload" class="btn btn-success" disabled>Данных на вывод больше нет</button>
<?php endif; ?>
</form>
<!--NEW-->
<!--
?php // НОВЫЙ СЧЕТЧИК
if ($_GET['new_data'] !=0) {
    $new_param = $_GET['new_data'];
} else {
$new_param = 0;
}
?>

<form action ="param.php"  method="get">
<a href="/param.php?new_param=<?php echo $new_param;?>" class="btn btn-success" name = "param">New_PARAM</a>
</form>-->
<!--endNEW-->							                            
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="card">
                            <?php if (!empty($name)): ?>
                            <div class="card-header"><h3>Оставить комментарий</h3></div>
                            <div class="card-body">
								<form action="/add_message.php" method="post">
                                  <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Сообщение</label>
                                    <textarea name="text" type="text" class="form-control" id="exampleFormControlTextarea1" placeholder=" " rows="3"></textarea>
									<?php 
									if (isset ($_POST['sub']) && empty($_POST['text'])) : ?>
							<div class="alert alert-success_index" role="alert">
                               <?php echo "Введите текст";?>
                            </div>
							<?php 
							        endif; ?>
                                  </div>
                                  <button type="submit" name="sub" class="btn btn-success">Отправить</button>
                                </form>
                            </div>
                            <?php else: ?>
                            <div class="card-header"><h3>Чтобы оставить комментарий, <a href="login.php">авторизирутесь</a></h3></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>