<?php

session_start();

if (isset($_POST['submitlogin']))
{
	include('config.php');
	$check_credentials = "select * from user where email='$_POST[email]' and userPass='$_POST[pass]'";
	$check_credentials_res = mysql_query($check_credentials);
	
	if (mysql_num_rows($check_credentials_res)!=0)
	{
		
		// set the session variables		
		
		$_SESSION['email'] = $_POST['email'];
		$_SESSION[photo_loc] = 'dir';
		$row =	mysql_fetch_array($check_credentials_res);
		$_SESSION['uid'] = $row['uId'];
		$_SESSION['username'] = $row['userName'];

		
		
		header('Location:home.php');
	}
	else
	{
		header('Location:index.php?status=loginfailed');
	}
	
}
else if (isset($_POST['guestlogin'])) {
	$_SESSION['guestid'] = "guest"; 
	$_SESSION['guestusername'] = "guest";
	header('Location:showgallery.php');
}
else
{
	header('Location:index.php');

}



?>