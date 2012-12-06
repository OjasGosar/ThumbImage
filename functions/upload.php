<?

// ========================================== Uploading ===============================

	function upload($currFile)
	{
		// --- generating filename based on gallery name ------------
		
		$newfilename = rand()."-".$_FILES["$currFile"]["name"];		
		
		if($_FILES["$currFile"]["size"]<1572864)
		{
			$path = "./uploads/".$newfilename;
			// Save temporary file to uploads folder
			move_uploaded_file($_FILES["$currFile"]["tmp_name"],$path);	
			$dt = date("Y-m-d G:i:s");
			
			// After uploading, use the uploaded file to generate a thumbnail		
			$thumbFile = "./thumbs/".$newfilename;
			if(createthumb($path,$thumbFile,120,120))
			{			
				// Execute query to make entry of photo and thumb in DB
				
$upload_q = "insert into images(date,owner,loc) values('$dt','$_SESSION[uid]','$newfilename')";
				mysql_query($upload_q);
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




?>
