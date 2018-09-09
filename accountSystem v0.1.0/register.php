<!DOCTYPE html>
<html>
<head>
	<title>注册</title>
	<meta charset="utf-8"/>
	<style>
		.error{color:red;}
	</style>
</head>
<body>
	<?php
	function changeInput($data)//转换输入的数据
	{
		$data=trim($data);
		$data=stripslashes($data);
		$data=htmlspecialchars($data);
		return $data;
	}
	$userName=$password=$email="";
	$userNameErr=$passwordErr=$emailErr="必填项目";
	$isInfoCanUse=false;//标识信息完整度
	
	//必填项目处理
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		$isInfoCanUse=true;//初始化完整度变量
		
		//用户名
		if (empty($_POST["userName"])) 
		{
			$userNameErr = "用户名不能为空";
			$isInfoCanUse=false;
		} 
		else 
		{
			$userName = changeInput($_POST["userName"]);
		}
		
		
		//密码
		if (empty($_POST["password"])) 
		{
			$passwordErr = "密码不能为空";
			$isInfoCanUse=false;
	    } 
	    else 
		{
			$password = changeInput($_POST["password"]);
			if (!preg_match("/(\w{6,14})/",$password))
			{
				$passwordErr = "密码长度：6~14";
				$isInfoCanUse=false;
			}
	    }
		
		//邮箱
		if (empty($_POST["email"])) 
		{
			$emailErr = "邮箱不能为空";
			$isInfoCanUse=false;
	    } 
		else 
		{
			$email = changeInput($_POST["email"]);
			if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
			{
				$emailErr = "请输入正确的邮箱地址";
				$isInfoCanUse=false;
			}
	    }

	  
	}
	
	
	
	//数据库连接
	$dbServername = "localhost"; 
	$dbUsername = "root"; 
	$dbPassword = ""; 
	$dbName="users";//数据库名
	
	// 创建连接 
	$conn =mysqli_connect($dbServername, $dbUsername, $dbPassword,$dbName); 

	// 检测连接 
	if (!$conn) { 
		die("Connection failed: " . $conn->connect_error); 
	}
	else
	{
		//echo "Connected successfully";
	}
	
	//检测用户名是否被占用
	$sql="SELECT userName FROM account WHERE userName='$userName'";
	$result=mysqli_query($conn,$sql);//找不到也是执行成功，返回结果集
	$test=mysqli_fetch_assoc($result);
	if($test !=false)//记录不为空就是找到了
	{
		$userNameErr="该用户名已存在";
		echo $userNameErr;
		$isInfoCanUse=false;
	}
	
	$isRegSuccess=false;//检测是否注册成功
	if($isInfoCanUse===true)
	{//如果信息填写完整，就注册
		$sql="INSERT INTO account(userName,password,email)
		VALUES('$userName','$password','$email')";
		if(mysqli_query($conn,$sql))
		{
			$isRegSuccess=true;
		}
		else
		{
			$isRegSuccess=false;
		}
	}
	
	?>


	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	
	用户名：<input type="text" name="userName"/>
	<?php echo "<span class=error>*".$userNameErr."</span>";?><br/>
	
	请输入你的密码:<input type="password" name="password"/>
	<?php echo "<span class=error>*".$passwordErr."</span>";?><br/>
	
	你的邮箱：<input type="text" name="email"/>
	<?php echo "<span class=error>*".$emailErr."</span>";?><br/>
	
	<input type="submit" value="注册"/>
	<a href="login.php"><input type="button" value="登陆"/></a>
	
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