<?php
	include 'connect.php';

	$E_FIO = htmlentities(trim($_POST['E_FIO']));
	$E_BORN = htmlentities(trim($_POST['E_BORN']));
	$E_RDATE = htmlentities(trim($_POST['E_RDATE']));
	$E_POST = htmlentities(trim($_POST['E_POST']));
	$E_TEL = htmlentities(trim($_POST['E_TEL']));

	if (isset($E_FIO) && isset($E_BORN) && isset($E_RDATE) && isset($E_POST) && isset($E_TEL)) {
		
		$sql = "INSERT INTO `employers`(`E_FIO`, `E_BORN`, `E_RDATE`, `E_POST`, `E_TEL`) VALUES ('$E_FIO', '$E_BORN', '$E_RDATE', '$E_POST', '$E_TEL')";
		$result = mysqli_query($link, $sql);

		if($result)
		{
			header('Location: table-employers.php');
		}
		else
		{
			echo "Произошла ошибка: " . mysqli_error($link);
		}
	}

	mysqli_close($link);
?>