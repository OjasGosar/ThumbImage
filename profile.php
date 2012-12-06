<?php	

// PHP Start ==========================

session_start();



if (isset($_GET[uid]) || isset($_POST[quickmsg]))
{
include('config.php');

$retrieve_profile = "select * from profiles where uid=$_GET[uid]";
$retrieve_profile_res = mysql_query($retrieve_profile);

$pics = mysql_query("select * from images where owner='$_SESSION[uid]' order by rand() limit 0,5");

$ret_dispname = mysql_query("select displayname,friends,status from user where uid='$_GET[uid]'");
$disp = mysql_fetch_array($ret_dispname);
include('header.php');

// PHP Ends here =============================

?><head>

<title><?php echo $disp[displayname] ?>'s Profile</title>
<script language="javascript">
function addfriend()
{
	if(window.confirm("Are you sure you want to add <?php echo $disp[displayname] ?> as friend ?")==1)
	{
		window.location.href='addfriend.php?uid=<?php echo $_GET[uid]; ?>';		
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

function addFriend()
{
	if(window.confirm("Are you sure you want to add <?php echo $disp[displayname]; ?> to your Friends List ?"))
	{
		window.location='./addfriend.php?uid=<?php echo $_GET[uid]; ?>';
	}

}


</script>

<style type="text/css">

.lastmsgs
{
background-color:#DFE4EE;
padding:5px;
border:2px white solid;
font-family:Verdana;
font-size:12px;
}
a
{
color:blue;
}
a:hover
{
color:red;
}
.textfield
{
border:2px #C6CFE1 outset;
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:12px;
width:600px;
}
.fielddesc
{

padding:2px;
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:10px;
}
.fieldsection
{
font-size:10px;
font-family:Verdana, Arial, Helvetica, sans-serif;
}
.useroptions
{
background-color:#3B5998;
height:40px;
color:white;
width:270px;
border:2px #F2F2F2 solid;
padding-top:8px;
font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:14px;
}
</style>
</head>

<body>



<table border=0 width=100% cellpadding="5" cellspacing="0">
<tr>
<td align="center">

<?php
// Display Photo and displayname below it
$profile = mysql_fetch_array($retrieve_profile_res);
echo "<img src=\"$profile[photo]\" height=128 width=128><br><b>$disp[displayname]</b>";
?>

<td style="padding-top:15px;padding-left:8px;border-left:1px #C6CFE1 solid;" valign="top" width="170px">

<?php
echo "<span style=\"font-family:Verdana, Arial, Helvetica, sans-serif;font-size:16px;\">".$profile[name]."</span><br>";
echo "<span style=\"font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;\">".$profile[gender];

if($profile[dob]!="yyyy-mm-dd")
{
$age = explode("-",$profile[dob]);
$age_in_years = date("Y")-$age[0];
echo " (".$age_in_years." years)<br>";
}
else
echo "<br>";

if($profile[city]!=""){ echo $profile[city];}
if($profile[country]!=""){ echo ", ".$profile[country];}
echo "</span>";
?>

<td style="padding-top:15px;padding-left:8px;border-left:1px #C6CFE1 solid;background-color:#e5e5e5" valign="top" colspan=5>
<?
echo "<table border=0 cellspacing=8px cellpadding=8px>";
echo "<tr><th align=center colspan=999>Images uploaded by $disp[displayname]<tr>";
while($row=mysql_fetch_array($pics))
{
	echo "<td style='background-color:#ffffff;height:100px;width:100px' align=center><a href='./view.php?image=$row[iuid]'><img src='./thumbs/$row[loc]' border=0></a></td>";
}
echo "</table>";
	echo "<center><span class=vsmalltext><a href='./showgallery.php?uid=$_GET[uid]'>View all</a></center>";
?>
<tr>	

<td colspan=2 valign="top">

<table border=0 cellpadding="0" cellspacing="0" width="270px">
<tr><td class="titlebar" id=personal_details>Personal Details
<tr><td class="boxbody">
<?php
echo "<table border=0 cellpadding=0 cellspacing=7>";
//if($profile[]!=""){echo "<tr><td> :<td class=fielddesc> $profile[]</tr>";}

if($profile[name]!=""){echo "<tr><td class=fieldsection>Name<td class=fielddesc> $profile[name]&nbsp;</tr>";}
if($profile[aboutme]!=""){echo "<tr><td class=fieldsection>About Me<td class=fielddesc> $profile[aboutme]</tr>";}
if($profile[likes]!=""){echo "<tr><td class=fieldsection>Likes<td class=fielddesc> $profile[likes]</tr>";}
if($profile[dislikes]!=""){echo "<tr><td class=fieldsection>Dislikes<td class=fielddesc> $profile[dislikes]</tr>";}
if($profile[movies]!=""){echo "<tr><td class=fieldsection>Movies<td class=fielddesc> $profile[movies]</tr>";}
if($profile[music]!=""){echo "<tr><td class=fieldsection>Music<td class=fielddesc> $profile[music]</tr>";}
if($profile[books]!=""){echo "<tr><td class=fieldsection>Books<td class=fielddesc> $profile[books]</tr>";}


echo "</table>";
?>
</table>

<br>
<table border=0 cellpadding="0" cellspacing="0" width="270px">

<tr><td class="titlebar">Professional Details
<tr><td class="boxbody">
<?php
echo "<table border=0 cellpadding=0 cellspacing=7>";
//if($profile[]!=""){echo "<tr><td> :<td class=fielddesc> $profile[]</tr>";}

if($profile[education]!=""){echo "<tr><td class=fieldsection>Education<td class=fielddesc> $profile[education]&nbsp;</tr>";}
if($profile[college]!=""){echo "<tr><td class=fieldsection>College<td class=fielddesc> $profile[college]</tr>";}
if($profile[occupation]!=""){echo "<tr><td class=fieldsection>Occupation<td class=fielddesc> $profile[occupation]</tr>";}

echo "</table>";
?>

</table>

<td width="50%" valign="top">

<!-- Start comments system  -->
<?php include('comments.php'); ?>
<!-- end comments system  -->

<td valign="top" align="center" width="30%">

<table border=0 cellpadding="0" cellspacing="0" width="270px">
<tr><td class="titlebar" id=personal_details><?php echo $disp[displayname]; ?>'s Friends
<tr><td class="boxbody">


<?php


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
	
	$friendslist_q = "select displayname,status,uid from user where uid=".$friends;

	if($friends==="0")
	{
		echo "<span style='font-size:11px'>$disp[displayname] has No Friends Added yet</span>";
	}
	else
	{
		$friendslist_res = mysql_query($friendslist_q);

		echo "<table border=0 cellpadding=0 cellspacing=0 width=100%>";
		while($row=mysql_fetch_array($friendslist_res))
		{
		echo "<tr><td><a href=profile.php?uid=$row[uid]>$row[displayname]</a></td><td> ................. </td><td>$row[status]</td></tr>";
		}
		echo "</table>";
	}

?>










</table>
<br>

 <div onMouseOver=changecolor(this) class=useroptions id=xyz onMouseOut=origcolor(this) onClick=addFriend()>Add To Friends List</div>
 <div onMouseOver=changecolor(this) class=useroptions id=xyz onMouseOut=origcolor(this)>Invite To Chat</div>


</table>




</tr>


<?php
}
else
{

header('Location:home.php');

}


?>