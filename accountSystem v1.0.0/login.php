<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>登陆</title>
	<meta charset="utf-8"/>
	<style>
		.error{color:red;}
	</style>
	<?php 
	/*
	页面名称：
	功能：
	流程：
	
	*/
	/*
	页面名称：lohin.php
	功能：登陆账户
	流程：提交表单，合法性检查，合法则把用户名写入session
	
	*/
	include 'accountSystemFunc.php';
	?>
</head>
<body>
	<?php
	$userNameErr=$passwordErr="";
	if(isset($_SESSION['userName']))
	{
		$userName=$_SESSION['userName'];
		echo $userName."，您已经登陆，如果要继续登陆，请注销当前账号";
		echo '<a href="logout.php"><input type="button" value="注销"/></a>';
	}
	else
	{
		$isInfoCanUse=false;//标识信息完整度
		
		//连接数据库
		$conn=connectDB();

		//提交表单之后
		if($_SERVER['REQUEST_METHOD']=="POST")
		{
			
			$isInfoCanUse=true;
			//用户名合法性检查
			$userNameErr=isUserNameLegal($_POST["userName"]);
			if($userNameErr=="")
			{
				$userName = changeInput($_POST["userName"]);
			}
			
			
			//密码合法性检查
			$passwordErr=isPasswordLegal($_POST['password']);
			if($passwordErr=="")
			{
				$password = changeInput($_POST["password"]);
			}
			
			//用户名和密码匹配检查
			if($isInfoCanUse)
			{
				if(!isExistInDB($conn,"account","userName",$userName))
				{
					$userNameErr="该用户名不存在";
				}
				else
				{
					if(!isMatch($conn,"account","userName","password",$userName,$password))
					{
						$passwordErr="密码错误";
					}
					else//登陆成功
					{
						//存入session
						
						$_SESSION['userName']=$userName;
						$sql="UPDATE account SET isOnline=1 WHERE userName=$userName";//更新在线状态
						if(mysqli_query($conn,$sql))
						{
							echo "登陆成功!";
							
							
							//页面跳转
							echo "<script type=\"text/javascript\">";
							echo 'location.href=history.go(-2)||"homepage.php"';
							echo "</script>";
						}
						else
						{
							echo "登陆失败，请再刷新页面重试";
						}
						
						
					}
				}
			}
			
				
		}
	}
	
	
	?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	
	用户名：<input type="text" name="userName"/>
	<?php echo "<span class=error>*".$userNameErr."</span>";?><br/>
	
	密码:<input type="password" name="password"/>
	<?php echo "<span class=error>*".$passwordErr."</span>";?><br/>
	
	
	<input type="submit" value="登陆"/>
	<a href="register.php"><input type="button" value="注册"/></a>
	<a href="changePwdCheck.php" target="_blank"><input type="button" value="忘记密码"/></a>
	</form>
	
</body>
</html>