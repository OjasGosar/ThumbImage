<?php
session_start();
include ('config.php');
include('header.php');
// ================ retreive images from gallery ==================
?>

<head>
<link rel=stylesheet href="./css/global.css">
<style type="text/css">
.seperator {
	border-left: 2px #C6CFE1 solid;
	text-align: center;
}

a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #0000FF;
}

a:hover {
	color: #FF3333;
}

td.imageCell {
	height: 130px;
	width: 130px;
	border: 2px #C6CFE1 solid;
	text-align: center;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}

.galleryInfo {
	position: absolute;
	right: 5px;
	padding: 10px;
	top: 15px;
	background-color: #FFF2CE;
	font-family: Verdana;
	font-size: 12px;
	border: 1px #EBD085 solid;
	text-align: left;
	width: 250px;
	height: 35px;
}

.button {
	border: 1px #DFE4EE outset;
	height: 25px;
}

#siteselector {
	display: none;
}
</style>
<script>
function populateCode($this, $contentId)
  {
  document.getElementById($this).checked=true
  }
function uncheck()
  {
  document.getElementById("check1").checked=false
  }
</script>
</head>

<body>
	<?php
	if(isset($_POST['deletePic'])) {
		mysql_query("delete from content where contentId='$_POST[deletePic]'");
	}
	if (isset($_GET['uid']) || isset($_SESSION['guestid'])) {
		if (isset($_SESSION['guestid'])){
		$ret_images = "select * from content where 1 order by postedTime DESC";
		} else {
		$ret_images = "select * from content where ownedBy='$_GET[uid]' order by postedTime DESC";
		}
		$images = mysql_query($ret_images);
		echo "<table border=0 cellspacing=10px>";

		$break=0;
		while($row=mysql_fetch_array($images))
		{
			if($break%9==0 && $break!=0)
			{
				echo "<tr>";
			}

			echo "<td class=imageCell><a href=./view.php?image=$row[contentId]><img src='./thumbs/$row[content]' border=0></a>";
			echo "<br>";
			$rate = round($row['rating']);
			for ($i=0;$i<$rate;$i++) {
					?>
	<img src="./images/star-black16.png">
	<?php
					}
					for ($i=0;$i<5-$rate;$i++) {
					?>
	<img src="./images/star-white16.png">
	<?php
					}
					echo "<br>";
					$numComments = mysql_query("select count(commentId) as ccount from comment where contentId = $row[contentId]");
					$commentCounts = mysql_fetch_array($numComments);
					$numTags = mysql_query("select count(tagId) as tcount from tag where contentId = $row[contentId]");
					$tagCounts = mysql_fetch_array($numTags);
					echo "<span class=commenttagbar>$commentCounts[ccount] Comment & $tagCounts[tcount] Tag</span>";
					if (isset($_SESSION['uid'])) {
					if($_SESSION['uid']==$_GET['uid']/*  || $_SESSION[uid]==$admin */) // ======== if user is gallery admin ======
					{
						echo "<br><form method=POST
						action=showgallery.php?uid=$_GET[uid]>
						<input type=hidden name=deletePic
						value=$row[contentId]><input type=submit value=\"Delete\">
						</form>";
					}
					}
					echo "</td>";
					$break=$break+1;
		}

		echo "</form></table>";
	}

	

	// ========== if no images are present ===========

	?>