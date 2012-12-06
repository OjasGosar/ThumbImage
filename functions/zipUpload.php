<?php
include('./config.php');
//============= Upload zip file to server ============

function uploadZipFile($name,$tmpname)
{
	$path = "./zips/".md5(rand().$name).".zip";
	if(move_uploaded_file($tmpname,$path))
	{
		return $path; // return zip path
	}
	else
		return 0;
}

//========= Open uploaded zip and extract to temporary folder
function extractZip($file)
{
	$zip = new ZipArchive;
    $res = $zip->open($file);
	
	// create new directory
	$dirPath="./temp/".md5(rand());
	mkdir($dirPath);
	 
	// extract to this dir
    if ($res === TRUE) {
        $zip->extractTo($dirPath);
        $zip->close();
	} else {
        echo 'Extraction Failed !!!';
    }
	return $dirPath;
}

function startProcessing($dirPath,$gallery,$newzip)
{
	// populate file array
	$dir_handle = opendir($dirPath);
	
	while ($file = readdir($dir_handle)) 
	{
		if($file!="." && $file!="..")
		{	
			$newfilename = $gallery."-".rand()."-".preg_replace("/[^a-zA-Z0-9\.]/","-",$file);
			
			$src = $dirPath."/".$file;
			$thumbFile = "./thumbs/".$newfilename;
			$imagePath = "./uploads/".$newfilename;
			
			$dt = date("Y-m-d G:i:s");	
			
			if(createthumb($src,$thumbFile,160,160))
			{			
				// Execute query to make entry of photo and thumb in DB
				$upload_q = "insert into images(gallery,date,owner,loc) values('$_POST[targetgallery]','$dt','$_SESSION[uid]','$newfilename')";
				if(mysql_query($upload_q))
				{
					rename($src,$imagePath); 	
					$uploadedids[] = mysql_insert_id();
				}
				else
					echo "<br><b>Error inserting image into DB</b>";
			}
		}
	}
	//closing the directory
	closedir($dir_handle);
	 
	// delete dir and zipfile
	unlink($newzip);
	rmdir($dirPath);
	
	return $uploadedids;
}
	
// ===================== Thumbnail Generation ==========================================

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
			return 0;
		}
	
	}



?> 