<?php

	include ('config.php');
	$post_msg_q = "insert into scraps values('$_POST[quickmsg]')";
	mysql_query($post_msg_q);


?>