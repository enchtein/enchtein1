<?php
session_start();
require_once("bdconnect_pdo.php"); //Добавляем файл подключения к БД

function dd ($var, $die=1) {
	echo "<pre>";
	print_r ($var, true);
	echo "</pre>";
}
function redirect ($url='/profile.php'){
	header("Location: $url");
	exit();
}
function cycle ($mass){ // для проверки повторений
	global $check;
	for ($i=0; $i<count($mass); $i++){
		$newmass[]=$mass[$i]['user_name'];
	}
	//echo "<pre>";
	//print_r ($newmass); die;
	$check = count($newmass);
}

$user_id = $_SESSION["user_ID"];
$name = $_SESSION["name"];
/* ПОЯСНЕНИЯ $_SESSION['profile_flag'] ПО ОШИБКАМ В $_SESSION['message']

1 - для name
2 - для email
3 - для image (здесь не ошибка а просто предупреждение)
4 - для current
5 - для password
6 - для password_confirmation
*/



/* подготовленные запросы НАЧАЛО */
/*$prepare_profile_select = $link->prepare('SELECT * FROM register WHERE id = :user_id');
$prepare_profile_select->execute([':user_id' => $user_id]);*/
//$user_name = "Dima";
//                                                                   $prepare_profile_select = $link->prepare('SELECT * FROM register WHERE user_name = :user_name');
//                                                                   $prepare_profile_select->execute([':user_name' => $user_name]);
/*$profile_name = $prepare_profile_select->fetchAll();
echo "<pre>";
print_r ($profile_name);
for ($i=0; $i<count($profile_name); $i++){
	$newmass[]=$profile_name[$i]['user_name'];
}
print_r ($newmass);
if (array_count_values($profile_name['user_name'] != 1)){
	echo "есть повторения";
}

die;*/
//$profile_name = $prepare_profile_select->fetchAll(PDO::FETCH_COLUMN, 1);
//echo "<pre>";
//print_r ($profile_name); die;
/* подготовленные запросы КОНЕЦ */

## 1) работа с name----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ВСЕ РАБОТАЕТ ЧЕТКО!
										$oldName = $_SESSION["name"];
										$oldEmail = $_SESSION["email"];
										if(isset ($_POST['Edit_profile'])) {
											if (!empty($_POST['name'])) { // Если не пустой login
											$prepare_profile_select = $link->prepare('SELECT * FROM register WHERE user_name = :user_name');
											$prepare_profile_select->execute([':user_name' => $_POST['name']]);
											$profile_name = $prepare_profile_select->fetchAll();
											//echo "<pre>";
											//print_r ($profile_name); die;
											if (!$profile_name){
												$check = '';
											cycle ($profile_name);
											}
														if ($check > 1 && $check!=0) { // Делаем проверку в базе на существование такого же login
															$_SESSION['message_1'] = "Извините, введённый вами login уже зарегистрирован. Введите другой login.";
															redirect();
														} else {
															//echo $user_id;
															//echo $_POST['name']; die;
															$change_name = $link->prepare('UPDATE register SET user_name=:user_name WHERE id=:id'); // апдейтим таблицу register - заменяем старый login новым
															$change_name->execute([':user_name' => $_POST['name'], ':id' => $user_id]); // апдейтим таблицу register - заменяем старый login новым
															//print_r($change_name); die;
															$name_profile_select = $link->prepare('SELECT * FROM register WHERE user_name = :user_name');
															$name_profile_select->execute([':user_name' => $_POST['name']]);
															$profile_new_name = $name_profile_select->fetchAll();
															$newName = $profile_new_name['0']['user_name'];
															//print_r ($profile_new_name); die;
															
															}
											} else {
													$_SESSION['message_1'] = "Вы не ввели name.";
													redirect();
												}
											if ($oldName != $newName) {
												$_SESSION['message_1'] = "Ваш login изменен";
												$_SESSION["name"] = $newName; // присвоение нового имени переменной
											} else {
												$_SESSION['message_1'] = "Ваш login НЕ изменен";
											}
										}

