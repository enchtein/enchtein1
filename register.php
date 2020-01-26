<?php 
session_start(); // 09.12.2019 (Для Работы сессии)
require_once("bdconnect_pdo.php"); //NEW
if (!$_COOKIE['user_ID']){
    $user_id = $_SESSION['user_ID'];
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];
} else {
    $user_id = $_COOKIE['user_ID'];
    $email = $_COOKIE['email'];
    $name = $_COOKIE['name'];
}

function redirect ($url='/index.php'){
    header("Location: $url");
	exit();
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
	<!-- <link href="css/forReading.css" rel="stylesheet"> -->
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
        <a class="dropdown-item" href="login.php">Login</a>
        <a class="dropdown-item" href="profile.php">Profile</a>
        <a class="dropdown-item" href="logout.php">LogOut</a>
        <!--<a class="dropdown-item" href="admin.php">AdminPanel</a>-->
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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Register</div>

                            <div class="card-body">
                                <form method="POST" action=""> <!-- <form method="POST" action="" novalidate> СДЕЛАТЬ ТАК ЕСЛИ НАДО УБРАТЬ ВСПЛЫВАЮЩИЕ ПОДСКАЗКИ -->
                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                        <div class="col-md-6">
                                        <?php if(!isset ($_POST['submit'])): ?>
<input id="name" type="text" class= "form-control" placeholder=" " name="name" autofocus>
                                                <!-- <span class="invalid-feedback" role="alert">
                                                    <strong>Введите имя</strong>
                                                </span>-->
                                        <?php else: ?>
                                        <!-- НОВЫЙ КУСОК -->
<?php 
    if (!empty($_POST['name'])) : //Сделай проверку на валидность e_mail
$exist_sql_db = $link->prepare('SELECT user_name FROM register WHERE user_name = :user_name'); //user_id - НУЖНО ПОСТАВИТЬ НОМЕР КОММЕНТИРИЯ !!!
$exist_sql_db->execute([':user_name' => $_POST['name']]); //user_id - НУЖНО ПОСТАВИТЬ НОМЕР КОММЕНТИРИЯ !!!
$A1 = $exist_sql_db->fetchAll(); // выбрать колонку $status		
	if (!empty($A1)) : /*print_r ($A1); die; */														// Делаем проверку в базе на существование такого же e_mail
    $mistake = "Извините, введённый вами login уже зарегистрирован. Введите другой login.";
    endif;
	else:
    $mistake = "Введите имя.";
    endif;
	?>
                                                                            <!-- КОНЕЦ НОВОГО КУСКА -->
                    
<input id="name" type="text" class= <?php if(!empty($_POST['name']) && empty($mistake)): ?>"form-control"<?php else: ?>"form-control @error('name') is-invalid @enderror"<?php endif; ?> placeholder=" " name="name" autofocus>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo $mistake; ?></strong>
                                                </span>
                                        <?php endif; ?>
<!--СТАРЫЙ КУСОЧЕК-->																		<!--?php if(isset ($_POST['submit'])) :
																						if (!empty($_POST['name'])) : //Сделай проверку на валидность e_mail
// NEW
$exist_sql_db = $link->prepare('SELECT user_name FROM register WHERE user_name = :user_name'); //user_id - НУЖНО ПОСТАВИТЬ НОМЕР КОММЕНТИРИЯ !!!
$exist_sql_db->execute([':user_name' => $_POST['name']]); //user_id - НУЖНО ПОСТАВИТЬ НОМЕР КОММЕНТИРИЯ !!!
$A1 = $exist_sql_db->fetchAll(); // выбрать колонку $status		
// End NEW																				
																							/*require_once("dbconnect.php");
																								$exist_sql_db = ("SELECT user_name FROM register WHERE user_name='".$_POST['name']."'"); // Делаем проверку в базе на существование такого же e_mail
																								$exist = mysqli_query($link, $exist_sql_db); 												// Делаем проверку в базе на существование такого же e_mail
																							$A1=mysqli_fetch_assoc($exist); 															// Делаем проверку в базе на существование такого же e_mail*/
																							if (!empty($A1)) : /*print_r ($A1); die; */														// Делаем проверку в базе на существование такого же e_mail
                                                                                            ?>
																							<span class="invalid-feedback" role="alert">
																								<strong>Извините, введённый вами login уже зарегистрирован. Введите другой login.</strong>
																							</span>
																							?php endif;
																								/*exit ("Извините, введённый вами login уже зарегистрирован. Введите другой login."); // Делаем проверку в базе на существование такого же e_mail
																							} */																						// Делаем проверку в базе на существование такого же e_mail
																				endif;
																			endif;
																			?>-->
<!--КОНЕЦ СТАРЫЙ КУСОЧЕК-->

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                        <div class="col-md-6">
                                        <?php if(!isset ($_POST['submit'])): ?>
<!--<input id="email" type="text" class= "form-control" placeholder=" " name="email">-->  <!--БЫЛО-->
<input id="email" type="email" class= <?php if(empty($_POST['email'])): ?>"form-control"<?php else: ?>"form-control @error('email') is-invalid @enderror"<?php endif; ?> placeholder=" " name="email"> <!--СТАЛО-->
                                        <?php else: ?>
<input id="email" type="text" class= <?php if(!empty($_POST['email'])): ?>"form-control"<?php else: ?>"form-control @error('email') is-invalid @enderror"<?php endif; ?> placeholder=" " name="email">
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Введите email</strong>
                                                </span>	
                                        <?php endif; ?>									
    <!--ДОБАВИЛ-->																	<?php if(isset ($_POST['submit'])) {
																						if (!empty($_POST['email'])) { //Сделай проверку на валидность e_mail 
																						if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
																						echo "E-mail адрес " . $_POST['email'] . " указан верно.\n";
																						    
																					} else {
																						echo "E-mail адрес" . $_POST['email'] . " указан неверно.\n";
																					}
// NEW
$exist_sql_db = $link->prepare('SELECT e_mail FROM register WHERE e_mail = :e_mail'); //user_id - НУЖНО ПОСТАВИТЬ НОМЕР КОММЕНТИРИЯ !!!
$exist_sql_db->execute([':e_mail' => $_POST['email']]); //user_id - НУЖНО ПОСТАВИТЬ НОМЕР КОММЕНТИРИЯ !!!
$A1 = $exist_sql_db->fetchAll(); // выбрать колонку $status		
// End NEW	
																							/*//Добавляем файл подключения к БД
																							require_once("dbconnect.php");
																								$exist_sql_db = ("SELECT e_mail FROM register WHERE e_mail='".$_POST['email']."'"); // Делаем проверку в базе на существование такого же e_mail
																								$exist = mysqli_query($link, $exist_sql_db); 												// Делаем проверку в базе на существование такого же e_mail
																							$A1=mysqli_fetch_assoc($exist); 															// Делаем проверку в базе на существование такого же e_mail*/
																							if (!empty($A1)) :  														// Делаем проверку в базе на существование такого же e_mail?>
																							<span class="invalid-feedback" role="alert">
																								<strong>Извините, введённый вами e_mail уже зарегистрирован. Введите другой e_mail.</strong>
																							</span>
																							<?php endif;
																								/*exit ("Извините, введённый вами e_mail уже зарегистрирован. Введите другой e_mail."); // Делаем проверку в базе на существование такого же e_mail
																							}*/ 																						// Делаем проверку в базе на существование такого же e_mail
																				}
																			}
																			?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                        <div class="col-md-6">
                                        <?php if(!isset ($_POST['submit'])): ?>
