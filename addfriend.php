<?php

session_start();

if (isset($_SESSION[uid]))
{
	include('config.php');
	
	if (isset($_GET[uid]))
	{
		if($_GET[uid]!=$_SESSION[uid])
		{
			$getfriends_res = mysql_query("select * from user where uid='$_SESSION[uid]'");
			$getfriends = mysql_fetch_array($getfriends_res);
	
			$finalfriends = $getfriends[friends]."-".$_GET[uid];
			
			/*			
			$newfriends = explode(" OR ",$getfriends[friends]);
		

			array_push($newfriends,"$_GET[uid]");
			
			$finalfriends = implode(" OR ",$newfriends);
			*/
			mysql_query("update user set friends='$finalfriends' where uid='$_SESSION[uid]'");
			//echo "update user set friends='$finalfriends' where uid='$_SESSION[uid]'";
			header('Location:home.php');
	
		}
		else	
		{
			echo "<script language=javascript>alert(\"You cannot add yourself as a friend\");document.location.href=\"./home.php\"</script>";
		}	
	}
	
}
