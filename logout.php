<?php

session_start();
//Testing, solution to bug, use '' always with any variable to access.
//echo $_SESSION['email'];
//echo $_SESSION['uid'];
if (isset($_SESSION['uid']))
{
		include('config.php');

		// set offline status for user
		//$_SESSION = array();
		//mysql_query("update user set status='<span style=\"color:#FF0000;\">Offline</span>' where uid='$_SESSION[uid]'");
		session_destroy();
		header('Location:index.php');

}
else if (isset($_SESSION['guestid']))
{
		include('config.php');

		// set offline status for user
		//$_SESSION = array();
		//mysql_query("update user set status='<span style=\"color:#FF0000;\">Offline</span>' where uid='$_SESSION[uid]'");
		session_destroy();
		header('Location:index.php');

}
?>