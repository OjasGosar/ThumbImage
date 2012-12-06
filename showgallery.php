<?php
session_start();
include ('config.php');
include('header.php');
// ================ retreive images from gallery ==================

$ret_images = "select * from images where owner='$_GET[uid]'";
$images = mysql_query($ret_images);
?>

<head>
<link rel=stylesheet href="./css/global.css">
<style type="text/css">

.seperator
{
	border-left:2px #C6CFE1 solid;
	text-align:center;
}

a
{
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
color:#0000FF;
}
a:hover
{
	color:#FF3333;
}

td.imageCell
{
	height:130px;
	width:130px;
	border:2px #C6CFE1 solid;
	text-align:center;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:12px;
}
.galleryInfo
{
	position:absolute;
	right:5px;
	padding:10px;
	top:15px;
	background-color:#FFF2CE;
	font-family:Verdana;
	font-size:12px;
	border:1px #EBD085 solid;
	text-align:left;
	width:250px;
	height:35px;
}

.button
{
	border:1px #DFE4EE outset;
	height:25px;
}
#siteselector
{
	display:none;

}
</style>

</head>

<body>
<?
	echo "<table border=0 cellspacing=10px>";

	$break=0;
	while($row=mysql_fetch_array($images))
	{
		if($break%5==0 && $break!=0)
		{
			echo "<tr>";
		}
		
		echo "<td class=imageCell><a href=./view.php?image=$row[iuid] target=_blank><img src='./thumbs/$row[loc]' border=0>";
		
		if($_SESSION[uid]==$galleryInfo[owner] || $_SESSION[uid]==$admin) // ======== if user is gallery admin ======
		{
			echo "<br>Select : <input type=checkbox onClick=populateCode(this,$row[iuid]) value=$row[iuid]><br><a href=# onClick=deletePic($row[iuid])>Delete</a>";
		}
		
		echo "</td>";
		$break=$break+1;
	}

	echo "</form></table>";	
	
// ========== if no images are present =========== 

?>
