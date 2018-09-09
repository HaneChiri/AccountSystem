<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>登陆</title>
	<meta charset="utf-8"/>
	<style>
		.error{color:red;}
	</style>
</head>
<body>
	<?php
	
	$dbServername="localhost";
	$dbUserName="root";
	$dbPassword="";
	$dbName="users";
	
	$isInfoCanUse=false;//标识信息完整度
	
	$conn=mysqli_connect($dbServername,$dbUserName,$dbPassword,$dbName);
	// 检测连接 
	if (!$conn) { 
		die("Connection failed: " . $conn->connect_error); 
	}
	else
	{
		//echo "Connected successfully";
	}
	
	
	
	$userNameErr=$passwordErr="";
	//提交表单之后
	if($_SERVER['REQUEST_METHOD']=="POST")
	{
		//用户名
		$isInfoCanUse=true;
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
	    }
		
		//用户名和密码检查
		if($isInfoCanUse)
		{
			$sql="SELECT userName FROM account WHERE userName='$userName'";
			$result=mysqli_query($conn,$sql);
			$test=mysqli_fetch_assoc($result);//如果为false则是未找到
			if($test==false)
			{
				$userNameErr = "用户名不存在";
			}
			else
			{
				$sql="SELECT password FROM account WHERE password='$password'";
				$result=mysqli_query($conn,$sql);
				$test=mysqli_fetch_assoc($result);
				if($test==false)
				{
					$passwordErr="密码错误";
				}
				else//登陆成功
				{
					//存入session
					
					$_SESSION['userName']=$userName;
					
					
					echo "登陆成功!";
					
					//页面跳转
					echo "<script type=\"text/javascript\">";
					echo "window.location.href='homepage.php';";//返回上一个页面
					echo "</script>";
					
				}
			}
		}
		
			
	}
	
	
	
	
	
	
	function changeInput($data)//转换输入的数据
	{
		$data=trim($data);
		$data=stripslashes($data);
		$data=htmlspecialchars($data);
		return $data;
	}
	
	
	
	?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	
	用户名：<input type="text" name="userName"/>
	<?php echo "<span class=error>*".$userNameErr."</span>";?><br/>
	
	密码:<input type="password" name="password"/>
	<?php echo "<span class=error>*".$passwordErr."</span>";?><br/>
	
	
	<input type="submit" value="登陆"/>
	<a href="register.php"><input type="button" value="注册"/></a>
	</form>
	
</body>
</html>