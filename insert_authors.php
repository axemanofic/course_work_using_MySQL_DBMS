<?php
	// подключаемся к БД
	include 'connect.php';

	// объявляем переменные соответствующие атрибуту name в поле input
	$A_FIO = htmlentities(trim($_POST['A_FIO']));
	$A_BORN = htmlentities(trim($_POST['A_BORN']));


	// Проверяем, переданы ли значения в переменные
	if(isset($A_FIO) && isset($A_BORN))
	{
		// Формируем запрос
		$sql = "INSERT INTO `authors`(`A_FIO`, `A_BORN`) VALUES ('$A_FIO', '$A_BORN')";
		$result = mysqli_query($link, $sql);

		// Проверка результата на добавление
		if ($result)
		{
			header('Location: table-authors.php');
		}
		else
		{
			echo "Произошла ошибка: " . mysqli_error($link);
		}
	}
	mysqli_close($link);
?>