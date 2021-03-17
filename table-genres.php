<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Таблица "Жанры"</title>
	<link rel="stylesheet" href="css/index.css">
</head>
<body>
	<?php
		include('connect.php');	
		// Пагинация

		// Определение текущей старницы
		if (isset($_GET['page']))
		{
			$page = $_GET['page']; 
		}
		else 
		{
			$page = 1;
		}

		$kol = 3;  //количество записей для вывода
		$art = ($page * $kol) - $kol;

		// Определяем все количество записей в таблице
		$res = mysqli_query($link, "SELECT COUNT(*) FROM `genres`");
		$row = mysqli_fetch_row($res);
		$total = $row[0]; // всего записей
		// Количество страниц для пагинации
		$str_pag = ceil($total / $kol);

		// Удаление

		$del_id = htmlentities(trim($_GET['del_id']));

		if (isset($del_id)) {
			$sql_delete = "DELETE FROM `genres` WHERE `G_ID` = '$del_id'";
			$result_delete = mysqli_query($link, $sql_delete);

			if(!$result_delete)
			{
				echo '<p>Произошла ошибка: '.mysqli_error($link).'</p>';
			}
		}
	?>
	<div class="menu">
		<a class="button item-back" href="menu_table.php">НАЗАД</a>
		<div class="item-page">
			<a class="button" href="table-genres.php?page=0">Показать всю таблицу</a>
			<a class="button" href="table-genres.php?page=1">Показать пагинацию</a>
		</div>
	</div>

	<div class="box">
		<form class="item-search" method="post">
			<input type="text" name="poisk" value="<?=$_POST['poisk'] ?>">
			<input type="submit" name="submit" value="ПОИСК">
		</form>
		<table class="table">
			<tr>
				<td>
					Код жанра
					<a href="table-genres.php?sort=id_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-genres.php?sort=id_desc">
						<img src="img/sort_desc.png" alt="">
					</a>	
				</td>
				<td>
					Название жанра
					<a href="table-genres.php?sort=name_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-genres.php?sort=name_desc">
						<img src="img/sort_desc.png" alt="">
					</a>	
				</td>
				<td colspan="2">Функции</td>
				</tr>
		<!-- Поиск -->
		<?php
			$sort = $_GET['sort'];
			$poisk = htmlentities(trim($_POST['poisk']));
			switch ($sort) 
			{
				case 'id_asc':
					$sort_sql = 'ORDER BY G_ID ASC';
					break;
				case 'id_desc':
					$sort_sql = 'ORDER BY G_ID DESC';
					break;
				case 'name_asc':
					$sort_sql = 'ORDER BY G_NAME ASC';
					break;
				case 'name_desc':
					$sort_sql = 'ORDER BY G_NAME DESC';
					break;				
				default:
					break;
			}
			if(empty($poisk))
			{
				if($_GET['page'] >= 1)
				{
					$sql_search = "SELECT G_ID, G_NAME FROM `genres` $sort_sql LIMIT $art, $kol";
					$res = mysqli_query($link, $sql_search);
					while ($row = mysqli_fetch_array($res)) 
					{	
						echo '<tr>' .
						"<td>{$row['G_ID']}</td>" .
						"<td>{$row['G_NAME']}</td>" .
						"<td><a href='?del_id={$row['G_ID']}'>Удалить</a></td>".
						"<td><a href='update_genres.php?red_id={$row['G_ID']}'>Изменить</a></td>".
						'</tr>';
					}
					echo '</table>';
					// формируем пагинацию
					for ($i = 1; $i <= $str_pag; $i++)
					{
						echo  "<a class='button' href=table-genres.php?page=$i>$i</a>"; 
					}
					echo "<br>";
				}
				else
				{
					$sql_search = "SELECT G_ID, G_NAME FROM `genres` $sort_sql";
					$res = mysqli_query($link, $sql_search);
					while ($row = mysqli_fetch_array($res)) 
					{	
						echo '<tr>' .
						"<td>{$row['G_ID']}</td>" .
						"<td>{$row['G_NAME']}</td>" .
						"<td><a href='?del_id={$row['G_ID']}'>Удалить</a></td>".
						"<td><a href='update_genres.php?red_id={$row['G_ID']}'>Изменить</a></td>".
						'</tr>';
					}
					echo '</table>';					
				}	
			}
			else
			{
				$sql_search = "SELECT G_ID, G_NAME FROM `genres` WHERE `genres`.`G_ID` LIKE '%$poisk%' OR `genres`.`G_NAME` LIKE '%$poisk%' ORDER BY `genres`.`G_ID`";
				$res = mysqli_query($link, $sql_search);
				while ($row = mysqli_fetch_array($res)) 
				{	
					echo '<tr>' .
					"<td>{$row['G_ID']}</td>" .
					"<td>{$row['G_NAME']}</td>" .
					"<td><a href='?del_id={$row['G_ID']}'>Удалить</a></td>".
					"<td><a href='update_genres.php?red_id={$row['G_ID']}'>Изменить</a></td>".
					'</tr>';
				}
				echo '</table>';
			}
		?>
		<a class="button" href="table_genres_edit.php">Добавить жанр</a>
	</div>
</body>
</html>