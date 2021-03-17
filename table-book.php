<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Таблица "Книги"</title>
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
		$res = mysqli_query($link, "SELECT COUNT(*) FROM `books`");
		$row = mysqli_fetch_row($res);
		$total = $row[0]; // всего записей
		// Количество страниц для пагинации
		$str_pag = ceil($total / $kol);

		// Удаление 

		$del_id = htmlentities(trim($_GET['del_id']));

		if (isset($del_id)) {
			$sql_delete = "DELETE FROM `books` WHERE `B_ID` = '$del_id'";
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
			<a class="button" href="table-book.php?page=0">Показать всю таблицу</a>
			<a class="button" href="table-book.php?page=1">Показать пагинацию</a>
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
					Код книги
					<a href="table-book.php?sort=id_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-book.php?sort=id_desc">
						<img src="img/sort_desc.png" alt="">
					</a>					
				</td>
				<td>
					Название книги
					<a href="table-book.php?sort=title_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-book.php?sort=title_desc">
						<img src="img/sort_desc.png" alt="">
					</a>	
				</td>
				<td>Дата издания</td>
				<td>ФИО автора</td>
				<td>Название жанра</td>
				<td>
					Цена(руб.)
					<a href="table-book.php?sort=price_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-book.php?sort=price_desc">
						<img src="img/sort_desc.png" alt="">
					</a>
				</td>
				<td>
					Количество книг
					<a href="table-book.php?sort=num_asc">
						<img src="img/sort_asc.png" alt="">
					</a>
					<a href="table-book.php?sort=num_desc">
						<img src="img/sort_desc.png" alt="">
					</a>
				</td>
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
					$sort_sql = 'ORDER BY B_ID ASC';
					break;
				case 'id_desc':
					$sort_sql = 'ORDER BY B_ID DESC';
					break;
				case 'title_asc':
					$sort_sql = 'ORDER BY B_TITLE ASC';
					break;
				case 'title_desc':
					$sort_sql = 'ORDER BY B_TITLE DESC';
					break;
				case 'num_asc':
					$sort_sql = 'ORDER BY B_NUMBERS ASC';
					break;
				case 'num_desc':
					$sort_sql = 'ORDER BY B_NUMBERS DESC';
					break;
				case 'price_asc':
					$sort_sql = 'ORDER BY B_PRICE ASC';
					break;
				case 'price_desc':
					$sort_sql = 'ORDER BY B_PRICE DESC';
					break;				
				default:
					break;
			}
			if(empty($poisk))
			{
				if($_GET['page'] >= 1)
				{
					$sql_search = "SELECT B_ID, B_TITLE, B_DATE, A_FIO, G_NAME, B_PRICE, B_NUMBERS FROM `books`, `authors`, `genres` WHERE (books.B_AUTHORS=authors.A_ID AND books.B_GENRES=genres.G_ID) $sort_sql LIMIT $art, $kol";
					$res = mysqli_query($link, $sql_search);
					while ($row = mysqli_fetch_array($res)) 
					{	
						echo '<tr>' .
						"<td>{$row['B_ID']}</td>" .
						"<td>{$row['B_TITLE']}</td>" .
						"<td>{$row['B_DATE']}</td>" .
						"<td>{$row['A_FIO']}</td>" .
						"<td>{$row['G_NAME']}</td>" .
						"<td>{$row['B_PRICE']}</td>" .
						"<td>{$row['B_NUMBERS']}</td>" .
						"<td><a href='?del_id={$row['B_ID']}'>Удалить</a></td>".
						"<td><a href='update_books.php?red_id={$row['B_ID']}'>Изменить</a></td>".
						'</tr>';
					}
					echo '</table>';
					// формируем пагинацию
					for ($i = 1; $i <= $str_pag; $i++)
					{
						echo  "<a class='button' href=table-book.php?page=$i>$i</a>"; 
					}
					echo "<br>";
				}
				else
				{
					$sql_search = "SELECT B_ID, B_TITLE, B_DATE, A_FIO, G_NAME, B_PRICE, B_NUMBERS FROM `books`, `authors`, `genres` WHERE (books.B_AUTHORS=authors.A_ID AND books.B_GENRES=genres.G_ID) $sort_sql";
					$res = mysqli_query($link, $sql_search);
					while ($row = mysqli_fetch_array($res)) 
					{	
						echo '<tr>' .
						"<td>{$row['B_ID']}</td>" .
						"<td>{$row['B_TITLE']}</td>" .
						"<td>{$row['B_DATE']}</td>" .
						"<td>{$row['A_FIO']}</td>" .
						"<td>{$row['G_NAME']}</td>" .
						"<td>{$row['B_PRICE']}</td>" .
						"<td>{$row['B_NUMBERS']}</td>" .
						"<td><a href='?del_id={$row['B_ID']}'>Удалить</a></td>".
						"<td><a href='update_books.php?red_id={$row['B_ID']}'>Изменить</a></td>".
						'</tr>';
					}
					echo '</table>';					
				}		
			}
			else
			{
				$sql_search = "SELECT B_ID, B_TITLE, B_DATE, A_FIO, G_NAME, B_PRICE, B_NUMBERS FROM `books`, `authors`, `genres` WHERE (books.B_AUTHORS=authors.A_ID AND books.B_GENRES=genres.G_ID) AND (`books`.`B_ID` LIKE '%$poisk%' OR `books`.`B_TITLE` LIKE '%$poisk%' OR `books`.`B_DATE` LIKE '%$poisk%' OR `authors`.`A_FIO` LIKE '%$poisk%' OR `genres`.`G_NAME` LIKE '%$poisk%' OR `books`.`B_PRICE` LIKE '%$poisk%' OR `books`.`B_NUMBERS` LIKE '%$poisk%') ORDER BY `books`.`B_ID`";
				$res = mysqli_query($link, $sql_search);
				while ($row = mysqli_fetch_array($res)) 
				{	
					echo '<tr>' .
					"<td>{$row['B_ID']}</td>" .
					"<td>{$row['B_TITLE']}</td>" .
					"<td>{$row['B_DATE']}</td>" .
					"<td>{$row['A_FIO']}</td>" .
					"<td>{$row['G_NAME']}</td>" .
					"<td>{$row['B_PRICE']}</td>" .
					"<td>{$row['B_NUMBERS']}</td>" .
					"<td><a href='?del_id={$row['B_ID']}'>Удалить</a></td>".
					"<td><a href='update_books.php?red_id={$row['B_ID']}'>Изменить</a></td>".
					'</tr>';
				}
				echo '</table>';
			}
		?>
		<a class="button" href="table_book_edit.php">Добавить книгу</a>
	</div>
</body>
</html>