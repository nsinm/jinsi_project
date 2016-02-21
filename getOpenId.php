<?php

$dsn = 'mysql:host=rdsvda87txg713u30yiq.mysql.rds.aliyuncs.com;dbname=jinsi';
//开发环境
//$dsn = 'mysql:host=rds7ruu3avbmjeb.mysql.rds.aliyuncs.com;dbname=db_westlake';

$username = 'jinsi';
$passwd = 'Jinsi123654';

try {
	$dbh = new PDO($dsn, $username, $passwd);
} catch (Exception $e) {
	echo 'Fail to connect to database!\n';
	echo $e->getMessage();
}
$s = $_GET['s'];
$e = $_GET['e'];
if(!$s || !$e){
	echo "请输入日期";
	exit;
}
$s = strtotime($s);
$e = strtotime($e);
echo "wx97dbdedbe2733e60"."<br>";
$sql = "SELECT openid FROM `tp_wechat_group_list` where subscribe_time>{$s} and subscribe_time<{$e}";
foreach ($dbh->query($sql) as $row) {
	echo $row['openid']."<br>";

}

