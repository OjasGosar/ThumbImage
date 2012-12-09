<?php
session_start();

function make_thumb($src, $dest, $desired_width, $stype) {

	/* read the source image */
	switch($stype) {
		case 'gif':
			$source_image = imagecreatefromgif($src);
			break;
		case 'png':
			$source_image = imagecreatefrompng($src);
			break;
		case 'jpeg':
			$source_image = imagecreatefromjpeg($src);
			break;
		case 'jpg':
			$source_image = imagecreatefromjpeg($src);
			//echo "I was executed JPG";
			break;
	}

	//$source_image = imagecreatefromjpeg($src);
	//$size = getimagesize($src);
	$width = imagesx($source_image);
	$height = imagesy($source_image);

	/* find the "desired height" of this thumbnail, relative to the desired width  */
	$desired_height = floor($height * ($desired_width / $width));

	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);

	/* copy source image at a resized size */
	imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

	/* create the physical thumbnail image to its destination */

	switch($stype) {
		case 'gif':
			imagegif($virtual_image, $dest,100);
			break;
		case 'png':
			imagepng($virtual_image, $dest,100);
			break;
		case 'jpeg':
			imagejpeg($virtual_image, $dest,100);
			break;
		case 'jpg':
			imagejpeg($virtual_image, $dest,100);
			break;
	}

}



if(isset($_SESSION['uid']))
{

	include('config.php');
	$checkpic = mysql_query("select profilePic from user where uid='$_SESSION[uid]'");
	$check = mysql_fetch_array($checkpic);

	//$desired_width = 128;
	// Generate MD5 hash of a pseudorandom number and add to filename
	$md5name = md5($_SESSION['uid']);
	$temp_filename = $_FILES["file"]["tmp_name"];
	$filename = $_FILES["file"]["name"];

	if(stripos($filename, ".jpg") != false) {
		$filename = str_ireplace(".jpg", ".jpeg", $filename);
	}

	if(stripos($temp_filename, ".jpg") != false) {
		$temp_filename = str_ireplace(".jpg", ".jpeg", $temp_filename);
	}

	$path = "./avatars/".$md5name."".$filename;
	$thumbDestPath = "./avatars_thumbnail";
	$pathThumb = "./avatars_thumbnail/".$md5name."".$filename;

	$stypes = explode(".", $path);
	$stypes = $stypes[count($stypes)-1];
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
	move_uploaded_file($temp_filename,$path);

	if(mysql_query("update user set profilePic='$path' where uid='$_SESSION[uid]'"))
	{
		//header('Location:home.php');
	}
	else
	{
		echo "Error in uploading Photo";
	}

	make_thumb($path, $pathThumb, 128, $stypes);

	if(mysql_query("update user set thumbnail='$pathThumb' where uId='$_SESSION[uid]'"))
	{
		header('Location:home.php');
	}
	else
	{
		echo "Error in uploading Photo";
	}


}
?>