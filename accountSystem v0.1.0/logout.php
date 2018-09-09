<?php
	session_start();
	if(isset($_SESSION['userName']))
	{
		session_unset();
		session_destroy();
	}
	header("location:homepage.php");//跳转回去

?>