<?php
include("/home/admin/domains/purb.net/public_html/config.php");
$dt = date("Y-m-d G:i:s");
mysql_query("insert into cron(dt) values('$dt')");
mysql_query("delete from ips");
?>