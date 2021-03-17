<?php
	session_start();
	include 'connect.php';
	$login = stripcslashes(htmlspecialchars(trim($_POST['login'])));
	$pass = trim($_POST['pass']);

	if(!empty($login) && !empty($pass))
	{
		$sql_access = "SELECT `A_ID_USER`, `A_LOGIN`, `A_PASSWORD`, `A_ACCESS` FROM `access` WHERE `A_LOGIN` = '$login' AND `A_PASSWORD` = '$pass'";
		$result_access = mysqli_query($link, $sql_access);
		$row_access = mysqli_num_rows($result_access);

		if($row_access == 0)
		{
			exit('Неверный логин или пароль');
		}
		else
		{
			$row_access1 = mysqli_fetch_array($result_access);
			if($row_access1['A_ACCESS'] == 'admin')
			{
				header('Location: menu_table.php');
			}
		}
	}
	mysqli_close($link);
	session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/index.css">
	<title>Авторизация</title>
</head>
<body>
	<form class="flex-box" method="post" name="formAccess">
		<h1>Авторизация : </h1>
		<div class="item">
			<h1>Логин</h1>
			<input type="text" name="login">
		</div>

		<div class="item">
			<h1>Пароль</h1>
			<input type="password" name="pass">	
		</div>

		<input type="submit" name="enter" value="Отправить">
		<input type="reset" value="Очистить">		
	</form>
</body>
</html>