<?php
include "procoptcom.php";

# 确认是否有数据库和相应表格，没有则创建
# --- 主程序，处理数据库操作动作 ---
$dbhost='localhost';        //数据库主机
$dbuser='root';             //数据库用户
$dbpass='admin';            //数据库密码
$dbname='test0918';         //数据库名
$have_db = false;
$conn_db_fail_time = 1;

# 连接MySQL服务器
if (!$conn = mysql_connect($dbhost, $dbuser, $dbpass))
{
	print_debug("无法连接数据库主机");
	exit;
}
print_debug("连接MySQL数据库主机");
mysql_query("SET NAMES gb2312");

# 连接数据库，没有则创建
do {
	if (!mysql_select_db($dbname,$conn))
	{
		# 连接失败超过5次退出
		if (++$conn_db_fail_time > 5) {
			mysql_close($conn);
			exit;
		}
		echo "<br/>";
		echo "Fail to select database. Create it.";
		mysql_query("CREATE DATABASE ".$dbname,$conn);
	} else {
		$have_db = true;
		print_debug("连接数据库次数 = ".$conn_db_fail_time);
	}	
} while ($have_db == false);

print_debug("查询是否有书籍表格");
$sql = "CREATE TABLE if not exists persons 
(
FirstName varchar(15),
LastName varchar(15),
Age int
)";
if (mysql_query($sql, $conn)) {
	print_debug("成功创建表格 - persons");
} else {
	print_msg("创建表格persons失败".mysql_error());
	mysql_close($conn);
	return;
}
print_debug("persons表格创建OK");
mysql_close($conn);
?>

<html>
<!-- 接收SQL操作动作 -->
添加联系人
<form action="procdbopt.php" method="post">
姓氏(必填): <input type="text" name="lastname" /><br>
名字(必填): <input type="text" name="firstname" /><br>
年龄(必填): <input type="text" name="age" /><br>
电话(选填): <input type="text" name="phone" /><br>
<input type="submit" value="添加" name="opt"/>
</form>

删除指定联系人
<form action="procdbopt.php" method="post">
名字(必填): <input type="text" name="firstname" /><br>
<input type="submit" value="删除指定" name="opt"/>
</form>

删除所有联系人
<form action="procdbopt.php" method="post">
<input type="submit" value="删除所有" name="opt"/>
</form>

查询所有联系人
<form action="procdbopt.php" method="post">
<input type="submit" value="查询" name="opt"/>
</form>

更新联系人
<form action="procdbopt.php" method="post">
姓氏(必填): <input type="text" name="lastname" /><br>
名字(必填): <input type="text" name="firstname" /><br>
年龄(必填): <input type="text" name="age" /><br>
电话(选填): <input type="text" name="phone" /><br>
<input type="submit" value="更新" name="opt"/>
</form>

</html>