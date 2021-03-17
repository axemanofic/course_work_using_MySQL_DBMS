<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Добавить Сотрудника</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
</head>
<body>
	<div class="menu">
		<a class="button" href="table-employers.php">НАЗАД</a>
		<a class="button" href="menu_table.php">ГЛАВНОЕ МЕНЮ</a>
		<a class="button" href="table_post_edit.php">ДОБАВИТЬ ДОЛЖНОСТЬ</a>
	</div>
	
	<form class="flex-box" action="insert_employers.php" method="post">
		<h1>Добавить сотрудника в БД : </h1>
		<div class="item">
			<h1>ФИО сотрудника</h1>
			<input type="text" name="E_FIO">
		</div>

		<div class="item">
			<h1>Дата рождения</h1>
			<input type="date" name="E_BORN">			
		</div>

		<div class="item">
			<h1>Дата принятия на работу</h1>
			<input type="date" name="E_RDATE">			
		</div>

		<div class="item">
			<h1>Должность</h1>
			<select name="E_POST">
				<?php
					include 'connect.php';

					$sql_select = "SELECT `LP_ID`, `LP_POST` FROM `list of post`";
					$result = mysqli_query($link, $sql_select);

					while ($row = mysqli_fetch_array($result))
					{
						echo "<option value='".$row['LP_ID']."'>".$row['LP_POST']."</option>";
					}
				?>
			</select>			
		</div>

		<div class="item">
			<h1>Телефон</h1>
			<input type="text" name="E_TEL">	
		</div>

		<input type="submit" name="send" value="Добавить">
		<input type="reset" value="Очистить форму">
	</form>
</body>
</html>