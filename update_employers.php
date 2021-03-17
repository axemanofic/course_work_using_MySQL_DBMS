<?php
	include 'connect.php';

	$red_id = htmlentities(trim($_GET['red_id']));

	if(isset($_POST['E_FIO']))
	{
		if(isset($red_id))
		{
			$E_FIO = htmlentities(trim($_POST['E_FIO']));
			$E_BORN = htmlentities(trim($_POST['E_BORN']));
			$E_RDATE = htmlentities(trim($_POST['E_RDATE']));
			$E_POST = htmlentities(trim($_POST['E_POST']));
			$E_TEL = htmlentities(trim($_POST['E_TEL']));

			$sql_update = "UPDATE `employers` SET `E_FIO`='$E_FIO',`E_BORN`='$E_BORN',`E_RDATE`='$E_RDATE',`E_POST`='$E_POST',`E_TEL`='$E_TEL' WHERE `employers`.`E_ID`='$red_id'";
			$result_update = mysqli_query($link, $sql_update);
		}

		if (!$result_update) 
		{
			echo "<p>Произошла ошибка: " . mysqli_error($link) . "</p>";
		}
	}

	if(isset($red_id))
	{
		$sql_select = "SELECT `E_FIO`, `E_BORN`, `E_RDATE`, `E_POST`, `E_TEL` FROM `employers` WHERE `E_ID`='$red_id'";
		$result_select = mysqli_query($link, $sql_select);
		$row = mysqli_fetch_array($result_select);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Редактировать сотрудника</title>
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/reset.css">
</head>
<body>
	<a class="button" href="table-employers.php">НАЗАД</a>
	
	<form class="flex-box" method="post">
		<h1>Редактировать данные о сотруднике: </h1>
		<div class="item">
			<h1>ФИО сотрудника</h1>
			<input type="text" name="E_FIO" value="<?= isset($red_id) ? $row['E_FIO'] : ''; ?>">
		</div>

		<div class="item">
			<h1>Дата рождения</h1>
			<input type="date" name="E_BORN" value="<?= isset($red_id) ? $row['E_BORN'] : ''; ?>">			
		</div>

		<div class="item">
			<h1>Дата принятия на работу</h1>
			<input type="date" name="E_RDATE" value="<?= isset($red_id) ? $row['E_RDATE'] : ''; ?>">			
		</div>

		<div class="item">
			<h1>Должность</h1>
			<select name="E_POST">
				<?php
					include 'connect.php';

					$select1 = "SELECT `LP_ID`, `LP_POST` FROM `list of post` WHERE `list of post`.`LP_ID` = ( SELECT `E_POST` FROM `employers` WHERE `employers`.`E_ID` = '$red_id')";
					$result1 = mysqli_query($link, $select1);

					while ($row1 = mysqli_fetch_array($result1))
					{
						echo "<option value='".$row1['LP_ID']."'>".$row1['LP_POST']."</option>";
						$buffer = $row1['LP_ID'];
					}

					$select2 = "SELECT `LP_ID`, `LP_POST` FROM `list of post`";
					$result2 = mysqli_query($link, $select2);

					while ($row2 = mysqli_fetch_array($result2)) 
					{
						if($buffer != $row2['LP_ID'])
						{
							echo "<option value='".$row2['LP_ID']."'>".$row2['LP_POST']."</option>";
						}
					}
				?>
			</select>			
		</div>

		<div class="item">
			<h1>Телефон</h1>
			<input type="text" name="E_TEL" value="<?= isset($red_id) ? $row['E_TEL'] : ''; ?>">	
		</div>

		<input type="submit" name="send" value="Сохранить">
		<input type="reset" value="Очистить форму">
	</form>	
</body>
</html>