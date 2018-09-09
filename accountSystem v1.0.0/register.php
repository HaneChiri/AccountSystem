<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>注册</title>
	<meta charset="utf-8"/>
	<style>
		.error{color:red;}
	</style>
	<?php
	/*
	页面名称：register.php
	功能：注册账户
	流程：提交表单，合法性检测，连接数据库，注册成功
	
	*/
	include 'accountSystemFunc.php';
	
	?>
</head>
<body>
	<?php
	
	//v1.0.0修改部分
	$userName=$password=$passwordConfirm=$email="";
	$userNameErr=$passwordConfirmErr=$emailErr="";
	$passwordErr="6~14位字母与数字";
	$pwdProtectQ=$pwdProtectA="";
	
	//必填项目处理
	if ($_SERVER["REQUEST_METHOD"] == "POST" ) 
	{
		$isInfoCanUse=true;//初始化完整度变量
		
		//用户名
		$userNameErr=isUserNameLegal($_POST["userName"]);
		if($userNameErr=="")
		{
			$userName = changeInput($_POST["userName"]);
		}
		
		//密码
		$passwordErr=isPasswordLegal($_POST['password']);
		if($passwordErr=="")
		{
			$password = changeInput($_POST["password"]);
		}
		
		$passwordConfirmErr=isPasswordConfirmLegal($_POST["password"],$_POST['passwordConfirm']);
		if($passwordConfirmErr=="")
		{
			$passwordConfirm = changeInput($_POST["passwordConfirm"]);
		}
		
		//邮箱
		$emailErr=isEmailLegal($_POST['email']);
		if($emailErr=="")
		{
			$email=changeInput($_POST['email']);
		}

		//密保
		$pwdProtectQ=changeInput($_POST["pwdProtectQ"]);
		$pwdProtectA=changeInput($_POST["pwdProtectA"]);
	  
	}
	
	//连接数据库
	$conn=connectDB();
	
	
	//检测用户名是否被占用

	if(isExistInDB($conn,"account","userName",$userName))//记录不为空就是找到了
	{
		$userNameErr="该用户名已存在";
	}  
	$isRegSuccess=false;//检测是否注册成功
	if($userNameErr=="" &&$passwordErr=="" && $passwordConfirmErr=="" && $emailErr=="")
	{//如果信息填写完整，就注册
		$isRegSuccess=registerAccount($conn,"account",$userName,$password,$email,$pwdProtectQ,$pwdProtectA);
	}
	
	?>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	
	用户名：<input type="text" name="userName" />
	<?php echo "<span class=error>*".$userNameErr."</span>";?><br/>
	
	请输入你的密码：<input type="password" name="password"/>
	<?php echo "<span class=error>*".$passwordErr."</span>";?><br/>
	
	<!--v1.0.0修改部分-->
	请再次输入你的密码：<input type="password" name="passwordConfirm"/>
	<?php echo "<span class=error>*".$passwordConfirmErr."</span>";?><br/>
	
	你的邮箱：<input type="text" name="email"/>
	<?php echo "<span class=error>*".$emailErr."</span>";?><br/>
	
	<!--v1.0.0修改部分-->
	密保问题：<input type="text" name="pwdProtectQ"/><br/>
	
	密保答案：<input type="text" name="pwdProtectA"/><br/>
	
	
	<input type="submit" value="注册"/>
	
	<a href="login.php" target="_blank"><input type="button" value="登陆"/></a>
	
	</form>
		
	
	
	<?php 
		if($isRegSuccess)
		{
			echo "注册成功！<br/>";
			echo "注册用户名：".$userName."<br/>";
			echo "注册邮箱：".$email."<br/>";
		}
		else
		{
			//echo "注册失败！";
		}
	
	?>

</body>
</html>