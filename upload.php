<?php

session_start();

if(isset($_SESSION[uid]))
{

	include('config.php');
	$checkpic = mysql_query("select photo from profiles where uid='$_SESSION[uid]'");
	$check = mysql_fetch_array($checkpic);

// Generate MD5 hash of a pseudorandom number and add to filename

	$path = "./avatars/". md5(rand()).$_FILES["file_photo"]["name"];
/*
	if ($check[photo]=="")
	{
		move_uploaded_file($_FILES["file_photo"]["tmp_name"],$path);	
		
		if(mysql_query("insert into profiles(uid,photo) values('$_SESSION[uid]','$path')")) 
		{
			header('Location:home.php');
		}
		

	}
	else
	{
*/
		move_uploaded_file($_FILES["file_photo"]["tmp_name"],$path);	
	
		if(mysql_query("update profiles set photo='$path' where uid='$_SESSION[uid]'")) 
		{
			header('Location:home.php');
		}
		else
		{
			echo "Error in uploading Photo";
		}

	
	
	


}
?>