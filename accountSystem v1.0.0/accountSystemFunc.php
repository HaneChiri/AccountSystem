<?php
/*
函数名：
功能：
参数：
返回值：
*/

/*
函数名：changeInput($data)
功能：为数据除去多余空格和反斜杠，转换html实体字符
参数：需要转换的字符串
返回值：转换完成的数据
*/

include 'accountSystemSet.php';//账号系统设置


function changeInput($data)//转换输入的数据
{
	$data=trim($data);
	$data=stripslashes($data);
	$data=htmlspecialchars($data);
	return $data;
}

/*
函数名：connectDB()
功能：利用设置文件accountSystemSet.php中的数据库常量连接数据库
参数：无
返回值：完成连接的数据库对象
*/
function connectDB()//连接数据库函数
{
	// 创建连接 
	$conn =mysqli_connect($GLOBALS['dbServername'], $GLOBALS['dbUsername'], $GLOBALS['dbPassword'],$GLOBALS['dbName']); 

	// 检测连接 
	if (!$conn) { 
		die("数据库连接失败 " . $conn->connect_error); 
	}
	else
	{
		//echo "Connected successfully";
	}
	return $conn;
}

/*
函数名：isExistInDB($conn,$tablename,$colname,$data)
功能：检测$data是否存在于$conn的$tablename的$colname中
参数：已连接的数据库对象，数据表名，字段名，待检测的数据
返回值：是否存在
*/

function isExistInDB($conn,$tablename,$colname,$data)
{
	$sql="set names utf8";
	mysqli_query($conn,$sql);
	
	$sql="SELECT $colname FROM $tablename WHERE $colname='$data'";
	$result=mysqli_query($conn,$sql);//找不到也是执行成功，返回结果集
	$test=mysqli_fetch_assoc($result);
	if($test !=false)//记录不为空就是找到了
	{
		
		return true;
	}
	else
	{
		return false;
	}
}

/*
函数名：isMatch($conn,$tablename,$colnameK,$colnameV,$mainkey,$value)
功能：数据库中的$colnameK中的$mainkey与$colnameV中的$value是否同时存在并且对应，可以用于检测用户名和密码是否对应
参数：已连接的数据库对象，数据表名，主键字段名，数据字段名，主键值，数据值
返回值：是否匹配
*/

function isMatch($conn,$tablename,$colnameK,$colnameV,$mainkey,$value)
{
	$sql="set names utf8";
	mysqli_query($conn,$sql);
	
	$sql="SELECT $colnameV FROM $tablename WHERE ($colnameV='$value') and ($colnameK='$mainkey')";
	$result=mysqli_query($conn,$sql);
	$test=mysqli_fetch_assoc($result);
	if($test!=false)//记录不为空就是找到了
	{
		return true;
	}
	else
	{
		return false;
	}
	
}

/*
函数名：registerAccount($conn,$tablename,$userName,$password,$email,$pwdProtectQ,$pwdProtectA)
功能：利用参数注册账户
参数：已连接的数据库对象，数据表名，注册用户名，注册密码，注册邮箱，注册密保，注册密保答案
返回值：注册是否成功
*/

function registerAccount($conn,$tablename,$userName,$password,$email,$pwdProtectQ,$pwdProtectA)
{
	$regDate=date("y-m-d");//注册日期
	$sql="set names utf8";
	mysqli_query($conn,$sql);
	
	$sql="INSERT INTO $tablename(userName,password,email,regDate,pwdProtectQ,pwdProtectA)
	VALUES('$userName','$password','$email','$regDate','$pwdProtectQ','$pwdProtectA')";
	if(mysqli_query($conn,$sql))
	{
		return true;
	}
	else
	{
		return false;
	}
}

/*
函数名：isUserNameLegal($userName)
功能：检测用户名是否合法
参数：用户名
返回值：错误信息，若为空字符串则合法
*/


function isUserNameLegal($userName)
{
	if(empty($userName)) 
	{
		$userNameErr = "用户名不能为空";
	} 
	else 
	{
		$userNameErr="";//没有问题
	}
	return $userNameErr;
}

/*
函数名：isPasswordConfirmLegal($password,$passwordConfirm)
功能：检测确认密码是否合法
参数：密码，对应的确认密码
返回值：错误信息，若为空字符串则合法
*/
function isPasswordConfirmLegal($password,$passwordConfirm)
{
	$passwordConfirmErr="";
	//确认密码
	if(empty($passwordConfirm)) 
	{
		$passwordConfirmErr = "请输入确认密码";
	}
	else if($_POST["passwordConfirm"] != $_POST["password"])
	{
		$passwordConfirmErr = "与前一次输入不一致";
	}
	return $passwordConfirmErr;
	

}

/*
函数名：isPasswordLegal($password)
功能：检测密码是否合法
参数：密码
返回值：错误信息，若为空字符串则合法
*/
function isPasswordLegal($password)
{
	$passwordErr="";
	if(empty($password))
	{
		$passwordErr = "密码不能为空";
	} 
	else 
	{
		$password = changeInput($password);
		//密码格式
		if (!preg_match("/(^\w{6,14}$)/",$password))
		{
			$passwordErr = "密码长度：6~14";
		}
	}
	return $passwordErr;
}

/*
函数名：isEmailLegal($email)
功能：检测邮箱是否合法
参数：邮箱字符串
返回值：错误信息，若为空字符串则合法
*/
function isEmailLegal($email)
{
	$emailErr="";
	if(empty($email)) 
	{
		$emailErr = "邮箱不能为空";

	} 
	else 
	{
		$email = changeInput($email);
		if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
		{
			$emailErr = "请输入正确的邮箱地址";
		}
	}
	return $emailErr;
}
?>