<?php
session_start(); // 09.12.2019 (Для Работы сессии)
//require_once("dbconnect.php");
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
<!-- ДОБАВИЛ 27,12,2019 --><?php if (isset($user_id)): ?> <!-- НАСТРОЙКА ВЫПАДАЮЩЕГО СПИСКА -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo $name;?>
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="login.php">Login</a>
        <a class="dropdown-item" href="register.php">Register</a>
        <a class="dropdown-item" onclick="logout.php" href="#">LogOut</a> <!-- Настроить выход с сайта -->
    </div>
</li>
							<?php elseif (isset($_POST['logout'])):	?>
						<li class="nav-item">										<!-- Настроить выход с сайта -->
                                <a class="nav-link" href="login.php">Login</a>		<!-- Настроить выход с сайта -->
                         </li>														<!-- Настроить выход с сайта -->
                        <li class="nav-item">										<!-- Настроить выход с сайта -->
                                <a class="nav-link" href="register.php">Register</a><!-- Настроить выход с сайта -->
                        </li>														<!-- Настроить выход с сайта -->
<!-- ДОБАВИЛ 27,12,2019 --> <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
          <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><h3>Профиль пользователя</h3></div>

                        <div class="card-body">
						<?php if ($_SESSION['profile_flag'] == ''): ?>
                          <div class="alert alert-success" role="alert">
                            Профиль успешно обновлен
                            <?php 
                            if ($_SESSION['message_1'] == "Ваш login изменен") {
                            //if (!empty($_SESSION['message_1'] || $_SESSION['message_2'] || $_SESSION['message_3'] || $_SESSION['message_4'] || $_SESSION['message_5'])) {
                                //echo " ( " . $_SESSION['message_1'] . $_SESSION['message_2'] . $_SESSION['message_3'] . $_SESSION['message_4'] . $_SESSION['message_5'] . " )";
                                echo " ( " . $_SESSION['message_1'] . " )";
                            }
                            ?>
                            <?php endif; ?>
                          </div>

                            <form action="for_profile.php" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Name</label>
                 <!-- ДОБАВИЛ 27,12,2019 --><input type="text" class="form-control" name="name" id="exampleFormControlInput1" value="<?php if (isset($user_id)): echo $name; else: echo "Имя не введено (сессия не установленна!)"; endif;?>">
										<?php if (/*$_SESSION['profile_flag']*/$_SESSION['message_1'] != ''): // проверка поля Name?>
										<span class="text text-danger">
                                                <?php echo /*"Код ошибки: " . $_SESSION['profile_flag'] . "<br/ >" . */"Сообщение: " . $_SESSION['message_1']; ?>
                                            </span>
										<?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Email</label>
<input id="email" type="email" class = <?php if (isset($user_id)): ?>"form-control"<?php else: ?>"form-control is-invalid"<?php endif; ?> value="<?php if (isset($user_id)): echo $email; else: echo "E_mail не введен (сессия не установленна!)"; endif;?>" name="email">
											<?php if (/*$_SESSION['profile_flag']*/$_SESSION['message_2'] != ''): // проверка поля Email?>
										<span class="text text-danger">
											<?php echo /*"Код ошибки: " . $_SESSION['profile_flag'] . "<br/ >" . */"Сообщение: " . $_SESSION['message_2']; ?>
                                        </span>
											<?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Аватар</label>
                                            <input type="file" class="form-control" name="image" id="exampleFormControlInput1">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
										<?php if (empty($_SESSION['profile_image'])): ?> <!-- если пользователь не залогинен -->
                                        <img src="img/no-user.jpg" alt="" class="img-fluid">
										<?php else: ?> 				<!-- если пользователь залогинен -->
										<img src="<?php echo $_SESSION['profile_image']; ?>" alt="" class="img-fluid">
										<?php endif; ?>
											<?php if (/*$_SESSION['profile_flag']*/$_SESSION['message_3'] != ''): // проверка поля Image?>
										<span class="text text-danger">
											<?php echo /*"Код ошибки: " . $_SESSION['profile_flag'] . "<br/ >" . */"Сообщение: " . $_SESSION['message_3']; ?>
                                        </span>
											<?php endif; ?>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="submit" name="Edit_profile"  class="btn btn-warning">Edit profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card-header"><h3>Безопасность</h3></div>

                        <div class="card-body">
						<?php if ($_SESSION['profile_flag'] == ''): ?>
                            <div class="alert alert-success" role="alert">
                                Пароль успешно обновлен
                            </div>
						<?php endif; ?>

                            <form action="for_profile.php" method="post"> <!-- ЗДЕСЬ НУЖНО СОЗДАТЬ ДРУГОЙ ОБРАБОТЧИК СОБЫТИЙ -->
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Current password</label>
                                            <input type="password" name="current" class="form-control" id="exampleFormControlInput1">
											<?php if (/*$_SESSION['profile_flag']*/$_SESSION['message_4'] != ''): // проверка поля Current password?>
										<span class="text text-danger">
											<?php echo /*"Код ошибки: " . $_SESSION['profile_flag'] . "<br/ >" . */"Сообщение: " . $_SESSION['message_4']; ?>
                                        </span>
											<?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">New password</label>
                                            <input type="password" name="password" class="form-control" id="exampleFormControlInput1">
											<?php if (/*$_SESSION['profile_flag']*/$_SESSION['message_5'] != ''): // проверка поля New password?>
										<span class="text text-danger">
											<?php echo /*"Код ошибки: " . $_SESSION['profile_flag'] . "<br/ >" . */"Сообщение: " . $_SESSION['message_5']; ?>
                                        </span>
											<?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Password confirmation</label>
                                            <input type="password" name="password_confirmation" class="form-control" id="exampleFormControlInput1">
											<?php if (/*$_SESSION['profile_flag']*/$_SESSION['message_5'] != ''): // проверка поля Password confirmation?>
										<span class="text text-danger">
											<?php echo /*"Код ошибки: " . $_SESSION['profile_flag'] . "<br/ >" . */"Сообщение: " . $_SESSION['message_5']; ?>
                                        </span>
											<?php endif; ?>
                                        </div>

                                        <button class="btn btn-success" type="submit" name="Submit">Submit</button>
                                        <?php unset ($_SESSION['message_1']);?>
                                    </div>
                                </div>
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
