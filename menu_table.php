<?php
	$exit = $_POST['exit'];
	if (!empty($exit)) 
	{
		unset($_SESSION['login']);
		unset($_SESSION['pass']);
		exit("<html><head><title>Загрузка..</title><meta  http-equiv='Refresh'content='0; URL=index.php'></head></html>");
	}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Главное меню</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
</head>
<body>
	<div class="flex-box-menu">
		<a class="item button" href="table-view.php">
			<h1>Представление</h1>
		</a>
		<a class="item button" href="procedureORfunction.php">
			<h1>Процедура/Функция</h1>
		</a>
	</div>
	<div class="grid_box">
		<a class="item" href="table-book.php">
			<h1>Таблица "Книги"</h1>
		</a>
		<a class="item" href="table-authors.php">
			<h1>Таблица "Авторы"</h1>
		</a>
		<a class="item" href="table-genres.php">
			<h1>Таблица "Жанры"</h1>
		</a>
		<a class="item" href="table-employers.php">
			<h1>Таблица "Сотрудники"</h1>
		</a>
		<a class="item" href="table-post.php">
			<h1>Таблица "Должности"</h1>
		</a>
		<a class="item" href="table-purchases.php">
			<h1>Таблица "Покупки"</h1>
		</a>
		<a class="item active" href="table-clients.php">
			<h1>Таблица "Постоянные клиенты"</h1>
		</a>
		<form method="post">
			<input class="button" type="submit" class="exit" name="exit" value="Выйти">
		</form>
	</div>
</body>
</html>