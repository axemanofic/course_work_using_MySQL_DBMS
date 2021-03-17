<?php
	include 'connect.php';

	$LP_POST = htmlentities(trim($_POST['LP_POST']));
	$LP_WAGE = htmlentities(trim($_POST['LP_WAGE']));

	if(isset($LP_POST) && isset($LP_WAGE))
	{
		$sql = "INSERT INTO `list of post`(`LP_POST`, `LP_WAGE`) VALUES ('$LP_POST', '$LP_WAGE')";
		$result = mysqli_query($link, $sql);

		if($result)
		{
			header('Location: table-post.php');
		}
		else
		{
			echo "Произошла ошибка: " . mysqli_error($link);
		}
	}
	mysqli_close($link);
?>