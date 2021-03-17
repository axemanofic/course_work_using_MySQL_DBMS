<?php
	include 'connect.php';

	$red_id = htmlentities(trim($_GET['red_id']));

	if(isset($_POST['LP_POST']))
	{
		if(isset($red_id))
		{
			$LP_POST = htmlentities(trim($_POST['LP_POST']));
			$LP_WAGE = htmlentities(trim($_POST['LP_WAGE']));

			$sql_update = "UPDATE `list of post` SET `LP_POST`='$LP_POST',`LP_WAGE`='$LP_WAGE' WHERE `list of post`.`LP_ID`='$red_id'";
			$result_update = mysqli_query($link, $sql_update);
		}

		if (!$result_update) 
		{
			echo "<p>Произошла ошибка: " . mysqli_error($link) . "</p>";
		}
	}

	if(isset($red_id))
	{
		$sql_select = "SELECT `LP_ID`, `LP_POST`, `LP_WAGE` FROM `list of post` WHERE `LP_ID`='$red_id'";
		$result_select = mysqli_query($link, $sql_select);
		$row = mysqli_fetch_array($result_select);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Редактировать должность</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
</head>
<body>
	<div class="menu">
		<a class="button" href="table-post.php">НАЗАД</a>
		<a class="button" href="index.php">ГЛАВНОЕ МЕНЮ</a>
	</div>
	
	<form class="flex-box" method="post">
		<h1>Редактировать данные о должности: </h1>
		<div class="item">
			<h1>Название должности</h1>
			<input type="text" name="LP_POST" value="<?= isset($red_id) ? $row['LP_POST'] : '' ?>">
		</div>

		<div class="item">
			<h1>Заработная плата</h1>
			<input type="text" name="LP_WAGE" value="<?= isset($red_id) ? $row['LP_WAGE'] : '' ?>">	
		</div>

		<input type="submit" name="send" value="Сохранить">
		<input type="reset" value="Очистить форму">
	</form>	
</body>
</html>