<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Добавить Автора</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
</head>
<body>
	<div class="menu">
		<a class="button" href="table-authors.php">НАЗАД</a>
		<a class="button" href="menu_table.php">ГЛАВНОЕ МЕНЮ</a>
	</div>

	<form class="flex-box" action="insert_authors.php" method="post" name="action">
		<h1>Добавить автора в БД : </h1>
		<div class="item">
			<h1>ФИО Автора</h1>
			<input type="text" name="A_FIO">
		</div>

		<div class="item">
			<h1>Дата рождения</h1>
			<input type="date" name="A_BORN">			
		</div>

		<input type="submit" name="send" value="Добавить">
		<input type="reset" name="clear" value="Очистить форму">	
	</form>
</body>
</html>