<?php
# --- ���ô����� ---
# ��ӡ������Ϣ
function print_debug($msg)
{
	# ���Թر�
	$debug = false;
	
	if ($debug) {
		echo "DEBUG: ".$msg."<br/>";
	}
}

# ��ӡϵͳ��־syslog
function print_msg($msg)
{
	echo $msg."<br/>";
}

function proc_select()
{
	print_debug("���ڴ����ѯ......");
	print '<table border="1">';
	print '<tr>';
	print '<td>����</td>';
	print '<td>����</td>';
	print '</tr>';
	$result = mysql_query("SELECT * FROM Persons");
	print_debug("RESULT = ".$result);
	while($row = mysql_fetch_array($result))
	{
		print '<tr>';
		print "<td>".$row['LastName'].$row['FirstName']."</td>";
		print "<td>".$row['Age']."</td>";
		print '</tr>';
	}

	print '</table>';
}

function proc_select_book()
{
	print_debug("���ڴ����ѯ......");
	print '<table border="1">';
	print '<tr>';
	print '<td>����</td>';
	print '<td>����</td>';
	print '<td>����ʱ��</td>';
	print '<td>������</td>';
	print '<td>���ʱ��</td>';
	print '</tr>';
	$result = mysql_query("SELECT * FROM book");
	while($row = mysql_fetch_array($result))
	{
		print '<tr>';
		print "<td>".$row['name']."</td>";
		print "<td>".$row['author']."</td>";
		print "<td>".$row['pubdate']."</td>";
		print "<td>".$row['shtdesc']."</td>";
		print "<td>".$row['adddate']."</td>";
		print '</tr>';
	}

	print '</table>';
}

function proc_select_exist($name)
{
	print_debug("���ڲ�ѯȷ���Ƿ����");
	$result = mysql_query("SELECT * FROM Persons WHERE FirstName='".$name."'");
	if($row = mysql_fetch_array($result))
	{
		print_debug("��ϵ���Ѵ��ڣ��������, row = ".$row);
		return true;
	}
	
	print_debug("��ϵ�˲����ڣ���Ӵ���, row = ".$row);
	return false;
}

function proc_book_exist($name)
{
	print_debug("���ڲ�ѯȷ���Ƿ����");
	$result = mysql_query("SELECT * FROM book WHERE name='".$name."'");
	if($row = mysql_fetch_array($result))
	{
		print_debug("ͼ���Ѵ��ڣ��������, row = ".$row);
		return true;
	}
	
	print_debug("ͼ�鲻���ڣ���Ӵ���, row = ".$row);
	return false;
}

function proc_insert()
{
	if (proc_select_exist($_POST["firstname"]) == true) {
		return;
	}
	$sql = "INSERT INTO Persons (FirstName, LastName, Age) 
	VALUES ('".$_POST["firstname"]."', '".$_POST["lastname"]."', '".$_POST["age"]."')";
	if (mysql_query($sql)) {
		print_msg("�ɹ������ϵ��.");
	} else {
		print_debug("Fail to insert record, ".mysql_error());
	}
}

function proc_insert_book()
{
	if (proc_book_exist($_POST["name"]) == true) {
		return;
	}
	$sql = "INSERT INTO book (name, author, pubdate, shtdesc, adddate) 
	VALUES ('".$_POST["name"]."', '".$_POST["author"]."', '".$_POST["pubdate"]."','".$_POST["shtdesc"]."','".$_POST["adddate"]."')";
	if (mysql_query($sql)) {
		print_msg("�ɹ�����鼮.".$_POST["name"]);
	} else {
		print_debug("Fail to insert record, ".mysql_error());
	}
}

function proc_delete()
{
	$sql = "DELETE FROM persons";
	if (mysql_query($sql)) {
		print_msg("�ɹ�ɾ��������ϵ��.");
	} else {
		print_debug("Fail to delete record, ".mysql_error());
	}	
}

function proc_delete_def()
{
	print_debug("����ɾ����ϵ��");
	$sql = "DELETE FROM persons WHERE FirstName='".$_POST["firstname"]."'";
	if (mysql_query($sql)) {
		print_msg("�ɹ�ɾ����ϵ�� -  ".$_POST["firstname"]);
	} else {
		print_debug("Fail to delete record, ".mysql_error());
	}	
}

function proc_revise()
{
	print_debug("�����޸���ϵ��");
	$sql = "UPDATE persons SET Age = '".$_POST["age"]."'
		WHERE FirstName = '".$_POST["firstname"]."' AND LastName = '".$_POST["lastname"]."'";
	if (mysql_query($sql)) {
		print_msg("�ɹ��޸���ϵ�� -  ".$_POST["lastname"].$_POST["firstname"]);
	} else {
		print_debug("Fail to delete record, ".mysql_error());
	}	
}

# �˶Ա���Ƿ��
function check_form()
{
	if ($_POST["lastname"] == "") {
		print_msg("���ϲ���Ϊ�գ�");
		return false;	
	}
	if ($_POST["firstname"] == "") {
		print_msg("���ֲ���Ϊ�գ�");
		return false;
	}	
	if ($_POST["age"] == "") {
		print_msg("���䲻��Ϊ�գ�");
		return false;		
	}
	
	return true;
}


function check_table_is_exist($find_table)
{		
    $result = mysql_list_tables($find_table);		  
    $i=0;  
    while ($i < mysql_num_rows($result))
    {
		if ('Table_Name' == mysql_tablename($result,$i)) {
			echo '����';
			return true;
		}		  
        $i++;     
    }
    echo '������';
	return false;
}

?>
