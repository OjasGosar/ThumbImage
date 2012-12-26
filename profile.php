<?php	

// PHP Start ==========================

session_start();



if (isset($_GET['uid']) || isset($_POST['quickmsg']))
{
	include('config.php');

	$retrieve_profile = "select * from user where uId=$_GET[uid]";
	$retrieve_profile_res = mysql_query($retrieve_profile);

	$pics = mysql_query("select * from content where ownedBy='$_GET[uid]' order by postedTime DESC limit 0,6");

	$ret_dispname = mysql_query("select username from user where uid='$_GET[uid]'");
	$disp = mysql_fetch_array($ret_dispname);
	$userfriends_q = "select uId, username, userscore
	from user
	where uId in (
	select friend
	from (SELECT first_uid as user, second_uid as friend from friends where first_uid='$_GET[uid]' and approved=1
	union
	SELECT second_uid as user, first_uid  as friend  from friends where second_uid='$_GET[uid]' and approved=1) user_friends)";

	$userfriends_res = mysql_query($userfriends_q);
	$isFriend = false;
	include('header.php');

	// PHP Ends here =============================

	?>
<head>
<link rel="stylesheet" href="./css/global.css">
<title><?php echo $disp['username'] ?>'s Profile</title>
<script language="javascript">

function addFriend()
{
	if(window.confirm("Are you sure you want to add <?php echo $disp['username']; ?> to your Friends List ?"))
	{
		//window.location='./addfriend.php?uid=<?php echo $_GET['uid']; ?>';
	}

}
	function addfriend()
	{
	if(window.confirm("Are you sure you want to add <?php echo $disp['username'] ?> as friend ?")==1)
	{
		window.location.href='addfriend.php?uid=<?php echo $_GET['uid']; ?>';		
	}
	}
function chkfilled(textfld)
{

	if(textfld.value=="Enter your message here")
	{
		textfld.value="";
	}
}
function chkempty(textfld)
{

	if(textfld.value=="")
	{
		textfld.value="Enter your message here";
	}
}

function changecolor(navelement)
{	
	navelement.style.backgroundColor="#F2F2F2";
	navelement.style.color="black";
	navelement.style.border="2px #3B5998 solid";
}
function origcolor(navelement)
{
	navelement.style.backgroundColor="#3B5998";
	navelement.style.color="white";
	navelement.style.border="2px #F2F2F2 solid";
}




</script>

<style type="text/css">
.lastmsgs {
	background-color: #DFE4EE;
	padding: 5px;
	border: 2px white solid;
	font-family: Verdana;
	font-size: 12px;
}

a {
	color: blue;
}

a:hover {
	color: red;
}

.textfield {
	border: 2px #C6CFE1 outset;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	width: 600px;
}

.fielddesc {
	padding: 2px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}

.fieldsection {
	font-size: 10px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}

.useroptions {
	background-color: #3B5998;
	height: 40px;
	color: white;
	width: 270px;
	border: 2px #F2F2F2 solid;
	padding-top: 8px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
}

#rateStatus {
	float: left;
	clear: both;
	width: 100%;
	height: 20px;
}

#rateMe {
	float: left;
	clear: both;
	width: 100%;
	height: auto;
	padding: 0px;
	margin: 0px;
}

#rateMe li {
	float: left;
	list-style: none;
}

#rateMe li a:hover,#rateMe .on {
	background: url(./images/star_on.gif) no-repeat;
}

#rateMe a {
	float: left;
	background: url(./images/star_off.gif) no-repeat;
	width: 12px;
	height: 12px;
}

#ratingSaved {
	display: none;
}

.saved {
	color: red;
}
</style>
</head>

