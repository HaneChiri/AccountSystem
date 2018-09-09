<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>测试主页</title>
	<?php
	/*
	页面名称：homepage.php
	功能：测试用的主页
	流程：
	
	*/
	
	
	?>
</head>
<body>
	<?php
		
		if(isset($_SESSION['userName']))//如果登陆成功
		{
			$userName=$_SESSION['userName'];
			echo "欢迎您：".$userName;
			echo '<a href="logout.php"><input type="button" value="注销"/></a>';
		}
		else
		{
			echo '<a href="login.php"><input type="button" value="登陆"/></a>';
			echo '<a href="register.php"><input type="button" value="注册"/></a>';
		}
	?>
	
	
	
	
</body>



</html>