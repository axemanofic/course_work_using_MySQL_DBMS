<?php
	include 'connect.php';

	$red_id = htmlentities(trim($_GET['red_id']));

	if(isset($_POST['B_TITLE']))
	{
		if(isset($red_id))
		{
			$B_TITLE = htmlentities(trim($_POST['B_TITLE']));
			$B_DATE = htmlentities(trim($_POST['B_DATE']));
			$B_AUTHORS = htmlentities(trim($_POST['B_AUTHORS']));
			$B_GENRES = htmlentities(trim($_POST['B_GENRES']));
			$B_PRICE = htmlentities(trim($_POST['B_PRICE']));
			$B_NUMBERS = htmlentities(trim($_POST['B_NUMBERS']));

			$sql_update = "UPDATE `books` SET `B_TITLE`='$B_TITLE',`B_DATE`='$B_DATE',`B_AUTHORS`='$B_AUTHORS',`B_GENRES`='$B_GENRES',`B_PRICE`='$B_PRICE', `B_NUMBERS`='$B_NUMBERS' WHERE `books`.`B_ID` = '$red_id'";
			$result_update = mysqli_query($link, $sql_update);
		}

		if (!$result_update) 
		{
			echo "<p>Произошла ошибка: " . mysqli_error($link) . "</p>";
		}
	}

	if(isset($red_id))
	{
		$sql_select = "SELECT `B_ID`, `B_TITLE`, `B_DATE`, `B_AUTHORS`, `B_GENRES`, `B_PRICE`, `B_NUMBERS` FROM `books` WHERE `B_ID`='$red_id'";
		$result_select = mysqli_query($link, $sql_select);
		$row = mysqli_fetch_array($result_select);
	}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Редактировать книгу</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
</head>
<body>
	<a class="button" href="table-book.php">НАЗАД</a>

	<form class="flex-box" method="post">
		<h1>Редактировать  данные о книге: </h1>
		<div class="item">
			<h1>Название книги</h1>
			<input type="text" name="B_TITLE" value="<?= isset($red_id) ? $row['B_TITLE'] : ''; ?>">
		</div>

		<div class="item">
			<h1>Дата издания</h1>
			<input type="date" name="B_DATE" value="<?= isset($red_id) ? $row['B_DATE'] : ''; ?>">			
		</div>

		<div class="item">
			<h1>Автор книги</h1>
			<select name="B_AUTHORS">
				<?php
					include 'connect.php';

					$select_authors1 = "SELECT `A_ID`, `A_FIO` FROM `authors` WHERE `authors`.`A_ID` = (SELECT `B_AUTHORS` FROM `books` WHERE `books`.`B_ID` = '$red_id')";
					$result_authors1 = mysqli_query($link, $select_authors1);
					while ($row_authors1 = mysqli_fetch_array($result_authors1))
					{
						echo "<option value='".$row_authors1['A_ID']."'>".$row_authors1['A_FIO']."</option>";
						$buffer = $row_authors1['A_ID'];
					}
					
					$select_authors2 = "SELECT `A_ID`, `A_FIO` FROM `authors`";
					$result_authors2 = mysqli_query($link, $select_authors2);

					while ($row_authors2 = mysqli_fetch_array($result_authors2)) 
					{
						if($buffer != $row_authors2['A_ID'])
						{
							echo "<option value='".$row_authors2['A_ID']."'>".$row_authors2['A_FIO']."</option>";
						}
					}
				?>
			</select>
		</div>

		<div class="item">
			<h1>Жанр книги</h1>
			<select name="B_GENRES">
				<?php
					include 'connect.php';

					$select_genres1 = "SELECT `G_ID`, `G_NAME` FROM `genres` WHERE `genres`.`G_ID` = (SELECT `B_GENRES` FROM `books` WHERE `books`.`B_ID` = '$red_id')";
					$result_genres1 = mysqli_query($link, $select_genres1);

					while ($row_genres1 = mysqli_fetch_array($result_genres1))
					{
						echo "<option value='".$row_genres1['G_ID']."'>".$row_genres1['G_NAME']."</option>";
						$buffer = $row_genres1['G_ID'];
					}

					$select_genres2 = "SELECT `G_ID`, `G_NAME` FROM `genres`";
					$result_genres2 = mysqli_query($link, $select_genres2);

					while ($row_genres2 = mysqli_fetch_array($result_genres2)) 
					{
						if($buffer != $row_genres2['G_ID'])
						{
							echo "<option value='".$row_genres2['G_ID']."'>".$row_genres2['G_NAME']."</option>";
						}
					}
				?>
			</select>
		</div>

		<div class="item">
			<h1>Цена</h1>
			<input type="text" name="B_PRICE" value="<?= isset($red_id) ? $row['B_PRICE'] : ''; ?>">			
		</div>

		<div class="item">
			<h1>Количество книг</h1>
			<input type="text" name="B_NUMBERS" value="<?= isset($red_id) ? $row['B_NUMBERS'] : ''; ?>">			
		</div>

		<input type="submit" value="Сохранить">
		<input type="reset" value="Очистить форму">
	</form>
</body>
</html>