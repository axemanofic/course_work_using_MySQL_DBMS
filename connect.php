<?php
	$host = 'localhost';
	$user = 'axeman';
	$password = 'axeman32rus';
	$db = 'book_shop';

	$link = mysqli_connect($host, $user, $password, $db);

	if(!$link)
	{
		echo "Ошибка: Невозможно установить соединение с БД book_shop";
		echo '<br>';
		echo "Код ошибки errno: " . mysqli_connect_errno();
		echo '<br>';
		echo "Текст ошибки error: " . mysqli_connect_error();
		exit;
	}
?>