<?php
	include 'connect.php';

	$red_id = htmlentities(trim($_GET['red_id']));

	if(isset($_POST['P_CLIENT']))
	{
		if(isset($red_id))
		{
			$P_CLIENT = htmlentities(trim($_POST['P_CLIENT']));
			$P_EMPLOY = htmlentities(trim($_POST['P_EMPLOY']));
			$P_BOOKS = htmlentities(trim($_POST['P_BOOKS']));
			$P_NUMBERS = htmlentities(trim($_POST['P_NUMBERS']));

			if (isset($P_CLIENT) && isset($P_EMPLOY) && isset($P_BOOKS) && isset($P_NUMBERS)) {

				$sql_condition = "SELECT `B_NUMBERS` FROM `books` WHERE `books`.`B_ID` = '$P_BOOKS'";
				$result_condition = mysqli_query($link, $sql_condition);
				$numbers_book = mysqli_fetch_array($result_condition);

				$sql_update = "UPDATE `purchases` SET `P_CLIENT`='$P_CLIENT',`P_EMPLOY`='$P_EMPLOY',`P_BOOKS`='$P_BOOKS',`P_NUMBERS`='$P_NUMBERS' WHERE `purchases`.`P_ID`='$red_id'";
				$result_update = mysqli_query($link, $sql_update);

				if(!$result_update)
				{
					echo "Произошла ошибка: " . mysqli_error($link);
				}
				else
				{
					header('Location: table-purchases.php');
				}
			}
		}
	}

	if(isset($red_id))
	{
		$sql_select = "SELECT `P_CLIENT`, `P_EMPLOY`, `P_BOOKS`, `P_NUMBERS` FROM `purchases` WHERE `P_ID`='$red_id'";
		$result_select = mysqli_query($link, $sql_select);
		$row = mysqli_fetch_array($result_select);
	}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Редактировать покупку</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
</head>
<body>
	<div class="menu">
		<a class="button" href="table-purchases.php">НАЗАД</a>
	</div>
	
	<form class="flex-box" method="post">
		<h1>Изменить данные о покупке : </h1>
		<div class="item">
			<h1>ФИО Клиента</h1>
			<select name="P_CLIENT">
				<?php
					include 'connect.php';

					$sql_client1 = "SELECT `RC_ID`, `RC_FIO` FROM `regular clients` WHERE `regular clients`.`RC_ID`=(SELECT `P_CLIENT` FROM `purchases` WHERE `purchases`.`P_ID` = '$red_id')";
					$result_client1 = mysqli_query($link, $sql_client1);
					while ($row_client1 = mysqli_fetch_array($result_client1))
					{
						echo "<option value='".$row_client1['RC_ID']."'>".$row_client1['RC_FIO']."</option>";
						$buffer = $row_client1['RC_ID'];
					}

					$sql_client2 = "SELECT `RC_ID`, `RC_FIO` FROM `regular clients`";
					$result_client2 = mysqli_query($link, $sql_client2);
					while ($row_client2 = mysqli_fetch_array($result_client2))
					{
						if($buffer != $row_client2['RC_ID'])
						{
							echo "<option value='".$row_client2['RC_ID']."'>".$row_client2['RC_FIO']."</option>";
						}
					}					
				?>
			</select>
		</div>

		<div class="item">
			<h1>ФИО Сотрудника</h1>
			<select name="P_EMPLOY">
				<?php
					include 'connect.php';

					$sql_employ1 = "SELECT `E_ID`, `E_FIO` FROM `employers` WHERE `employers`.`E_ID` = (SELECT `purchases`.`P_EMPLOY` FROM `purchases` WHERE `purchases`.`P_ID` = '$red_id')";
					$result_employ1 = mysqli_query($link, $sql_employ1);
					while ($row_employ1 = mysqli_fetch_array($result_employ1))
					{
						echo "<option value='".$row_employ1['E_ID']."'>".$row_employ1['E_FIO']."</option>";
						$buffer = $row_employ1['E_ID'];
					}

					$sql_employ2 = "SELECT `E_ID`, `E_FIO` FROM `employers` WHERE `E_POST` = 4";
					$result_employ2 = mysqli_query($link, $sql_employ2);
					while ($row_employ2 = mysqli_fetch_array($result_employ2))
					{
						if($buffer != $row_employ2['E_ID'])
						{
							echo "<option value='".$row_employ2['E_ID']."'>".$row_employ2['E_FIO']."</option>";
						}
					}					
				?>
			</select>		
		</div>

		<div class="item">
			<h1>Название Книги</h1>
			<select name="P_BOOKS">
				<?php
					include 'connect.php';

					$sql_book1 = "SELECT `books`.`B_ID`, `books`.`B_TITLE` FROM `books` WHERE `books`.`B_ID` = (SELECT `purchases`.`P_BOOKS` FROM `purchases` WHERE `purchases`.`P_ID` = '$red_id')";
					$result_book1 = mysqli_query($link, $sql_book1);
					while ($row_book1 = mysqli_fetch_array($result_book1))
					{
						echo "<option value='".$row_book1['B_ID']."'>".$row_book1['B_TITLE']."</option>";
						$buffer = $row_book1['B_ID'];
					}

					$sql_book2 = "SELECT `B_ID`, `B_TITLE` FROM `books`";
					$result_book2 = mysqli_query($link, $sql_book2);
					while ($row_book2 = mysqli_fetch_array($result_book2))
					{
						if($buffer != $row_book2['B_ID'])
						{
							echo "<option value='".$row_book2['B_ID']."'>".$row_book2['B_TITLE']."</option>";
						}
					}					
				?>
			</select>
		</div>

		<div class="item">
			<h1>Количество купленных книг</h1>
			<input type="text" name="P_NUMBERS" value="<?= isset($red_id) ? $row['P_NUMBERS'] : '' ?>">			
		</div>

		<input type="submit" name="send" value="Изменить">
		<input type="reset" value="Очистить форму">
	</form>
</body>
</html>