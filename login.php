<?php
session_start();
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
        <a class="dropdown-item" href="profile.php">Profile</a>
        <a class="dropdown-item" href="register.php">Register</a>
        <a class="dropdown-item" onclick="logout.php" href="#">LogOut</a> <!-- Настроить выход с сайта -->
    </div>
</li>
							<?php elseif (isset($_POST['logout'])):	?>
						<li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                         </li>
                        <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a><!-- Настроить выход с сайта -->
                        </li>
<!-- ДОБАВИЛ 27,12,2019 --> <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Login</div>
                            <div class="card-body">
								<form method="POST" action="for_login.php">
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                        <div class="col-md-6">
										<?php if(!isset ($_POST['login'])): ?>
<input id="email" type="text" class= "form-control" placeholder=" " name="email" autocomplete="email" autofocus>
                                        <?php else: ?>
<input id="email" type="text" class= <?php if(!empty($_POST['email'])): ?>"form-control"<?php else: ?>"form-control @error('email') is-invalid @enderror"<?php endif; ?> placeholder=" " name="email">
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>Введите email</strong>
                                                </span>	
                                        <?php endif; ?>			
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                        <div class="col-md-6">
										<?php if(!isset ($_POST['login'])): ?>
<input id="password" type="password" class= "form-control" placeholder=" " name="password" autocomplete="current-password">
                                        <?php else: ?>
<input id="password" type="password" class= <?php if(!empty($_POST['password'])): ?>"form-control"<?php else: ?>"form-control @error('password') is-invalid @enderror"<?php endif; ?> placeholder=" " name="password" autocomplete="current-password">
		<!--ДОБАВИЛ-->								<!-- Валидация--><?php if(isset ($_POST['login'])) :
																			if (empty($_POST['password'])) : ?>
													                      <span class="invalid-feedback" role="alert">
        <!--СТАРОЕ -->                              <strong><!-- Валидация --><?php echo "Введите password";?></strong>
                                                                          </span>
											<?php
											elseif(!empty($_POST["password"]) && (strlen($_POST["password"]) < '6')):
														echo"Ваш пароль должен содержать хотя бы 6 символов!";
																endif;
															endif;
														endif;
														?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
                                                <label class="form-check-label" for="remember">
                                                    Remember Me
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" name="login" class="btn btn-primary">
                                               Login
                                            </button>
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