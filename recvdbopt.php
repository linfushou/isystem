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
$sql = "CREATE TABLE if not exists persons 
(
FirstName varchar(15),
LastName varchar(15),
Age int
)";
if (mysql_query($sql, $conn)) {
	print_debug("�ɹ�������� - persons");
} else {
	print_msg("�������personsʧ��".mysql_error());
	mysql_close($conn);
	return;
}
print_debug("persons��񴴽�OK");
mysql_close($conn);
?>

<html>
<!-- ����SQL�������� -->
�����ϵ��
<form action="procdbopt.php" method="post">
����(����): <input type="text" name="lastname" /><br>
����(����): <input type="text" name="firstname" /><br>
����(����): <input type="text" name="age" /><br>
�绰(ѡ��): <input type="text" name="phone" /><br>
<input type="submit" value="���" name="opt"/>
</form>

ɾ��ָ����ϵ��
<form action="procdbopt.php" method="post">
����(����): <input type="text" name="firstname" /><br>
<input type="submit" value="ɾ��ָ��" name="opt"/>
</form>

ɾ��������ϵ��
<form action="procdbopt.php" method="post">
<input type="submit" value="ɾ������" name="opt"/>
</form>

��ѯ������ϵ��
<form action="procdbopt.php" method="post">
<input type="submit" value="��ѯ" name="opt"/>
</form>

������ϵ��
<form action="procdbopt.php" method="post">
����(����): <input type="text" name="lastname" /><br>
����(����): <input type="text" name="firstname" /><br>
����(����): <input type="text" name="age" /><br>
�绰(ѡ��): <input type="text" name="phone" /><br>
<input type="submit" value="����" name="opt"/>
</form>

</html>