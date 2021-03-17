<?php 
	include 'connect.php';

	$red_id = htmlentities(trim($_GET['red_id']));

	if(isset($_POST['A_FIO']))
	{
		if(isset($red_id))
		{
			$A_FIO = htmlentities(trim($_POST['A_FIO']));
			$A_BORN = htmlentities(trim($_POST['A_BORN']));

			$sql_update = "UPDATE `authors` SET `A_FIO` = '$A_FIO', `A_BORN` = '$A_BORN' WHERE `authors`.`A_ID` = '$red_id'";
			$result_update = mysqli_query($link, $sql_update);
		}

		if (!$result_update) 
		{
			echo "<p>Произошла ошибка: " . mysqli_error($link) . "</p>";
		}
	}

	if(isset($red_id))
	{
		$sql_select = "SELECT A_ID, A_FIO, A_BORN FROM `authors` WHERE `A_ID` = '$red_id'";
		$result_select = mysqli_query($link, $sql_select);
		$row = mysqli_fetch_array($result_select);
	}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Редактировать автора</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
</head>
<body>
	<a class="button" href="index.php">НАЗАД</a>

	<form class="flex-box" method="post">
		<h1>Редактировать данные об авторе: </h1>
		<div class="item">
			<h1>ФИО Автора</h1>
			<input type="text" name="A_FIO" value="<?= isset($red_id) ? $row['A_FIO'] : ''; ?>">
		</div>

		<div class="item">
			<h1>Дата рождения</h1>
			<input type="date" name="A_BORN" value="<?=isset($red_id) ? $row['A_BORN'] : ''; ?>">			
		</div>

		<input type="submit" name="send" value="Сохранить">
		<input type="reset" name="clear" value="Очистить форму">	
	</form>
</body>
</html>