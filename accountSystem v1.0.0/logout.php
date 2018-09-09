<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>注销</title>
	<?php 
	/*
	页面名称：logout.php
	功能：注销目前登陆的账户
	流程：判断是否登陆，若登陆则连接数据库，更新在线状态，销毁session，跳转到上一个页面或者主页
	
	*/
	include 'accountSystemFunc.php';
	
	?>
</head>
<?php

	if(isset($_SESSION['userName']))
	{
		$userName=$_SESSION['userName'];
		session_unset();
		session_destroy();
		
		//连接数据库
		$conn=connectDB();
		
		$sql="UPDATE account SET isOnline=0 WHERE userName=$userName";//更新在线状态
		if(mysqli_query($conn,$sql))
		{
			echo "注销成功";
		}
	}
	echo "<script type=\"text/javascript\">";
	echo 'location.href=document.referrer||"homepage.php"';
	echo "</script>";

?>