<?php include 'procoptcom.php';?>
<?php
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

if ($_POST["opt"] == "��ѯ") {
	proc_select_book();
} else if ($_POST["opt"] == "���") {
	proc_insert_book();
} else if ($_POST["opt"] == "ɾ������") {
	proc_delete();
} else if ($_POST["opt"] == "ɾ��ָ��") {
	proc_delete_def();
} else if ($_POST["opt"] == "����") {
	proc_revise();	
}else {
	print_msg("�޶�Ӧ�����Ĵ���");
}

mysql_close($conn);
?>