<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Добавить покупку</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
</head>
<body>
	<div class="menu">
		<a class="button" href="table-purchases.php">НАЗАД</a>
		<a class="button" href="menu_table.php">ГЛАВНОЕ МЕНЮ</a>
		<a class="button" href="table_clients_edit.php">ДОБАВИТЬ КЛИЕНТА</a>
	</div>
	
	<form class="flex-box" action="insert_purchases.php" method="post">
		<h1>Добавить покупку в БД : </h1>
		<div class="item">
			<h1>ФИО Клиента</h1>
			<select name="P_CLIENT">
				<?php
					include 'connect.php';

					$sql_client = "SELECT `RC_ID`, `RC_FIO` FROM `regular clients`";
					$result_client = mysqli_query($link, $sql_client);

					while ($row_client = mysqli_fetch_array($result_client))
					{
						echo "<option value='".$row_client['RC_ID']."'>".$row_client['RC_FIO']."</option>";
					}
				?>
			</select>
		</div>

		<div class="item">
			<h1>ФИО Сотрудника</h1>
			<select name="P_EMPLOY">
				<?php
					include 'connect.php';

					$sql_employ = "SELECT `E_ID`, `E_FIO` FROM `employers` WHERE `E_POST` = 4";
					$result_employ = mysqli_query($link, $sql_employ);

					while ($row_employ = mysqli_fetch_array($result_employ))
					{
						echo "<option value='".$row_employ['E_ID']."'>".$row_employ['E_FIO']."</option>";
					}
				?>
			</select>		
		</div>

		<div class="item">
			<h1>Название Книги</h1>
			<select name="P_BOOKS">
				<?php
					include 'connect.php';

					$sql_book = "SELECT `B_ID`, `B_TITLE` FROM `books`";
					$result_book = mysqli_query($link, $sql_book);

					while ($row_book = mysqli_fetch_array($result_book))
					{
						echo "<option value='".$row_book['B_ID']."'>".$row_book['B_TITLE']."</option>";
					}
				?>
			</select>
		</div>

		<div class="item">
			<h1>Количество купленных книг</h1>
			<input type="text" name="P_NUMBERS">			
		</div>

		<input type="submit" name="send" value="Добавить">
		<input type="reset" value="Очистить форму">
	</form>
</body>
</html>