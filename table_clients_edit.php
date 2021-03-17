<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Добавить Клиента</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
</head>
<body>
	<div class="menu">
		<a class="button" href="table-clients.php">НАЗАД</a>
		<a class="button" href="menu_table.php">ГЛАВНОЕ МЕНЮ</a>
	</div>

	<form class="flex-box" action="insert_clients.php" method="post">
		<h1>Добавить клиента в БД : </h1>
		<div class="item">
			<h1>ФИО клиента</h1>
			<input type="text" name="RC_FIO">
		</div>

		<div class="item">
			<h1>Номер телефона</h1>
			<input type="text" name="RC_TEL">			
		</div>

		<input type="submit" name="send" value="Добавить">
		<input type="reset" value="Очистить форму">
	</form>
</body>
</html>