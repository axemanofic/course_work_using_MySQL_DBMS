<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Представление</title>
	<link rel="stylesheet" href="css/index.css">
</head>
<body>
	<a class="button" href="menu_table.php">НАЗАД</a>
	<table class="table">
		<tr>
			<td>ФИО клиента</td>
			<td>Название книги</td>
			<td>ФИО Автора</td>
			<td>Жанр</td>
		</tr>
		<?php
			include 'connect.php';
			$sql_select = "SELECT `ФИО клиента`, `Название книги`, `ФИО автора`, `Жанр` FROM `favorite_books`";
			$result = mysqli_query($link, $sql_select);
			while ($row = mysqli_fetch_array($result)) 
			{
				echo '<tr>'.
				"<td>{$row['ФИО клиента']}</td>".
				"<td>{$row['Название книги']}</td>".
				"<td>{$row['ФИО автора']}</td>".
				"<td>{$row['Жанр']}</td>".
				'</tr>';				
			}
		?>
	</table>
</body>
</html>