<?php

session_start();

if(isset($_SESSION['uid']))
{

	if(isset($_GET['commentId']))
	{
		include('config.php');
		$check_q = "select * from comment where commentId='$_GET[commentId]'";
		$contentOwner_q = "select * from content where contentId='$_GET[image]'";
		$checkCommentThumbs_q = "select * from commentconfirm where commentId='$_GET[commentId]'";

		$contentOwner_res = mysql_query($contentOwner_q);
		$contentOwnerRow = mysql_fetch_array($contentOwner_res);

		$check_res = mysql_query($check_q);
		$check = mysql_fetch_array($check_res);

		$checkCommentConfirm_res = mysql_query($checkCommentThumbs_q);

		// check if scrap to be deleted belongs to logged in user
		// OR is posted by logged in user

		if($check['commentor']==$_SESSION['uid'] || $contentOwnerRow['ownedBy']==$_SESSION['uid'])
		{
			if (mysql_num_rows($checkCommentConfirm_res)>=1) {
				mysql_query("delete from commentconfirm where commentId='$_GET[commentId]'");
			}
		}
		mysql_query("delete from comment where commentId='$_GET[commentId]'");
		$redir = $_SERVER[HTTP_REFERER];
		header("Location:$redir");

	}


}

?>