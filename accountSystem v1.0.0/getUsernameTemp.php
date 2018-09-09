<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>获取用户名</title>
	<?php 
	/*
	页面名称：getUsernameTemp.php
	功能：获取用户名存入session供其它页面使用
	流程：链接数据库，提交表单，检查合法性，存入session
	
	*/
	include 'accountSystemFunc.php';
	?>
</head>
<body>
	<?php
	$userName="";
	$userNameErr="";
	
	//连接数据库
	$conn=connectDB();
	
	if(!empty($_POST['submitUserName']))//提交了用户名
	{
		$userNameErr=isUserNameLegal($_POST["userName"]);
		if(isExistInDB($conn,"account","userName",$userName))
		{
			$userNameErr="该用户名已存在";
		}
		if($userNameErr=="")//没有错误时
		{
			$userName = changeInput($_POST["userName"]);
			$_SESSION['userNameTemp']=$userName;
			echo "<script type=\"text/javascript\">";
			echo 'location.href="changePwdCheck.php"';
			echo "</script>";
		}
	}

	?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	请输入你的用户名：<br/>
		<input type="text" name="userName"/><?php echo $userNameErr;?><br/>
		<input type="submit" name="submitUserName" value="确定"/><br/>
	</form>
</body>
</html>