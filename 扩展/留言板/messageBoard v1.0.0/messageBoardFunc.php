<?php
/*
用于存放留言板所使用的函数

*/
/*
函数名：
功能：
参数：
返回值：
*/

/*
函数名：displayBoard($conn)
功能：显示留言板内容
参数：已连接的数据库对象
返回值：留言数量
*/
function displayBoard($conn)
{
	//此处使用表格显示留言，可修改为有样式的div
	echo "<table border=1>";
	
	$sql="set names utf8";//转换编码以免乱码
	mysqli_query($conn,$sql);
	
	$sql="SELECT * FROM messageboard";
	$result=mysqli_query($conn,$sql);
	
	$num=0;//留言计数器
	if($result &&  mysqli_num_rows($result))//如果留言板有数据
	{
		while($row=mysqli_fetch_assoc($result))
		{
			$num++;
			echo "<tr>";
			
			echo "<td>";
			echo $row['floorsNum'].'L';
			echo "</td>";
		
			echo "<th>";
			echo $row['userName']." 留言：";
			echo "</th>";
			
			echo "<td>";
			echo $row['content'];
			echo "</td>";
			
			/*
			echo "<td>";
			echo '点赞数：'.$row['starsNum'];
			echo "</td>";
			*/
			
			echo "</tr>";
		}
	}
	
	echo "</table>";
	return $num;
}



?>