<body>



	<table border=0 width=100% cellpadding="5" cellspacing="0">
		<tr>
			<td width="15%" align="center"
				style="background-color: #F2F2F2; padding-top: 0px; padding-left: 5px; border-left: 1px #CCCCCC solid; border-bottom: 1px #CCCCCC solid; border-top: 1px #CCCCCC solid;">
				<?php
				// Display Photo and displayname below it
				$profile = mysql_fetch_array($retrieve_profile_res);
				echo "<img src=\"$profile[profilePic]\" height=128 width=128><br><b>$disp[username]</b>";
				?>
			
			<td width="15%"
				style="background-color: #F2F2F2; padding-top: 30px; padding-left: 8px; border-left: 1px #CCCCCC solid; border-bottom: 1px #CCCCCC solid; border-top: 1px #CCCCCC solid;"
				valign="top" width="170px"><?php
				echo "<span style=\"font-family:Verdana, Arial, Helvetica, sans-serif;font-size:16px;\">".$profile['name']."</span><br>";
				//echo "<span style=\"font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;\">".$profile[gender];

				if($profile['dob']!="")
				{
					$age = explode("-",$profile['dob']);
					$age_in_years = date("Y")-$age[0];
					echo " (".$age_in_years." years)<br>";
				}
				else
					echo "<br>";

				if($profile['city']!=""){
				echo $profile['city'];
				}
				if($profile['country']!=""){
				echo ", ".$profile['country'];
				}
				echo "</span>";
				?>
			</td>
			<td valign="top" colspan=5
				style="background-color: #F2F2F2; padding-top: 0px; padding-left: 8px; padding-right: 8px; border-left: 1px #CCCCCC solid; border-bottom: 1px #CCCCCC solid; border-top: 1px #CCCCCC solid; border-right: 1px #CCCCCC solid;">
				<?php
				echo "<table border=0 cellspacing=8px cellpadding=8px>";
				echo "<tr><th align=center colspan=5>Recently Photo's uploaded by \"$disp[username]\"<tr>";
				//echo round(4.2);
				while($row=mysql_fetch_array($pics))
				{
					echo "<td>";
					echo "<table border=0 cellspacing=0px cellpadding=0px>";
					echo "<tr>";
					echo "<td style='' align=center><a href='./view.php?image=$row[contentId]' style= \"color: #000000;\"><b><u>$row[title] </b></u></a></td>";
					echo "</tr><tr>";
					echo "<td style='' align=center><a href='./view.php?image=$row[contentId]'><img src='./thumbs/$row[content]' border=0></a></td>";
					echo "</tr><tr>";
					echo "<td align=\"center\">";
					$rate = round($row['rating']);
					for ($i=0;$i<$rate;$i++) {
					?> <img src="./images/star-black16.png"> <?php
					}
					for ($i=0;$i<5-$rate;$i++) {
					?> <img src="./images/star-white16.png"> <?php
					}
					?> <!-- <td align="center">
				<div id="rateMe" title="Rating..." align="center">
					<img src="./images/star_on.gif"> <img src="./images/star_off.gif"> <img
						src="./images/star_off.gif"> <img src="./images/star_off.gif"> -->
				<!-- <a id="_1" title="ehh..." class="on" ></a>
					<a id="_2" title="Not Bad" class="on" ></a>
					<a id="_3" title="Pretty Good" class="on" ></a>
					<a id="_4" title="Out Standing" class="on" ></a>
					<a id="_5" title="Freakin' Awesome!" class="on"></a>
 --> <?php
 echo "</td>";
 echo "</tr>";
 echo "</table>";




 //echo "<td style='background-color:#ffffff;height:100px;width:100px' align=center><a href='./view.php?image=$row[contentId]' style= \"color: #000000;\"><b><u>$row[title]</b></u><img src='./thumbs/$row[content]' border=0></a></td>";
				}
				echo "</table>";
				echo "<center><span class=vsmalltext><a href='./showgallery.php?uid=$_GET[uid]'>View all</a></center>";
				?>
			</td>
		
		
		<tr>

			<td colspan=2 valign="top">

				<table border="0" cellpadding="0" cellspacing="0" width="270px">
					<tr>
						<td class="titlebar" id=personal_details>Personal Details
					
					
					<tr>
						<td class="boxbody"><?php
						echo "<table border=0 cellpadding=0 cellspacing=7>";
						//if($profile[]!=""){echo "<tr><td> :<td class=fielddesc> $profile[]</tr>";}

						if($profile['name']!=""){
echo "<tr><td class=fieldsection>Name<td class=fielddesc> $profile[name]&nbsp;</tr>";
}
if($profile['abtMe']!=""){
echo "<tr><td class=fieldsection>About Me<td class=fielddesc> $profile[abtMe]</tr>";
}
//if($profile[likes]!=""){echo "<tr><td class=fieldsection>Likes<td class=fielddesc> $profile[likes]</tr>";}
//if($profile[dislikes]!=""){echo "<tr><td class=fieldsection>Dislikes<td class=fielddesc> $profile[dislikes]</tr>";}
//if($profile[movies]!=""){echo "<tr><td class=fieldsection>Movies<td class=fielddesc> $profile[movies]</tr>";}
//if($profile[music]!=""){echo "<tr><td class=fieldsection>Music<td class=fielddesc> $profile[music]</tr>";}
//if($profile[books]!=""){echo "<tr><td class=fieldsection>Books<td class=fielddesc> $profile[books]</tr>";}


