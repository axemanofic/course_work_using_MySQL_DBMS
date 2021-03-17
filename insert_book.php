<?php
	include 'connect.php';

	$B_TITLE = htmlentities(trim($_POST['B_TITLE']));
	$B_DATE = htmlentities(trim($_POST['B_DATE']));
	$B_AUTHORS = htmlentities(trim($_POST['B_AUTHORS']));
	$B_GENRES = htmlentities(trim($_POST['B_GENRES']));
	$B_PRICE = htmlentities(trim($_POST['B_PRICE']));
	$B_NUMBERS = htmlentities(trim($_POST['B_NUMBERS']));

	if(isset($B_TITLE) && isset($B_PRICE) && isset($B_DATE) && isset($B_NUMBERS))
	{
		$sql = "INSERT INTO `books`(`B_TITLE`, `B_DATE`, `B_AUTHORS`, `B_GENRES`, `B_PRICE`, B_NUMBERS) VALUES ('$B_TITLE', '$B_DATE', $B_AUTHORS, '$B_GENRES', '$B_PRICE', '$B_NUMBERS')";
		$result = mysqli_query($link, $sql);

		// Проверка результата на добавление
		if ($result)
		{
			header('Location: table-book.php');
		}
		else
		{
			echo "Произошла ошибка: " . mysqli_error($link);
		}
	}
	mysqli_close($link);
?>