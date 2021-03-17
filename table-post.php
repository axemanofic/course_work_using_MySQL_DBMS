<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Таблица "Должности"</title>
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
			$sql_delete = "DELETE FROM `list of post` WHERE `LP_ID` = '$del_id'";
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
			<a class="button" href="table-post.php?page=0">Показать всю таблицу</a>
			<a class="button" href="table-post.php?page=1">Показать пагинацию</a>
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
					Код должности
					<a href="table-post.php?sort=id_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-post.php?sort=id_desc">
						<img src="img/sort_desc.png" alt="">
					</a>
				</td>
				<td>
					Название должности
					<a href="table-post.php?sort=name_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-post.php?sort=name_desc">
						<img src="img/sort_desc.png" alt="">
					</a>
				</td>
				<td>
					Заработная плата(руб.)
					<a href="table-post.php?sort=wage_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-post.php?sort=wage_desc">
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
					$sort_sql = 'ORDER BY LP_ID ASC';
					break;
				case 'id_desc':
					$sort_sql = 'ORDER BY LP_ID DESC';
					break;
				case 'name_asc':
					$sort_sql = 'ORDER BY LP_POST ASC';
					break;
				case 'name_desc':
					$sort_sql = 'ORDER BY LP_POST DESC';
					break;
				case 'wage_asc':
					$sort_sql = 'ORDER BY LP_WAGE ASC';
					break;
				case 'wage_desc':
					$sort_sql = 'ORDER BY LP_WAGE DESC';
				default:
					break;
			}
			if(empty($poisk))
			{
				if($_GET['page'] >= 1)
				{
					$sql_search = "SELECT LP_ID, LP_POST, LP_WAGE FROM `list of post` $sort_sql LIMIT $art, $kol";
					$res = mysqli_query($link, $sql_search);
					while ($row = mysqli_fetch_array($res)) 
					{	
						echo '<tr>' .
						"<td>{$row['LP_ID']}</td>" .
						"<td>{$row['LP_POST']}</td>" .
						"<td>{$row['LP_WAGE']}</td>" .
						"<td><a href='?del_id={$row['LP_ID']}'>Удалить</a></td>" .
						"<td><a href='update_post.php?red_id={$row['LP_ID']}'>Изменить</a></td>" .
						'</tr>';
					}
					echo '</table>';
					// формируем пагинацию
					for ($i = 1; $i <= $str_pag; $i++)
					{
						echo  "<a class='button' href=table-post.php?page=$i>$i</a>"; 
					}
					echo "<br>";
				}
				else
				{
					$sql_search = "SELECT LP_ID, LP_POST, LP_WAGE FROM `list of post` $sort_sql";
					$res = mysqli_query($link, $sql_search);
					while ($row = mysqli_fetch_array($res)) 
					{	
						echo '<tr>' .
						"<td>{$row['LP_ID']}</td>" .
						"<td>{$row['LP_POST']}</td>" .
						"<td>{$row['LP_WAGE']}</td>" .
						"<td><a href='?del_id={$row['LP_ID']}'>Удалить</a></td>" .
						"<td><a href='update_post.php?red_id={$row['LP_ID']}'>Изменить</a></td>" .
						'</tr>';
					}
					echo '</table>';					
				}		
			}
			else
			{
				$sql_search = "SELECT LP_ID, LP_POST, LP_WAGE FROM `list of post` WHERE `list of post`.`LP_ID` LIKE '%$poisk%' OR `list of post`.`LP_POST` LIKE '%$poisk%' OR `list of post`.`LP_WAGE` LIKE '%$poisk%' ORDER BY `LP_ID`";
				$res = mysqli_query($link, $sql_search);

				while ($row = mysqli_fetch_array($res)) 
				{	
					echo '<tr>' .
					"<td>{$row['LP_ID']}</td>" .
					"<td>{$row['LP_POST']}</td>" .
					"<td>{$row['LP_WAGE']}</td>" .
					"<td><a href='?del_id={$row['LP_ID']}'>Удалить</a></td>" .
					"<td><a href='update_post.php?red_id={$row['LP_ID']}'>Изменить</a></td>" .
					'</tr>';
				}
				echo '</table>';	
			}
		?>

		<a class="button" href="table_post_edit.php">Добавить должность</a>
	</div>
</body>
</html>