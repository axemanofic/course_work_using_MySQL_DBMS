<?php
	include 'connect.php';

	$red_id = htmlentities(trim($_GET['red_id']));

	if(isset($_POST['G_NAME']))
	{
		if(isset($red_id))
		{
			$G_NAME = htmlentities(trim($_POST['G_NAME']));

			$sql_update = "UPDATE `genres` SET `G_NAME`='$G_NAME' WHERE `genres`.`G_ID`='$red_id'";
			$result_update = mysqli_query($link, $sql_update);
		}

		if (!$result_update) 
		{
			echo "<p>Произошла ошибка: " . mysqli_error($link) . "</p>";
		}
	}

	if(isset($red_id))
	{
		$sql_select = "SELECT `G_ID`, `G_NAME` FROM `genres` WHERE `G_ID`='$red_id'";
		$result_select = mysqli_query($link, $sql_select);
		$row = mysqli_fetch_array($result_select);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Редактировать жанр</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
</head>
<body>
	<a class="button" href="table-genres.php">НАЗАД</a>

	<form class="flex-box" method="post">
		<h1>Редактировать данные о жанре: </h1>
		<div class="item">
			<h1>Название жанра</h1>
			<input type="text" name="G_NAME" value="<?= isset($red_id) ? $row['G_NAME'] : ''; ?>">
		</div>

		<input type="submit" name="send" value="Сохранить">
		<input type="reset" value="Очистить форму">
	</form>	
</body>
</html>