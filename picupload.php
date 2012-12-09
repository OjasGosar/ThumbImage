<?php
session_start();
include ('config.php');

if(isset($_SESSION['uid']))
{
	?>

<head>
<link rel="stylesheet" href="./css/global.css">

<style type="text/css">
th {
	font-family: verdana;
}

.uploadedMsg {
	font-weight: bold;
}

.uploadControl {
	padding: 2px;
}

#uploadErr {
	height: 20px;
	font-weight: bold;
	padding: 5px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border-bottom: 1px #EBD085 solid;
	border-top: 1px #EBD085 solid;;
	vertical-align: middle;
	background-color: #FFF2CE;
	text-align: center;
	display: none;
}

#uploadWarning {
	font-weight: bold;
	padding: 5px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border-bottom: 1px #EBD085 solid;
	border-top: 1px #EBD085 solid;;
	background-color: #FFF2CE;
}

.uploadMsg {
	padding-bottom: 10px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
}

.textareasmall {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
</style>
<script language="javascript" src="./ref.js"></script>
<script language="javascript" src="./uploading.js"></script>

<script language="javascript">
function tabHoverOn(tab)
{
	tab.style.class="contentTabHover";
}
function tabHoverOut(tab)
{
	tab.style.class="contentTabInactive";
}

</script>

</head>

<?php
// $_GET[files] tells how many files will be uploaded to the server
// this variable is set via javascript

if(isset($_GET['files']))
{
	include('./functions/upload.php');

	// --- get gallery details ------------------------------
	//echo $_GET['files'];
	$i=1;
	for($i=1;$i<=$_GET['files'];$i++)
	{
		$varName = "upload".$i;
		$titleName = "title".$i;
		$temp=upload($varName, $titleName);
	}



}

?>


<body>
	<div class=pageHeader>Upload Files</div>


	<center>


		<Br>

		<form method="POST" enctype="multipart/form-data" name="uploadForm"
			action="picupload.php">

			<div class=uploadForm>

				<div class="uploadMsg">Select the files to be uploaded below :</div>

				<div id="fileup">
					<table id="fileupTable"border=0 cellpadding=0 cellspacing=0 width=100%>
						<tr>
							<td>
								<div class=uploadControl>
									<input type="file" name="upload1"
										onFocus="document.getElementById('uploadbutton').disabled=false"
										onBlur="checkType(this)" />
								</div>
							</td>
							<td>Title:</td>
							<td><input type="text" name="title1" class="loginfields" />
							</td>
						</tr>
					</table>
				</div>
				<div>
					<a href=# onClick=createUploadControl() class="vsmalltext">Add More
						Files</a>
				</div>

				<br /> <br /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
				&nbsp; &nbsp; <input type="button" value="Upload File"
					name="uploadOK" onClick="this.disabled=true;validateUploadForm()"
					id="uploadbutton" /> <br> <Br>

				<div id="uploadErr"></div>
	</div>
	</form>
	</center>
	<br>

	</form>

	</div>


	<?php

}


else
{
	header("Location:login.php");
}
?>