echo "</table>";
?>
				
				</table> <br> <!-- <table border=0 cellpadding="0" cellspacing="0" width="270px"> -->

				<!-- <tr><td class="titlebar">Professional Details --> <!-- <tr><td class="boxbody"> -->
				<?php /* echo "<table border=0 cellpadding=0 cellspacing=7>";
//if($profile[]!=""){echo "<tr><td> :<td class=fielddesc>
				$profile[]</tr>";} if($profile[education]!=""){echo "<tr><td
				class=fieldsection>Education<td class=fielddesc>
$profile[education]&nbsp;</tr>";} if($profile[college]!=""){echo
				"<tr><td class=fieldsection>College<td class=fielddesc>
$profile[college]</tr>";} if($profile[occupation]!=""){echo "<tr><td
				class=fieldsection>Occupation<td class=fielddesc>
				$profile[occupation]</tr>";} echo "</table>"; */ ?>
	
	</table>

	<td width="50%" valign="top">
		<!-- Start comments system  --> <?php include('comments.php'); ?> <!-- end comments system  -->
		<br>
	
	<td valign="top" align="center" width="30%">

		<table border=0 cellpadding="0" cellspacing="0" width="270px">
			<tr>
				<td class="titlebar" id=personal_details><?php echo $disp['username']; ?>'s
					Friends
			
			
			<tr>
				<td class="boxbody"><?php

				/*
				 $friendsarr = explode("-",$disp[friends]);
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
						if(isset($_SESSION['uid'])) {
						if($row['uId'] == $_SESSION['uid']){
							//echo "$row[uId] == $_SESSION[uid]";
							$isFriend = true;

						}
						}
						echo "<tr><td><a href=profile.php?uid=$row[uId]>$row[username]</a></td><td>---------------------</td><td>$row[userscore]</td></tr>";
					}
					echo "</table>";
				}

				?>
		
		</table> <br> <?php 
		if(isset($_SESSION['uid'])) {
		if($_GET['uid'] != $_SESSION['uid']) {
			if($isFriend == false) {
				echo "<div onMouseOver=changecolor(this) class=useroptions id=xyz
		onMouseOut=origcolor(this) onClick=addFriend()>Add To Friends List</div>";
			}
			}
			/*
			 echo "<div onMouseOver=changecolor(this) class=useroptions id=xyz
			onMouseOut=origcolor(this)>Invite To Chat</div>";
		 */
		}
		?>




		</table>
	
	</tr>


	<?php
}
else
{

	header('Location:home.php');

}


?>