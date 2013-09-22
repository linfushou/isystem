<?php
# --- 常用处理函数 ---
# 打印调试信息
function print_debug($msg)
{
	# 调试关闭
	$debug = false;
	
	if ($debug) {
		echo "DEBUG: ".$msg."<br/>";
	}
}

# 打印系统日志syslog
function print_msg($msg)
{
	echo $msg."<br/>";
}

function proc_select()
{
	print_debug("正在处理查询......");
	print '<table border="1">';
	print '<tr>';
	print '<td>姓名</td>';
	print '<td>年龄</td>';
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
	print_debug("正在处理查询......");
	print '<table border="1">';
	print '<tr>';
	print '<td>书名</td>';
	print '<td>作者</td>';
	print '<td>出版时间</td>';
	print '<td>简单描述</td>';
	print '<td>添加时间</td>';
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
	print_debug("正在查询确认是否存在");
	$result = mysql_query("SELECT * FROM Persons WHERE FirstName='".$name."'");
	if($row = mysql_fetch_array($result))
	{
		print_debug("联系人已存在，不需添加, row = ".$row);
		return true;
	}
	
	print_debug("联系人不存在，添加处理, row = ".$row);
	return false;
}

function proc_book_exist($name)
{
	print_debug("正在查询确认是否存在");
	$result = mysql_query("SELECT * FROM book WHERE name='".$name."'");
	if($row = mysql_fetch_array($result))
	{
		print_debug("图书已存在，不需添加, row = ".$row);
		return true;
	}
	
	print_debug("图书不存在，添加处理, row = ".$row);
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
		print_msg("成功添加联系人.");
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
		print_msg("成功添加书籍.".$_POST["name"]);
	} else {
		print_debug("Fail to insert record, ".mysql_error());
	}
}

function proc_delete()
{
	$sql = "DELETE FROM persons";
	if (mysql_query($sql)) {
		print_msg("成功删除所有联系人.");
	} else {
		print_debug("Fail to delete record, ".mysql_error());
	}	
}

function proc_delete_def()
{
	print_debug("正在删除联系人");
	$sql = "DELETE FROM persons WHERE FirstName='".$_POST["firstname"]."'";
	if (mysql_query($sql)) {
		print_msg("成功删除联系人 -  ".$_POST["firstname"]);
	} else {
		print_debug("Fail to delete record, ".mysql_error());
	}	
}

function proc_revise()
{
	print_debug("正在修改联系人");
	$sql = "UPDATE persons SET Age = '".$_POST["age"]."'
		WHERE FirstName = '".$_POST["firstname"]."' AND LastName = '".$_POST["lastname"]."'";
	if (mysql_query($sql)) {
		print_msg("成功修改联系人 -  ".$_POST["lastname"].$_POST["firstname"]);
	} else {
		print_debug("Fail to delete record, ".mysql_error());
	}	
}

# 核对表达是否空
function check_form()
{
	if ($_POST["lastname"] == "") {
		print_msg("姓氏不能为空！");
		return false;	
	}
	if ($_POST["firstname"] == "") {
		print_msg("名字不能为空！");
		return false;
	}	
	if ($_POST["age"] == "") {
		print_msg("年龄不能为空！");
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
			echo '存在';
			return true;
		}		  
        $i++;     
    }
    echo '不存在';
	return false;
}

?>
