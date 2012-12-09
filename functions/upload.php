<?php

// ========================================== Uploading ===============================

function upload($currFile, $currTitle)
{
	// --- generating filename based on gallery name ------------
	//echo $currFile;
	//echo $currTitle;
	//echo $_POST[$currTitle];
	$stypes = explode("/", $_FILES[$currFile]['type']);
	$stypes = $stypes[count($stypes)-1];
	//echo $stypes;
	$newfilename = rand()."-".$_FILES[$currFile]["name"];
	if($_FILES[$currFile]["size"]<5242880)
	{
		$path = "./uploads/".$newfilename;
		// Save temporary file to uploads folder
		move_uploaded_file($_FILES[$currFile]["tmp_name"],$path);
		//$dt = date("Y-m-d G:i:s");
			
		// After uploading, use the uploaded file to generate a thumbnail
		$thumbFile = "./thumbs/".$newfilename;
		if(make_thumb($path,$thumbFile,120,$stypes))
		{
			// Execute query to make entry of photo and thumb in DB
			//echo "Yeah it called TRUE";
			$upload_q = "insert into content(ownedBy,content,title) values('$_SESSION[uid]','$newfilename','$_POST[$currTitle]')";
			mysql_query($upload_q);
			if($_GET['files'] == 1) {
				echo "<center><span style=\"font-size:12px;font-weight:bold;font-family:Verdana;\">... Content Successfully Uploaded ...</span></center>";
			}
		}
		else
			return 0;
	}
	else
	{
		echo "<br>File Exceeded MAX SIZE LIMIT";
	}

}

// ===================== Thumbnail Generation ==========================================

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
			//echo "I was executed JPEG";
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
	$desired_height = 120;//floor($height * ($desired_width / $width));

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
	return true;

}


/*
 function createthumb($original,$thumb,$new_w,$new_h)
 {
require_once('./includes/phpthumb.class.php');

$phpThumb = new phpThumb();
$phpThumb->resetObject();
$capture_raw_data = false;
$phpThumb->setSourceFilename($original);
$phpThumb->setParameter('w',$new_w);
$phpThumb->setParameter('h',$new_h);

if ($phpThumb->GenerateThumbnail())  // this line is VERY important, do not remove it!
{

$output_size_x = ImageSX($phpThumb->gdimg_output);
$output_size_y = ImageSY($phpThumb->gdimg_output);

if ($thumb)
{
$phpThumb->RenderToFile($thumb);
return 1;
}
else
{
// do something with debug/error messages
echo 'Failed (size='.$thumbnail_width.'):<pre>'.implode("\n\n", $phpThumb->debugmessages).'</pre>';
return 0;
}

}
else
{
// do something with debug/error messages
echo '<div style="background-color:#FFEEDD; font-weight: bold; padding: 10px;">'.$phpThumb->fatalerror.'</div>';
echo '<form><textarea rows="10" cols="60" wrap="off">'.htmlentities(implode("\n* ", $phpThumb->debugmessages)).'</textarea></form><hr>';
}

}
*/



?>
