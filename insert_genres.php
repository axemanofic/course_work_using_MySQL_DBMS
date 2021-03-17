<?php
	include 'connect.php';

	$G_NAME = htmlentities(trim($_POST['G_NAME']));

	if(isset($G_NAME))
	{
		$sql = "INSERT INTO `genres`(`G_NAME`) VALUES ('$G_NAME')";
		$result = mysqli_query($link, $sql);

		// Проверка результата на добавление
		if ($result)
		{
			header('Location: table-genres.php');
		}
		else
		{
			echo "Произошла ошибка: " . mysqli_error($link);
		}
	}
	mysqli_close($link);
?>