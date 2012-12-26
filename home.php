<?php
session_start();

if(isset($_SESSION['uid']))
//if(1)
{
	include ('config.php');

	// query for recent msgs

	$scrap_q = "select * from content where rating>4 order by rating desc";
	$scrap_res = mysql_query($scrap_q);

	$profile = mysql_fetch_array(mysql_query("select thumbnail from user where uid='$_SESSION[uid]'"));

	$user = mysql_fetch_array(mysql_query("select * from user where uid='$_SESSION[uid]'"));
	/*
	 $userfriends_q = "SELECT first_uid as user, second_uid as friend from friends where first_uid='.$_SESSION[uid].' and approved=1
	union
	SELECT second_uid as user, first_uid  as friend  from friends where second_uid='.$_SESSION[uid].' and approved=1";
	$userfriends_res = mysql_query($userfriends_q);
	*/
	$userfriends_q = "select uId, userName, userscore
	from user
	where uId in (
	select friend
	from (SELECT first_uid as user, second_uid as friend from friends where first_uid='$_SESSION[uid]' and approved=1
	union
	SELECT second_uid as user, first_uid  as friend  from friends where second_uid='$_SESSION[uid]' and approved=1) user_friends)";

	$userfriends_res = mysql_query($userfriends_q);
	?>
<head>

<title><?php echo $_SESSION['username']?>'s Dashboard</title>
<link rel=stylesheet href=./css/global.css />
<link rel="stylesheet" href="./css/view.css">
<style type="text/css">
.photo {
	border: 2px black outset;
	height: 130px;
	width: 130px;
	padding: 2px;
}

a.nav {
	font-family: Arial;
	font-size: 15px;
	text-decoration: none;
	color: #605998;
}

a {
	font-family: Arial;
	font-size: 12px;
	text-decoration: none;
	color: #605998;
}

.dispname {
	background-color: #6D84B4;
	border: 2px #3B5998 solid;
	padding: 5px;
	font-size: 18px;
	color: white;
}

.rightpane {
	border-left: #D8DFD0 1px solid;
}

.leftpane {
	border-right: #D8DFD0 1px solid;
}

.lastmsgs {
	background-color: #E5E5E5;
	padding: 5px;
	border: 2px white solid;
	font-family: Verdana;
	font-size: 12px;
}

.popup {
	position: absolute;
	border: 2px black inset;
	display: none;
	height: 250px;
	width: 350px;
	background-color: #D8DFEA;
}

.friendcell {
	background-color: #E5E5E5;
	border: 2px white solid;
	height: 64px;
	width: 64px;
	text-align: center;
}

.leftnav {
	border: 6px white solid;
	border-top: 2px #D8DFEA solid;
	background-color: white;
	height: 40px;
	font-size: 16px;
	font-family: Georgia, "Times New Roman", Times, serif;
}
</style>
<script language="javascript" src="ref.js"></script>
<script language="javascript" src="ajax.js"></script>

<script language="javascript">
function changecolor(navelement)
{	
	navelement.style.backgroundColor="#3B5998";
	navelement.style.borderTop="2px #3B5998 solid";
	navelement.style.borderRight="6px #3B5998 solid";
	navelement.style.borderBottom="6px #3B5998 solid";
	navelement.style.borderLeft="6px #3B5998 solid";
	navelement.style.color="white";
}
function origcolor(navelement)
{
	navelement.style.backgroundColor="white";
	navelement.style.borderTop="2px #D8DFEA solid";
	navelement.style.borderRight="6px white solid";
	navelement.style.borderBottom="6px white solid";
	navelement.style.borderLeft="6px white solid";
	navelement.style.color="black";
}

function changeDispName(oldname)
{
	$("dispname").innerHTML="<input type=text name=dispname value="+oldname+" id=newName size=12 style=\"background-color:#6D84B4;color:white;border:2px #3B5998 dashed\"><input type=button onClick=updateDispName($(\"newName\").value) value=\"Change\">";
	$("edit").style.display="none";
}

function changePhoto()
{

$("photoPopup").style.display="block";
$("photoPopup").style.left="150px";
}

function destroy()
{
$("photoPopup").style.display="none";
}

function loadframe(page)
{
$("centermain").innerHTML="<iframe src="+page+" height=390 width=650 frameborder=0 scrolling=no></iframe>";
}
</script>

</head>
<?php

if(isset($_GET['do'])){
if($_GET['do']=="editprofile")
{
	echo "<body onLoad=loadframe(\"editprofile.php\")>";
}
elseif($_GET['do']=="settings")
{
	echo "<body onLoad=loadframe(\"settings.php\")>";
}
else
{
	echo "<body>";
}
}
include('header.php');
?>






<table border=0 cellpadding=10 cellspacing="0" width="100%">
	<tr>
		<!-- Left pane -->
		<td align="center">

			<div class=photo>
				<img src="<?php echo $profile['thumbnail'] ?>"
					alt="<?php echo $_SESSION['username']; ?>'s Photo" width=128
					height=128 />
			</div>
			<div onClick=changePhoto() style="font-size: 10px; color: blue">Change
				Photo</div>

			<div id=photoPopup class=popup>
				<form enctype="multipart/form-data" method="POST"
					action="upload.php">
					<br>Upload Photo : <input type=file name=file><br> <Br> <input
						type=submit value="Upload">&nbsp;&nbsp;&nbsp;<input type=button
						onClick=destroy() value="Close">
				</form>
			</div> <!-- Center pane --> <span> </br>Search Profiles
		</span>
			<div
				style="text-align: center; border-bottom: 1px #D8DFD0 solid; padding-top: 0px;">
			</div>
			<form method=POST action=searchprofile.php>
				<br>Search : <input type=text name=simplesearch>&nbsp;<input
					type=submit value="Search">
			</form>
		
		<td align="left" valign=top><br> <span class=dispname>Hello <span
				id=dispname><?php echo $user['userName'] ?> </span>
		</span> <span id=edit><a href=#
				style="text-decoration: none; font-size: 9px"
				onClick=changeDispName($("dispname").innerHTML)>Edit</a> </span> <br>
			<br>  <!-- Right pane -->
		
		<td class=rightpane rowspan=2 valign="top" width=25%>
			<div
				style="text-align: center; border-bottom: 1px #D8DFD0 solid; padding-top: 25px;">Friends
				List</div> <?php

				// creating the dynamic query from the exploded friends array
				/*
				 $friendsarr = explode("-",$user[friends]);
				$friends = "";
				foreach($friendsarr as $val)
				{
				if($val==0)
					$friends = $friends .$val." or";
				else
					$friends = $friends . " uid=".$val." or";
				}
				$friends = substr($friends,0,strlen($friends)-3);

				*/



				if(mysql_num_rows($userfriends_res) == 0)
				{
					echo "<span style='font-size:11px'><br>You have No Friends Added yet</span>";
				}
				else
				{
					/*
					 $friendslist_q = "select username,uid from user where uid=".$friends;
					$friendslist_res = mysql_query($friendslist_q);
					*/
					echo "<br><BR><table border=0 cellpadding=0 cellspacing=0 width=100%>";

					echo "<tr><td></td><td></td><td><B><U>Userscore</U></B></td></tr>";
					while($row=mysql_fetch_array($userfriends_res))
					{
						echo "<tr><td><a href=profile.php?uid=$row[uId]>$row[userName]</a></td><td>---------------------</td><td>$row[userscore]</td></tr>";
					}
					echo "</table>";
				}

				?>
			<div
				style="text-align: center; border-bottom: 1px #D8DFD0 solid; padding-top: 50px;">
			</div>
	
	
	<tr>



		<td width=18% class=leftpane rowspan="2" valign="top">

			<div onMouseOver=changecolor(this) class=leftnav id=xyz
				onMouseOut=origcolor(this) onClick=loadframe("editprofile.php")>&nbsp;
				Edit Profile</div>
			<div onMouseOver=changecolor(this) class=leftnav id=xyz
				onMouseOut=origcolor(this) onClick=loadframe("picupload.php")>&nbsp;
				Upload Photos</div>
			<div onMouseOver=changecolor(this) class=leftnav id=xyz
				onMouseOut=origcolor(this) onClick=loadframe("settings.php")>&nbsp;
				Account Settings</div>
			<div onMouseOver=changecolor(this) class=leftnav id=xyz
				onMouseOut=origcolor(this)
				onClick="location.href='profile.php?uid=<?php echo $_SESSION['uid'] ?>'">&nbsp;View
				Profile</div>
			<div onMouseOver=changecolor(this) class=leftnav id=xyz
				onMouseOut=origcolor(this) onClick="location.href='logout.php'">&nbsp;
				Log Out</div>
		
		<td valign="top">
			<div class=centermain id=centermain align=center>
				<img src="./images/msg.gif" />&nbsp;<i><u>You have <?php echo mysql_num_rows($scrap_res); ?>
				Featured Items
		</u></i>
				


				<?php 

				echo "<table border=0 width=75%>";
				$count=0;
				while($row=mysql_fetch_array($scrap_res))
				{
					/* if($break%1==0 && $break!=0)
					 { */
					echo "<tr>";
					/* } */

					echo "<td class=imageCell><a href=./view.php?image=$row[contentId]><img src='./thumbs/$row[content]' border=0></a>";
					echo "<td>";
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
											echo "</td><td>";
											$numComments = mysql_query("select count(commentId) as ccount from comment where contentId = $row[contentId]");
											$commentCounts = mysql_fetch_array($numComments);
											$numTags = mysql_query("select count(tagId) as tcount from tag where contentId = $row[contentId]");
											$tagCounts = mysql_fetch_array($numTags);
											echo "<span class=commenttagbar>$commentCounts[ccount] Comment & $tagCounts[tcount] Tag</span>";


											echo "</td>";
											//$break=$break+1;
				}
				/* while($row = mysql_fetch_array($scrap_res))
				 {
				echo "<tr><td class=lastmsgs width=16% align=center>$row[username]</td><td class=lastmsgs><div style=\"font-size:10px;text-align:right\">$row[dt]</div>$row[msg]<div style=\"text-align:right\"><input type=button value=Delete style=\"font-size:9px;border:1px grey solid;color:black\" onClick=location.href=\"deletemsg.php?msg=$row[msg_uid]\"></div></td></tr>";
				$count++;
				if($count==5)
					break;
				} */
				if (mysql_num_rows($scrap_res)==0)
				{
					echo "<tr><td class=lastmsgs width=16%>-</td><td class=lastmsgs>You have no messages</td></tr>";
				}

				?>

</table>

</div>



</table>

<?php

}

else
{

	header('Location:index.php');

}

?>