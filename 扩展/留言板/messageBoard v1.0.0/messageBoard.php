<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>留言板</title>
	<?php
	/*
	页面名称：messageBoard.php
	功能：留言板
	
	*/
	include 'accountSystemFunc.php';
	include 'messageBoardFunc.php';
	?>
</head>
<body>
	<?php
	
	//连接数据库
	$conn=connectDB();
	
	//==========================数据检测部分=====================
	$userName="";
	$content="";
	$contentErr="";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		
		if (empty($_POST["content"])) 
		{
			$contentErr = "评论不能为空";
			
		} 
		else 
		{
			$content = changeInput($_POST["content"]);
			$userName=changeInput($_SESSION['userName']);
		}
	  
	}
	//==========================数据插入部分=====================
	if($contentErr=="")//如果没有错误
	{
		$sql="set names utf8";//转换编码以免乱码
		mysqli_query($conn,$sql);
		
		
		$sql="INSERT INTO messageboard(userName,content)
		VALUES('$userName','$content')";
		mysqli_query($conn,$sql);
	}
	//==========================留言显示部分=====================
	displayBoard($conn);
	
	?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
	
	
	<?php
		//登陆按钮
		if(isset($_SESSION['userName']))
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
		
		echo "<br/>";
		
		
		if(isset($_SESSION['userName']))//登陆检测
		{
			echo '<textarea rows="10" cols="100" name="content"></textarea>'
				.$contentErr.
				'<br/>
				<input type="submit" value="提交留言"/>';
		}
		else
		{
			echo "登陆后评论";
			
		}
    
	?>
	
	
	</form>
</body>
</html>