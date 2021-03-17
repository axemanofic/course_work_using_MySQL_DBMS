<?php
	include 'connect.php';

	$P_CLIENT = htmlentities(trim($_POST['P_CLIENT']));
	$P_EMPLOY = htmlentities(trim($_POST['P_EMPLOY']));
	$P_BOOKS = htmlentities(trim($_POST['P_BOOKS']));
	$P_NUMBERS = htmlentities(trim($_POST['P_NUMBERS']));

	if(empty($P_NUMBERS) || $P_NUMBERS == 0)
	{
		echo "Произошла ошибка: " . mysqli_error($link);
	}

	if (isset($P_CLIENT) && isset($P_EMPLOY) && isset($P_BOOKS) && isset($P_NUMBERS)) {

		$sql_condition = "SELECT `B_NUMBERS` FROM `books` WHERE `books`.`B_ID` = '$P_BOOKS'";
		$result_condition = mysqli_query($link, $sql_condition);
		$numbers_book = mysqli_fetch_array($result_condition);
		
		if($P_NUMBERS <= $numbers_book['B_NUMBERS'] && ($P_NUMBERS >= 0) && !empty($P_NUMBERS) )
		{
			$sql_insert = "INSERT INTO `purchases` (`P_CLIENT`, `P_EMPLOY`, `P_BOOKS`, `P_NUMBERS`) VALUES ('$P_CLIENT', '$P_EMPLOY', '$P_BOOKS', '$P_NUMBERS')";
			$result_insert = mysqli_query($link, $sql_insert);

			if(!$result_insert)
			{
				echo "Произошла ошибка: " . mysqli_error($link);
			}
			else
			{
				header('Location: table-purchases.php');
			}
		}
		else
		{
			echo 'Вы не можете продать кол-во книг '.$P_NUMBERS. 'т.к. на складе таких книг' .$numbers_book['B_NUMBERS'];
		}
	}
	mysqli_close($link);
?>