<?php
	include 'connect.php';

	$red_id = htmlentities(trim($_GET['red_id']));

	if(isset($_POST['RC_FIO']))
	{
		if(isset($red_id))
		{
			$RC_FIO = htmlentities(trim($_POST['RC_FIO']));
			$RC_TEL = htmlentities(trim($_POST['RC_TEL']));

			$sql_update = "UPDATE `regular clients` SET `RC_FIO`='$RC_FIO',`RC_TEL`='$RC_TEL' WHERE `regular clients`.`RC_ID`='$red_id'";
			$result_update = mysqli_query($link, $sql_update);
		}

		if (!$result_update) 
		{
			echo "<p>Произошла ошибка: " . mysqli_error($link) . "</p>";
		}
	}

	if(isset($red_id))
	{
		$sql_select = "SELECT `RC_ID`, `RC_FIO`, `RC_TEL` FROM `regular clients` WHERE `RC_ID`='$red_id'";
		$result_select = mysqli_query($link, $sql_select);
		$row = mysqli_fetch_array($result_select);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Редактировать клиента</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
</head>
<body>

	<a class="button" href="table-clients.php">НАЗАД</a>

	<form class="flex-box" method="post">
		<h1>Редактировать данные о клиенте: </h1>
		<div class="item">
			<h1>ФИО клиента</h1>
			<input type="text" name="RC_FIO" value="<?= isset($red_id) ? $row['RC_FIO'] : ''; ?>">
		</div>

		<div class="item">
			<h1>Номер телефона</h1>
			<input type="text" name="RC_TEL" value="<?= isset($red_id) ? $row['RC_TEL'] : ''; ?>">		
		</div>

		<input type="submit" name="send" value="Сохранить">
		<input type="reset" value="Очистить форму">
	</form>	
</body>
</html>