## 2) Работа с e_mail---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ВСЕ РАБОТАЕТ ЧЕТКО!
if(isset ($_POST['Edit_profile'])) {
	if (!empty($_POST['email'])) { // Если не пустой email
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {// Если email проходит валидацию на сервере
		//$_SESSION['profile_flag'] = '';
		$_SESSION['message_2'] = "E-mail адрес " . $_POST['email'] . " указан верно.\n";
		} else {// Если email НЕ проходит валидацию на сервере
		//$_SESSION['profile_flag'] = 2;
		$_SESSION['message_2'] = "E-mail адрес" . $_POST['email'] . " указан неверно.\n";
		}
		$prepare_profile_select = $link->prepare('SELECT * FROM register WHERE e_mail = :email');
		$prepare_profile_select->execute([':email' => $_POST['email']]);
		$old_bd_email = $prepare_profile_select->fetchAll(PDO::FETCH_COLUMN, 2);
		//echo $old_bd_email; die;
			if (count ($old_bd_email) > 1) { 																		// Делаем проверку в базе на существование такого же e_mail
			//$_SESSION['profile_flag'] = 2;
			$_SESSION['message_2'] = "Извините, введённый вами e_mail уже зарегистрирован. Введите другой e_mail.";
				exit ("Извините, введённый вами e_mail уже зарегистрирован. Введите другой e_mail."); 		// Делаем проверку в базе на существование такого же e_mail
			} else {
				//$change_email = ("UPDATE register SET e_mail='".$_POST['email']."' WHERE id='".$user_id."'");									
		$change_email = $link->prepare('UPDATE register SET e_mail=:new_e_mail WHERE id=:id'); // апдейтим таблицу register - заменяем старую картинку новой
		$change_email->execute([':new_e_mail' => $_POST['email'], ':id' => $user_id]); // апдейтим таблицу register - заменяем старую картинку новой
		$name_profile_select = $link->prepare('SELECT e_mail FROM register WHERE user_name = :user_name');
		$name_profile_select->execute([':user_name' => $name]);
		$profile_new_email = $name_profile_select->fetchAll();
		$new_email = $profile_new_email['0']['e_mail'];
		$_SESSION['email'] = $new_email;
			}
				// закрываем подключение
				// mysqli_close($link);
	} else {
		//$_SESSION['profile_flag'] = 2;
		$_SESSION['message_2'] = "Вы не ввели Email";
		redirect();//перенаправление в случае если не введен Email
	}
	if ($oldEmail != $_POST['email']) {
		//echo "Ваш Email изменен";
		//$_SESSION['profile_flag'] = '';
		$_SESSION['message_2'] = "Ваш Email изменен";
		
	} else {
		//$_SESSION['profile_flag'] = 2;
		$_SESSION['message_2'] = "Ваш Email НЕ изменен";
		//echo "Ваш Email НЕ изменен";
	}
}


## 3) Работа с картинкой ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ВСЕ РАБОТАЕТ ЧЕТКО!
if (isset($_POST['Edit_profile'])) {
	$prepare_profile_select = $link->prepare('SELECT * FROM register WHERE id = :id');
	$prepare_profile_select->execute([':id' => $user_id]);
	$old_url_image = $prepare_profile_select->fetchAll(PDO::FETCH_COLUMN, 4);
	if(!empty($_FILES['image']['name'])){ // если устанавливаем новую картинку - то заменяем ее в БД
		// для новой картинки
		$data = str_replace('/', '.', $_FILES['image']['type']);
        $row = stristr($data, ".");
		$new_url_image = "img/uploads/".uniqid().$row; //путь картинки
		move_uploaded_file ($_FILES['image']['tmp_name'], $new_url_image); // загрузка файла *нужно создать папку: uploads*
		$change_image = $link->prepare('UPDATE register SET image=:new_image WHERE id=:id'); // апдейтим таблицу register - заменяем старую картинку новой
		$change_image->execute([':new_image' => $new_url_image, ':id' => $user_id]); // апдейтим таблицу register - заменяем старую картинку новой
		$newImage_profile_select = $link->prepare('SELECT image FROM register WHERE id = :id'); // нужно сделать запрос на выборку новой картинки
		$newImage_profile_select->execute([':id' => $user_id]); // нужно сделать запрос на выборку новой картинки
		$new_image = $newImage_profile_select->fetchAll(); // результат выборки новой картинки
		$url_image = $new_image['0']['0'];
		$_SESSION['message_3'] = "Установленна новая картинка!";
	} else { // если НЕ устанавливаем новую картинку - то в БД ничего не меняем
		$url_image = $old_url_image['0'];
		$_SESSION['message_3'] = "Картинка не изменилась!";
	}
	$_SESSION['profile_image'] = $url_image; // записываем в переменную сессии путь картинки
}
## 4) Работа с паролем------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ВСЕ РАБОТАЕТ ЧЕТКО!
if (isset($_POST['Submit'])) {
	$profile_hash_sql_db = $link->prepare('SELECT hash_password FROM register WHERE id = :user_id');
	$profile_hash_sql_db->execute([':user_id' => $user_id]);
	$hash_from_profile = $profile_hash_sql_db->fetchAll();
	if (password_verify($_POST['current'], $hash_from_profile['0']['0'])){ // если пароль и хеш совпадают
		if ($_POST['password'] !='' AND $_POST['password_confirmation'] !='')	{
		if ($_POST['password'] == $_POST['password_confirmation']) {
			// заменить старый пароль на новый
			$new_hash = password_hash($_POST['password'], PASSWORD_DEFAULT); // создаем хэш нового пароля
			$change_pass = $link->prepare('UPDATE register SET hash_password=:new_hash WHERE id=:id'); // апдейтим таблицу register - заменяем старый хэш новым
			$change_pass->execute([':new_hash' => $new_hash, ':id' => $user_id]); // апдейтим таблицу register - заменяем старый хэш новым
			$_SESSION['message_5'] = "Установлен новый пароль!";
			$_SESSION['message_4'] = "Установлен новый пароль!";
		} else {
		$_SESSION['message_5'] = "New password or Password confirmation неправильные.";
		} 
	} else {
			$_SESSION['message_5'] = "New password or Password confirmation не заполненны.";
		}
	} else {
		$_SESSION['message_4'] = "Current password неправильный.";
	}
}
//mysqli_close($link);// закрыть подключение
redirect(); //Перенаправление на старницу profile.php
?>