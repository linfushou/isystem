设计

MVC - Model、View、Controller
模型 - 数据库操作模型 procdbopt.php 处理用户操作
视图 - index.html，将结果反馈给用户
控制 - 接收输入信息，将用户指令和数据传递给业务模型

界面显示、用户操作结果反馈（和用户交互）
接收业务请求（用户请求和业务模块交互）
处理业务请求（和数据库MYSQL交互）

MySQL数据导入导出方法
方法一：命令行界面操作
1、导出
mysqldump -u root -p test0918 > c:\test0918.sql
2、导入
mysql -u root -p test0918 < c:\test0918.sql
