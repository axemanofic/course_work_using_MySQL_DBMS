<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Добавить Должность</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
</head>
<body>
	<div class="menu">
		<a class="button" href="table-post.php">НАЗАД</a>
		<a class="button" href="menu_table.php">ГЛАВНОЕ МЕНЮ</a>
	</div>
	
	<form class="flex-box" action="insert_post.php" method="post">
		<h1>Добавить должность в БД : </h1>
		<div class="item">
			<h1>Название должности</h1>
			<input type="text" name="LP_POST">
		</div>

		<div class="item">
			<h1>Заработная плата(руб.)</h1>
			<input type="text" name="LP_WAGE">	
		</div>

		<input type="submit" name="send" value="Добавить">
		<input type="reset" value="Очистить форму">
	</form>
</body>
</html>