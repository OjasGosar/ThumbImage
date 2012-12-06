<?php
session_start();
include('config.php');

$image=mysql_fetch_array(mysql_query("select * from images where iuid='$_GET[image]'"));
include('./header.php');
?>
<link rel=stylesheet href=css/global.cs />
<style type=text/css>
#mainphoto
{
	cursor:pointer;
}
</style>
<script language="javascript" src="./resize.js"></script>
<script language="javascript" src="./ref.js"></script>
<body onLoad="init()">


    <!-- Main Photo --><center>
    <a href='javascript:history.back()' class='vsmalltext'>Back</a><br />
	<div id=sizeChanger onClick=toggleSize()></div>
    <div id=imageContainer>
     <!-- Main Photo -->

<?

echo "<img src='./uploads/$image[loc]' id=mainphoto onClick='toggleSizeImg()'>";

?></center>
</div>
