<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Таблица "Cотрудники"</title>
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
		$res = mysqli_query($link, "SELECT COUNT(*) FROM `employers`");
		$row = mysqli_fetch_row($res);
		$total = $row[0]; // всего записей
		// Количество страниц для пагинации
		$str_pag = ceil($total / $kol);

		// Удаление

		$del_id = htmlentities(trim($_GET['del_id']));

		if (isset($del_id)) {
			$sql_delete = "DELETE FROM `employers` WHERE `E_ID` = '$del_id'";
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
			<a class="button" href="table-employers.php?page=0">Показать всю таблицу</a>
			<a class="button" href="table-employers.php?page=1">Показать пагинацию</a>
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
					Код сотрудника
					<a href="table-employers.php?sort=id_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-employers.php?sort=id_desc">
						<img src="img/sort_desc.png" alt="">
					</a>					
				</td>
				<td>
					ФИО сотрудника
					<a href="table-employers.php?sort=fio_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-employers.php?sort=fio_desc">
						<img src="img/sort_desc.png" alt="">
					</a>
				</td>
				<td>Дата рождения</td>
				<td>
					Дата принятия на работу
					<a href="table-employers.php?sort=date_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-employers.php?sort=date_desc">
						<img src="img/sort_desc.png" alt="">
					</a>
				</td>
				<td>Должность</td>
				<td>Телефон</td>
				<td colspan="2">Функции</td>
			</tr>
		<!-- Поиск -->
		<?php
			include('connect.php');
			$sort = $_GET['sort'];
			$poisk = htmlentities(trim($_POST['poisk']));
			switch ($sort) 
			{
				case 'id_asc':
					$sort_sql = 'ORDER BY E_ID ASC';
					break;
				case 'id_desc':
					$sort_sql = 'ORDER BY E_ID DESC';
					break;
				case 'fio_asc':
					$sort_sql = 'ORDER BY E_FIO ASC';
					break;
				case 'fio_desc':
					$sort_sql = 'ORDER BY E_FIO DESC';
					break;
				case 'date_asc':
					$sort_sql = 'ORDER BY E_RDATE ASC';
					break;
				case 'date_asc':
					$sort_sql = 'ORDER BY E_RDATE DESC';
					break;				
				default:
					break;
			}
			if(empty($poisk))
			{
				if($_GET['page'] >= 1)
				{
					$sql_search = "SELECT E_ID, E_FIO, E_BORN, E_RDATE, LP_POST, E_TEL FROM `employers`, `list of post` WHERE employers.E_POST=`list of post`.`LP_ID` $sort_sql LIMIT $art, $kol";
					$res = mysqli_query($link, $sql_search);

					while ($row = mysqli_fetch_array($res)) 
					{	
						echo '<tr>' .
						"<td>{$row['E_ID']}</td>" .
						"<td>{$row['E_FIO']}</td>" .
						"<td>{$row['E_BORN']}</td>" .
						"<td>{$row['E_RDATE']}</td>" .
						"<td>{$row['LP_POST']}</td>" .
						"<td>{$row['E_TEL']}</td>" .
						"<td><a href='?del_id={$row['E_ID']}'>Удалить</a></td>" .
						"<td><a href='update_employers.php?red_id={$row['E_ID']}'>Изменить</a></td>" .
						'</tr>';
					}
					echo '</table>';
					// формируем пагинацию
					for ($i = 1; $i <= $str_pag; $i++)
					{
						echo  "<a class='button' href=table-employers.php?page=$i>$i</a>"; 
					}
					echo "<br>";
				}
				else
				{
					$sql_search = "SELECT E_ID, E_FIO, E_BORN, E_RDATE, LP_POST, E_TEL FROM `employers`, `list of post` WHERE employers.E_POST=`list of post`.`LP_ID` $sort_sql";
					$res = mysqli_query($link, $sql_search);

					while ($row = mysqli_fetch_array($res)) 
					{	
						echo '<tr>' .
						"<td>{$row['E_ID']}</td>" .
						"<td>{$row['E_FIO']}</td>" .
						"<td>{$row['E_BORN']}</td>" .
						"<td>{$row['E_RDATE']}</td>" .
						"<td>{$row['LP_POST']}</td>" .
						"<td>{$row['E_TEL']}</td>" .
						"<td><a href='?del_id={$row['E_ID']}'>Удалить</a></td>" .
						"<td><a href='update_employers.php?red_id={$row['E_ID']}'>Изменить</a></td>" .
						'</tr>';
					}
					echo '</table>';					
				}
			}
			else
			{
				$sql_search = "SELECT E_ID, E_FIO, E_BORN, E_RDATE, LP_POST, E_TEL FROM `employers`, `list of post` WHERE (employers.E_POST=`list of post`.`LP_ID`) AND (`employers`.`E_ID` LIKE '%$poisk%' OR `employers`.`E_FIO` LIKE '%$poisk%' OR `employers`.`E_BORN` LIKE '%$poisk%' OR `employers`.`E_RDATE` LIKE '%$poisk%' OR `list of post`.`LP_POST` LIKE '%$poisk%' OR `employers`.`E_TEL` LIKE '%$poisk%') ORDER BY E_ID;";
				$res = mysqli_query($link, $sql_search);

				while ($row = mysqli_fetch_array($res)) 
				{	
					echo '<tr>' .
					"<td>{$row['E_ID']}</td>" .
					"<td>{$row['E_FIO']}</td>" .
					"<td>{$row['E_BORN']}</td>" .
					"<td>{$row['E_RDATE']}</td>" .
					"<td>{$row['LP_POST']}</td>" .
					"<td>{$row['E_TEL']}</td>" .
					"<td><a href='?del_id={$row['E_ID']}'>Удалить</a></td>" .
					"<td><a href='update_employers.php?red_id={$row['E_ID']}'>Изменить</a></td>" .
					'</tr>';
				}
				echo '</table>';
			}
		?>
		<a class="button" href="table_employers_edit.php">Добавить сотрудника</a>
	</div>
	
</body>
</html>