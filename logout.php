<?php

session_start();
if (isset($_SESSION["uid"]))
{
		include('config.php');

		// set offline status for user
		
		//mysql_query("update user set status='<span style=\"color:#FF0000;\">Offline</span>' where uid='$_SESSION[uid]'");
		session_destroy();
		header('Location:index.php');

}

?>