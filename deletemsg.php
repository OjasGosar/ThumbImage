<?php

session_start();

if(isset($_SESSION[uid]))
{

	if(isset($_GET[msg]))
	{
		include('config.php');
		$check_q = "select * from scraps where msg_uid='$_GET[msg]'";

		$check_res = mysql_query($check_q);

		$check = mysql_fetch_array($check_res);


		// check if scrap to be deleted belongs to logged in user
		// OR is posted by logged in user

		if($check[to_uid]==$_SESSION[uid] || $check[from_uid]==$_SESSION[uid])
		{
			
			mysql_query("delete from scraps where msg_uid='$_GET[msg]'");
			$redir = $_SERVER[HTTP_REFERER];
			header("Location:$redir");
		
		}
		

	}
}