<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Добавить Книгу</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
</head>
<body>
	<div class="menu">
		<a class="button" href="table-book.php">НАЗАД</a>
		<a class="button" href="menu_table.php">ГЛАВНОЕ МЕНЮ</a>
		<a class="button" href="table_authors_edit.php">ДОБАВИТЬ АВТОРА</a>
		<a class="button" href="table_genres_edit.php">ДОБАВИТЬ ЖАНР</a>
	</div>

	<form class="flex-box" action="insert_book.php" method="post">
		<h1>Добавить книгу в БД : </h1>
		<div class="item">
			<h1>Название книги</h1>
			<input type="text" name="B_TITLE">
		</div>

		<div class="item">
			<h1>Дата издания</h1>
			<input type="date" name="B_DATE">			
		</div>

		<div class="item">
			<h1>Автор книги</h1>
			<select name="B_AUTHORS">
				<?php
					include 'connect.php';

					// Формируем запрос для получения данных из таблицы "Авторы"
					$sql_select = "SELECT `A_ID`, `A_FIO` FROM `authors`";
					
					$result_authors = mysqli_query($link, $sql_select);

					while ($row_authors = mysqli_fetch_array($result_authors)) 
					{
						echo "<option value='".$row_authors['A_ID']."'>".$row_authors['A_FIO']."</option>";
					}
				?>
			</select>
		</div>

		<div class="item">
			<h1>Жанр книги</h1>
			<select name="B_GENRES">
				<?php
					include 'connect.php';

					$sql_select = "SELECT `G_ID`, `G_NAME` FROM `genres`";
					$result_genres = mysqli_query($link, $sql_select);

					while ($row_genres = mysqli_fetch_array($result_genres))
					{
						echo "<option value='".$row_genres['G_ID']."'>".$row_genres['G_NAME']."</option>";
					}
				?>
			</select>
		</div>

		<div class="item">
			<h1>Цена(руб.)</h1>
			<input type="" name="B_PRICE">			
		</div>

		<div class="item">
			<h1>Количество книг</h1>
			<input type="text" name="B_NUMBERS">			
		</div>

		<input type="submit" name="send" value="Добавить">
		<input type="reset" value="Очистить форму">
	</form>
</body>
</html>