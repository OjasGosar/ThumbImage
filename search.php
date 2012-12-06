<?php

session_start();
// select * from profiles where name like "%%"
if(isset($_SESSION[uid]))
{
	include('config.php');
	
	include('header.php');
	
?>

<head>
<style type=text/css>
td
{
font-size:12px;
font-family:Verdana, Arial, Helvetica, sans-serif;
}
.searchres
{
background-color:#DFE4EE;
border:1px #C6CFE1 solid;
}
</style>
</head>
<body>

<table border=0 cellpadding="0" cellspading="0" width="100%">
<tr>
<td width="20%" valign="top">

<table border=0 cellpadding=0 cellspacing="0">
<tr><td class=titlebar>Enter your Search Criteria</tr>
<tr><td class=boxbody colspan=2>

<form name=advancedSearch method=POST action=search.php>
<table border="0" cellpadding="5px" cellspacing="0">
<tr><td colspan="2"></tr>
<tr><td colspan=2 align="center" style="border-top:1px #CCCCCC solid;border-bottom:1px #CCCCCC solid;">Personal Details </tr>
<tr><td><td></tr>
<tr><td>Nickname<td><input type=text name=displayname value="<?php echo $_POST[displayname] ?>"></tr>
<tr><td>Name :<td><input type=text name=name value="<?php echo $_POST[name] ?>"></tr>
<tr><td>Gender :<td><select name=gender><option <?php if($_POST[gender]=="Male"){echo "selected=\"selected\"";}?>>Male</option><option <?php if($_POST[gender]=="Female"){echo "selected=\"selected\"";}?>>Female</option></select> </tr>
<tr><td>City :<td><input type=text name=city value="<?php echo $_POST[city] ?>"></tr>
<tr><td>Country :<td><?php include('country.php');?></tr>
<tr><td><td></tr>
<tr><td colspan=2 align="center" style="border-top:1px #CCCCCC solid;border-bottom:1px #CCCCCC solid;">Professional Details </tr>
<tr><td><td></tr>
<tr><td>College :<td><input type=text name=college value="<?php echo $_POST[college] ?>"></tr>
<tr><td><td></tr>
<tr><td colspan="2" align="center" style="border-top:1px #CCCCCC solid;padding-top:9px;"><input type="button" value="Reset" onClick=doReset()>&nbsp;&nbsp;<input type="submit" name="advanced_search" value="Search" /></tr>
</table>
</form>

</table>

<td style="padding-left:10px;" valign="top"> 
<?php

if(isset($_POST['advanced_search']))
{

	$adv = "select * from profiles,user where name like '%$_POST[name]%' and city like '%$_POST[city]%'  and gender='$_POST[gender]' and user.displayname like '%$_POST[displayname]%' and college like '%$_POST[college]%' and profiles.uid=user.uid";
	$advsearch_res = mysql_query($adv);
	echo "<b>Your search returned ".mysql_num_rows($advsearch_res)." result(s)</b><br><br>";
	
	echo "<table border=0 cellpadding=5 cellspacing=0 width=98%>";
	while($row=mysql_fetch_array($advsearch_res))
	{
		echo "<tr><td width=5% align=center class=searchres><a href=\"profile.php?uid=$row[uid]\"><img src=\"$row[photo]\" height=92 width=92 border=0><br>$row[displayname]</a><td class=searchres>$row[name] ($row[gender])<br><b>City</b> : $row[city]</tr>";
	}
	echo "</table>";
}
elseif(isset($_POST[simplesearch]))
{

		$search_q = "select * from user,profiles where name like '%$_POST[simplesearch]%' and profiles.uid=user.uid";
		$search_res = mysql_query($search_q);

		echo "<b>Your search returned ".mysql_num_rows($search_res)." result(s)</b><br><br>";
	
		echo "<table border=0 cellpadding=5 cellspacing=0 width=98%>";
		while($row=mysql_fetch_array($search_res))
		{
		echo "<tr><td width=5% align=center class=searchres><a href=\"profile.php?uid=$row[uid]\"><img src=\"$row[photo]\" height=92 width=92 border=0><br>$row[displayname]</a><td class=searchres>$row[name] ($row[gender])<br><b>City</b> : $row[city]</tr>";
		}
		echo "</table>";
}
?>

</table>
</body>
<?

}

?>