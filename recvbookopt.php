<html>
<?php
include "procoptcom.php";

# ȷ���Ƿ������ݿ����Ӧ���û���򴴽�
# --- �����򣬴������ݿ�������� ---
$dbhost='localhost';        //���ݿ�����
$dbuser='root';             //���ݿ��û�
$dbpass='admin';            //���ݿ�����
$dbname='test0918';         //���ݿ���
$have_db = false;
$conn_db_fail_time = 1;

# ����MySQL������
if (!$conn = mysql_connect($dbhost, $dbuser, $dbpass))
{
	print_debug("�޷��������ݿ�����");
	exit;
}
print_debug("����MySQL���ݿ�����");
mysql_query("SET NAMES gb2312");

# �������ݿ⣬û���򴴽�
do {
	if (!mysql_select_db($dbname,$conn))
	{
		# ����ʧ�ܳ���5���˳�
		if (++$conn_db_fail_time > 5) {
			mysql_close($conn);
			exit;
		}
		echo "<br/>";
		echo "Fail to select database. Create it.";
		mysql_query("CREATE DATABASE ".$dbname,$conn);
	} else {
		$have_db = true;
		print_debug("�������ݿ���� = ".$conn_db_fail_time);
	}	
} while ($have_db == false);

print_debug("��ѯ�Ƿ����鼮���");
#  ��ѯ����Ƿ���� XXX ������������
#if (check_table_is_exist('book')) {

$sql = "CREATE TABLE if not exists book 
(
name varchar(15),
author varchar(15),
pubdate varchar(15),
shtdesc varchar(30),
adddate varchar(15)
)";
if (mysql_query($sql, $conn)) {
	print_debug("�ɹ�������� - book");
} else {
	print_msg("�������bookʧ��".mysql_error());
	mysql_close($conn);
	return;
}
print_debug("ͼ���񴴽�OK");
mysql_close($conn);
?>

<!-- ����SQL�������� -->
����鼮
<form action="procbookopt.php" method="post">
����(����): <input type="text" name="name" /><br>
����(����): <input type="text" name="author" /><br>
��������(����): <input type="text" name="pubdate" /><br>
������(ѡ��): <input type="text" name="shtdesc" /><br>
�������(����): <input type="text" name="adddate" /><br>
<input type="submit" value="���" name="opt"/>
</form>

��ѯ�����鼮
<form action="procbookopt.php" method="post">
<input type="submit" value="��ѯ" name="opt"/>
</form>
<!--
ɾ��ָ����ϵ��
<form action="procdbopt.php" method="post">
����(����): <input type="text" name="firstname" /><br>
<input type="submit" value="ɾ��ָ��" name="opt"/>
</form>

ɾ��������ϵ��
<form action="procdbopt.php" method="post">
<input type="submit" value="ɾ������" name="opt"/>
</form>

������ϵ��
<form action="procdbopt.php" method="post">
����(����): <input type="text" name="lastname" /><br>
����(����): <input type="text" name="firstname" /><br>
����(����): <input type="text" name="age" /><br>
�绰(ѡ��): <input type="text" name="phone" /><br>
<input type="submit" value="����" name="opt"/>
</form>
-->
</html>