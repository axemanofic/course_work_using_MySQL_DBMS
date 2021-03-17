<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Процедуры/Функции</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
</head>
<body>
	<?php
		include 'connect.php';

		if(isset($_GET['page']))
		{
			$page = $_GET['page'];
		}
		else
		{
			$page = 1;
		}
	?>
	<div class="menu">
		<a class="button item-back" href="menu_table.php">НАЗАД</a>
		<div class="item-page">
			<a class="button" href="procedureORfunction.php?page=1">Процедура</a>
			<a class="button" href="procedureORfunction.php?page=2">Функция</a>
		</div>
	</div>

	<?php
		if($page == 1)
		{
			echo
			'<form class="flex-box" action="procedureORfunction.php?page=1" method="post">'.
			'<h1>Процедура НДС</h1>'.
			'<div class="item">'.
			'<h1>Название книги</h1>'.
			'<input type="" name="book">'.			
			'</div>'.
			'<div class="item">'.
			'<h1>НДС(%)</h1>'.
			'<input type="text" name="nds">'.	
			'</div>'.
			'<input type="submit" name="send" value="Отправить">'.
			'<input type="reset" value="Очистить форму">';
			if(!empty($_POST['book']) && !empty($_POST['nds']))
			{
				$book = $_POST['book'];
				$nds = $_POST['nds'];
				$call = "CALL nds('$book', '$nds', @p2)";
				$call_q = mysqli_query($link, $call);
				if($call_q == false)
				{
					echo "Ошибка call_q";
				}
				$select = "SELECT @p2 AS 'НДС'";
				$select_q = mysqli_query($link, $select);
				if(!$select_q)
				{
					echo "Ошибка select_q";
				}
				echo "<br>";
				$res = mysqli_fetch_assoc($select_q);
				echo '<h1 class="button">Результат выполнения процедуры:'.$res['НДС'].'</h1>'.
				'</form>';
			}
		}
		else if($page == 2)
		{
			echo
			'<form class="flex-box" action="procedureORfunction.php?page=2" method="post">'.
			'<h1>Функция нахождения автора по названию книги</h1>'.
			'<div class="item">'.
			'<h1>Название книги</h1>'.
			'<input type="" name="title">'.			
			'</div>'.
			'<input type="submit" name="send" value="Отправить">'.
			'<input type="reset" value="Очистить форму">';
			if(!empty($_POST['title']))
			{
				$title = $_POST['title'];

				$sql_func = "SELECT `name`('$title') AS 'ФИО Автора'";
				$sql_func_q = mysqli_query($link, $sql_func);
				if($sql_func_q == false)
				{
					echo "ошибка sql_func_q"; 
				}
				echo '<br>'; 
				$res = mysqli_fetch_assoc($sql_func_q); 
				echo '<h1 class="button">Результат выполнения функции:'.$res['ФИО Автора'].'</h1>'.
				'</form>';
			}
		}
		mysqli_close($link);
	?>

</body>
</html>