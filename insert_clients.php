<?php
	include 'connect.php';

	$RC_FIO = htmlentities(trim($_POST['RC_FIO']));
	$RC_TEL = htmlentities(trim($_POST['RC_TEL']));

	if (isset($RC_FIO) && isset($RC_TEL))
	{
		$sql = "INSERT INTO `regular clients`(`RC_FIO`, `RC_TEL`) VALUES ('$RC_FIO', '$RC_TEL')";
		$result = mysqli_query($link, $sql);

		if($result)
		{
			header('Location: table-clients.php');
		}
		else
		{
			echo "Произошла ошибка: " . mysqli_error($link);
		}
	}
	mysqli_close($link);
?>