<?php
/**
 * Created by PhpStorm.
 * User: huangtuo
 * Date: 16/4/26
 * Time: обнГ8:51
 */
$lnk = mysql_connect('rdsvda87txg713u30yiq.mysql.rds.aliyuncs.com', 'jinsi', 'Jinsi123654')
or die ('Not connected : ' . mysql_error());

// make foo the current db
mysql_select_db('jinsi2', $lnk) or die ('Cant use foo : ' . mysql_error());

mysql_query("set names 'utf9mb4'");
$value = $_POST['content'];

$sql = "INSERT INTO `jinsi_emoji` (`id`, `content`) VALUES (NULL, '{$value}');";

$rs = mysql_query($sql);
print_r($rs);
