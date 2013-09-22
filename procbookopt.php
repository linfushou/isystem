<?php include 'procoptcom.php';?>
<?php
# --- 主程序，处理数据库操作动作 ---
$dbhost='localhost';        //数据库主机
$dbuser='root';             //数据库用户
$dbpass='admin';            //数据库密码
$dbname='test0918';         //数据库名
$have_db = false;
$conn_db_fail_time = 1;

if ($_POST["opt"] == "添加" || $_POST["opt"] == "更新") {
	print_debug("===检查表单信息===");
	if (check_book_form() == false) {
		print_msg("表单不正确，请重填！");
		return;
	}
}

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

if ($_POST["opt"] == "查询") {
	proc_select_book();
} else if ($_POST["opt"] == "添加") {
	proc_insert_book();
} else if ($_POST["opt"] == "删除所有") {
	proc_delete_book();
} else if ($_POST["opt"] == "删除指定") {
	proc_delete_def_book();
} else if ($_POST["opt"] == "更新") {
	proc_revise_book();	
}else {
	print_msg("无对应操作的处理！");
}

mysql_close($conn);
?>