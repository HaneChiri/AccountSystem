<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>修改密码</title>
	<meta charset="utf-8"/>
	<style>
		.error{color:red;}
	</style>
	<?php 
	/*
	页面名称：changePwd.php
	功能：修改密码
	流程：判断是否获取了用户名，没有则跳转到获取用户名页面，有则连接数据库然后修改密码
	
	*/
	include 'accountSystemFunc.php';
	?>
</head>
<body>
	
	<?php
	
	if(isset($_SESSION['userNameTemp']))//已经获取了用户名
	{
		$userName=$_SESSION['userNameTemp'];
		$isInfoCanUse=false;
		$password=$passwordConfirm="";
		$passwordErr=$passwordConfirmErr="";
		
		//连接数据库
		$conn=connectDB();
		
		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			
			
			//密码
			$passwordErr=isPasswordLegal($_POST['password']);
			if($passwordErr=="")
			{
				$password = changeInput($_POST["password"]);
			}
			
			$passwordConfirmErr=isPasswordConfirmLegal($_POST["password"],$_POST['passwordConfirm']);
			if($passwordConfirmErr=="" && $passwordErr=="")
			{
				$passwordConfirm = changeInput($_POST["passwordConfirm"]);
				//修改密码
				$sql="set names utf8";
				mysqli_query($conn,$sql);
				
				$sql="UPDATE account SET password=$password WHERE userName=$userName";
				if(mysqli_query($conn,$sql))
				{
					echo "修改成功，请记住你的新密码<br/>";
					echo "<script type=\"text/javascript\">";
					echo 'location.href=homepage.php';
					echo "</script>";
				}
				else
				{
					echo "因为某些原因，修改密码失败，请刷新页面重试<br/>";
				}
			}
			
				
			
			$sql="set names utf8";
			mysqli_query($conn,$sql);
		}
	}
	else
	{
		echo "<script type=\"text/javascript\">";
		echo 'location.href="getUsernameTemp.php"';
		echo "</script>";  
	}
	
	
	?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	请输入你的新密码:
	<input type="password" name="password"/><?php echo $passwordErr;?><br/>
	
	请再次输入你的新密码:
	<input type="password" name="passwordConfirm"/><?php echo $passwordConfirmErr;?><br/>
	<input type="submit" value="确定"/><br/>
	
	
	
	</form>
</body>
</html>