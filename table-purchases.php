<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Таблица "Покупки"</title>
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
		$res = mysqli_query($link, "SELECT COUNT(*) FROM `purchases`");
		$row = mysqli_fetch_row($res);
		$total = $row[0]; // всего записей
		// Количество страниц для пагинации
		$str_pag = ceil($total / $kol);

		// Удаление

		$del_id = htmlentities(trim($_GET['del_id']));

		if (isset($del_id)) {
			$sql_delete = "DELETE FROM `purchases` WHERE `P_ID` = '$del_id'";
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
			<a class="button" href="table-purchases.php?page=0">Показать всю таблицу</a>
			<a class="button" href="table-purchases.php?page=1">Показать пагинацию</a>
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
					Код покупки
					<a href="table-purchases.php?sort=id_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-purchases.php?sort=id_desc">
						<img src="img/sort_desc.png" alt="">
					</a>
				</td>
				<td>
					ФИО клиента
					<a href="table-purchases.php?sort=client_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-purchases.php?sort=client_desc">
						<img src="img/sort_desc.png" alt="">
					</a>
				</td>
				<td>
					ФИО сотрудника
					<a href="table-purchases.php?sort=employ_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-purchases.php?sort=employ_desc">
						<img src="img/sort_desc.png" alt="">
					</a>
				</td>
				<td>
					Название книги
					<a href="table-purchases.php?sort=title_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-purchases.php?sort=title_desc">
						<img src="img/sort_desc.png" alt="">
					</a>
				</td>
				<td>
					Количество купленных книг
					<a href="table-purchases.php?sort=num_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-purchases.php?sort=num_desc">
						<img src="img/sort_desc.png" alt="">
					</a>
				</td>
				<td>
					Сумма покупки
					<a href="table-purchases.php?sort=price_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-purchases.php?sort=price_desc">
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
					$sort_sql = 'ORDER BY P_ID ASC';
					break;
				case 'id_desc':
					$sort_sql = 'ORDER BY P_ID DESC';
					break;
				case 'client_asc':
					$sort_sql = 'ORDER BY RC_FIO ASC';
					break;
				case 'client_desc':
					$sort_sql = 'ORDER BY RC_FIO DESC';
					break;
				case 'employ_asc':
					$sort_sql = 'ORDER BY E_FIO ASC';
					break;
				case 'employ_desc':
					$sort_sql = 'ORDER BY E_FIO DESC';
					break;
				case 'title_asc':
					$sort_sql = 'ORDER BY B_TITLE ASC';
					break;
				case 'title_desc':
					$sort_sql = 'ORDER BY B_TITLE DESC';
					break;
				case 'num_asc':
					$sort_sql = 'ORDER BY P_NUMBERS ASC';
					break;
				case 'num_desc':
					$sort_sql = 'ORDER BY P_NUMBERS DESC';
					break;
				case 'price_asc':
					$sort_sql = 'ORDER BY `B_PRICE`*`P_NUMBERS` ASC';
					break;
				case 'price_desc':
					$sort_sql = 'ORDER BY `B_PRICE`*`P_NUMBERS` DESC';
					break;				
				default:
					break;
			}
			if(empty($poisk))
			{
				if($_GET['page'] >= 1)
				{
					$sql_search = "SELECT `P_ID`, `RC_FIO`, `E_FIO`, `B_TITLE`, `P_NUMBERS`, `B_PRICE`*`P_NUMBERS` FROM `purchases` JOIN `regular clients` ON `purchases`.`P_CLIENT` = `regular clients`.`RC_ID` JOIN `employers` ON `purchases`.`P_EMPLOY` = `employers`.`E_ID` JOIN `books` ON `purchases`.`P_BOOKS` = `books`.`B_ID` $sort_sql LIMIT $art, $kol";
					$res = mysqli_query($link, $sql_search);

					while ($row = mysqli_fetch_array($res)) 
					{	
						echo '<tr>' .
						"<td>{$row['P_ID']}</td>" .
						"<td>{$row['RC_FIO']}</td>" .
						"<td>{$row['E_FIO']}</td>" .
						"<td>{$row['B_TITLE']}</td>" .
						"<td>{$row['P_NUMBERS']}</td>" .
						"<td>{$row['`B_PRICE`*`P_NUMBERS`']}</td>" .
						"<td><a href='?del_id={$row['P_ID']}'>Удалить</a></td>" .
						"<td><a href='update_purchases.php?red_id={$row['P_ID']}'>Изменить</a></td>" .
						'</tr>';
					}
					echo '</table>';
					// формируем пагинацию
					for ($i = 1; $i <= $str_pag; $i++)
					{
						echo  "<a class='button' href=table-purchases.php?page=$i>$i</a>"; 
					}
					echo "<br>";
				}
				else
				{
					$sql_search = "SELECT `P_ID`, `RC_FIO`, `E_FIO`, `B_TITLE`, `P_NUMBERS`, `B_PRICE`*`P_NUMBERS` FROM `purchases` JOIN `regular clients` ON `purchases`.`P_CLIENT` = `regular clients`.`RC_ID` JOIN `employers` ON `purchases`.`P_EMPLOY` = `employers`.`E_ID` JOIN `books` ON `purchases`.`P_BOOKS` = `books`.`B_ID` $sort_sql";
					$res = mysqli_query($link, $sql_search);

					while ($row = mysqli_fetch_array($res)) 
					{	
						echo '<tr>' .
						"<td>{$row['P_ID']}</td>" .
						"<td>{$row['RC_FIO']}</td>" .
						"<td>{$row['E_FIO']}</td>" .
						"<td>{$row['B_TITLE']}</td>" .
						"<td>{$row['P_NUMBERS']}</td>" .
						"<td>{$row['`B_PRICE`*`P_NUMBERS`']}</td>" .
						"<td><a href='?del_id={$row['P_ID']}'>Удалить</a></td>" .
						"<td><a href='update_purchases.php?red_id={$row['P_ID']}'>Изменить</a></td>" .
						'</tr>';
					}
					echo '</table>';					
				}	
			}
			else
			{
				$sql_search = "SELECT `P_ID`, `RC_FIO`, `E_FIO`, `B_TITLE`, `P_NUMBERS`, `B_PRICE` * `P_NUMBERS` FROM `purchases` JOIN `regular clients` ON `purchases`.`P_CLIENT` = `regular clients`.`RC_ID` JOIN `employers` ON `purchases`.`P_EMPLOY` = `employers`.`E_ID` JOIN `books` ON `purchases`.`P_BOOKS` = `books`.`B_ID` WHERE `purchases`.`P_ID` LIKE '%$poisk%' OR `regular clients`.`RC_FIO` LIKE '%$poisk%' OR `employers`.`E_FIO` LIKE '%$poisk%' OR `books`.`B_TITLE` LIKE '%$poisk%' OR `purchases`.`P_NUMBERS` LIKE '%$poisk%' ORDER BY `purchases`.`P_ID`";
				$res = mysqli_query($link, $sql_search);
				while ($row = mysqli_fetch_array($res)) 
				{	
					echo '<tr>' .
					"<td>{$row['P_ID']}</td>" .
					"<td>{$row['RC_FIO']}</td>" .
					"<td>{$row['E_FIO']}</td>" .
					"<td>{$row['B_TITLE']}</td>" .
					"<td>{$row['P_NUMBERS']}</td>" .
					"<td>{$row['`B_PRICE`*`P_NUMBERS`']}</td>" .
					"<td><a href='?del_id={$row['P_ID']}'>Удалить</a></td>" .
					"<td><a href='update_purchases.php?red_id={$row['P_ID']}'>Изменить</a></td>" .
					'</tr>';
				}
				echo '</table>';		
			}
		?>
		<a class="button" href="table_purchases_edit.php">Добавить покупку</a>
	</div>
</body>
</html>