<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>修改密码验证</title>
	<?php 
	/*
	页面名称：changePwdCheck.php
	功能：验证密保问题
	流程：提交密保答案表单，链接数据库，检验答案，若正确则跳转到修改密码页面
	
	*/
	include 'accountSystemFunc.php';
	
	?>
</head>
<body>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	<?php
	
	$userName="";
	$userNameErr=$pwdProtectAErr="";
	$html="";
	
	//连接数据库
	$conn=connectDB();
	
	
	if(isset($_SESSION['userNameTemp']))
	{
		$userName=$_SESSION['userNameTemp'];
	}
	else
	{
		echo "<script type=\"text/javascript\">";
		echo 'location.href="getUsernameTemp.php"';
		echo "</script>";
	}
	
	if($_SERVER["REQUEST_METHOD"] == "POST")//已提交
	{
		$pwdProtectA=changeInput($_POST["pwdProtectA"]);
		$sql="set names utf8";
		mysqli_query($conn,$sql);
		
		$sql="SELECT userName,pwdProtectQ,pwdProtectA FROM account WHERE userName='$userName'";
		$result=mysqli_query($conn,$sql);
		
		$row=mysqli_fetch_assoc($result);
		
		if($pwdProtectA==$row['pwdProtectA'])//验证成功
		{
			
			echo "回答正确";
			echo "<script type=\"text/javascript\">";
			echo 'location.href="changePwd.php"';
			echo "</script>";
		}
		else
		{
			$pwdProtectAErr="回答错误";
			
		}		
	}
		
	$sql="set names utf8";
	mysqli_query($conn,$sql);
	
	//查询对应的密保问题
	$sql="SELECT userName,pwdProtectQ,pwdProtectA FROM account WHERE userName='$userName'";
	$result=mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($result);
	
	$html='请回答您的密保问题:<br/>'.$row['pwdProtectQ'].'<br/>';
	$html.='<input type="text" name="pwdProtectA"/>'.$pwdProtectAErr.'<br/>';
	$html.='<input type="submit" name="submitPwd" value="确定"/><br/>';
	
	
	echo $html;
	?>
</body>
</html>