<input id="password" type="password" class= "form-control" placeholder=" " name="password" autocomplete="new-password">
                                        <?php else: ?>
<input id="password" type="password" class= <?php if(!empty($_POST['password'])): ?>"form-control"<?php else: ?>"form-control @error('password') is-invalid @enderror"<?php endif; ?> placeholder=" " name="password" autocomplete="new-password">
		<!--ДОБАВИЛ-->								<!-- Валидация--><?php if(isset ($_POST['submit'])) :
																			if (empty($_POST['password'])) : ?>
													                      <span class="invalid-feedback" role="alert">
        <!--СТАРОЕ -->                              <strong><!-- Валидация --><?php echo "Введите password";?></strong>
                                                </span>
											<?php elseif(!empty($_POST["password"]) && (strlen($_POST["password"]) < '6')):
														echo"Ваш пароль должен содержать хотя бы 6 символов!"; 
                                        endif;
                                  endif;
														endif;?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                        <div class="col-md-6">
                                        <?php if(!isset ($_POST['submit'])): ?>
<input id="password_confirmation" type="password" class= "form-control" placeholder=" " name="password_confirmation" autocomplete="new-password">
                                        <?php else: ?>
<input id="password_confirmation" type="password" class= <?php if(!empty($_POST['password_confirmation'])): ?>"form-control"<?php else: ?>"form-control @error('password_confirmation') is-invalid @enderror"<?php endif; ?> placeholder=" " name="password_confirmation" autocomplete="new-password">
		<!--ДОБАВИЛ-->								<!-- Валидация--><?php if(empty($_POST['password_confirmation'])) : ?>
													<span class="invalid-feedback" role="alert">
        <!--СТАРОЕ -->                              <strong><!-- Валидация --><?php echo "Введите password_confirmation";?></strong>
		<!--ДОБАВИЛ-->								<!-- <strong>Ошибка валидации</strong> -->
                                                </span>
		<!--ДОБАВИЛ-->						<?php elseif(!empty($_POST['password_confirmation']) && (strlen($_POST['password_confirmation']) < '6')):
														echo"Ваш пароль должен содержать хотя бы 6 символов!"; 
                                        
    endif; 
                              endif;?>
                              
                                        </div>
                                        <?php
if ($_POST['password'] == $_POST['password_confirmation'])
{
	$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
	//echo $hash;
} else {
	echo 'Пароли не совпадают!';
}
?><!-- -->
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" name="submit" class="btn btn-primary">
                                                Register
                                            </button>
                                        </div>
                                    </div>
<?php ## ПРОВЕРКА РАБОТОСПОСОБНОСТИ
/*if(isset($_POST['sub']))
{
  $key = $_POST['name'];
  $value = $_POST['password'];
}*/
/*echo $_POST['name'];
echo $_POST['email'];
echo $_POST['password'];*/
?>
<?php ## Добавлнение данных в БД
//Добавляем файл подключения к БД
    //require_once("dbconnect.php");
   
    if (isset ($_POST['submit']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_confirmation']) && (strlen($_POST['password']) > '6') && (strlen($_POST['password_confirmation']) > '6') && empty($mistake)) {
// NEW
	$user_name = $_POST['name'];
	$e_mail = $_POST['email'];
	$password = $_POST['password'];
	$cpassword = $_POST['password_confirmation'];
		if ($password != $cpassword) {
			echo "Please Check Your Password!";
		} else { 
		$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
$register_data = [
    'user_name' => $user_name,
    'e_mail' => $e_mail,
    'hash_password' => $hash,
];
$new_user = $link->prepare ("INSERT INTO register (id, user_name, e_mail, hash_password, image, password_cookie_token) VALUES (NULL, :user_name, :e_mail, :hash_password, '', '')"); // ПРОВЕРИТЬ НАЗВАНИЯ КОЛОНОК В БД
$new_user->execute($register_data); // Передаем подготовленный выше массив !!!
		echo "You Have Registred!";

		}
	}
?> 

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>