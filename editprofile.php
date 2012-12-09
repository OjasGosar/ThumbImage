<?php

session_start();

if(isset($_SESSION['uid']))
{


?>
<head>

<style type=text/css>
textarea
{
font-style:italic;
font-size:11px;
}

td
{
font-family:Verdana, Arial, Helvetica, sans-serif;
vertical-align:top;
font-size:13px;
padding:5px;
}

.topblue
{
background-color:#6D84B4;
text-align:center;
border:1px #3B5998 solid;
font-family:Verdana, Arial, Helvetica, sans-serif;
color:white;
font-size:15px;
height:30px;
vertical-align:middle;

}
.section
{
padding:6px;
border-bottom:1px #3B5998 dotted;
}

.form
{
font-family:Arial;
font-size:15px;


}


input
{
border:1px #CCCCCC solid;
font-family:Arial;
font-size:12px;
}

.check
{
text-align:center;
border:1px #CCCCCC solid;
background-color:#F2F2F2;
font-family:Arial;
font-size:15px;
height:50px;
vertical-align:middle;

}

.more
{
display:none;
}
.general
{
display:none;
}
.edu
{
display:none;
}

</style>
<script language="javascript" src="ref.js"></script>
<script language="javascript">
function showtab(id)
{
	if(id=="general")
	{
		$("sec_gen").style.fontWeight="bold";
		$("sec_more").style.fontWeight="normal";
		//$("sec_edu").style.fontWeight="normal";
		$("general").style.display="block";
		$("more").style.display="none";
		//$("edu").style.display="none";
		
	}
	else if(id=="more")
	{
		$("sec_gen").style.fontWeight="normal";
		$("sec_more").style.fontWeight="bold";
		//$("sec_edu").style.fontWeight="normal";
		$("general").style.display="none";
		$("more").style.display="block";
		//$("edu").style.display="none";

	}
	else
	{
		$("sec_gen").style.fontWeight="normal";
		$("sec_more").style.fontWeight="normal";
		$("sec_edu").style.fontWeight="bold";
		$("general").style.display="none";
		$("more").style.display="none";
		$("edu").style.display="block";

	}


}	
function changeColor(id)
{
	id.style.color="white";
	id.style.backgroundColor="#6D84B4";
}
function origColor(id)
{
	
	id.style.color="black";
	id.style.backgroundColor="white";
	
}
</script>
</head>


<body>



<?php

// Inserting EDITed fields into db

include('config.php');
if(isset($_POST['general_submit']))
{
	echo "i m ran, genra_submit";
	$dob = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
	mysql_query("update user set name='$_POST[name]',city='$_POST[city]',dob='$dob', country='$_POST[country]' where uid='$_SESSION[uid]'");
}
elseif(isset($_POST['more_submit']))
{
	echo "i m ran, more_update_submit";
	mysql_query("update user set abtMe='$_POST[abtMe]' where uid='$_SESSION[uid]'");
}
/* 
elseif(isset($_POST[edu_submit]))
{
	mysql_query("update profiles set education='$_POST[education]',college='$_POST[college]',occupation='$_POST[occupation]' where uid='$_SESSION[uid]'");
}
 */
/* value="<?php echo $profile[]; ?>" */

// Retreiving user information from DB

$profile_res = mysql_query("select * from user where uid='$_SESSION[uid]'");
$profile = mysql_fetch_array($profile_res);
$dateofbirth = explode("-",$profile['dob']);

if(isset($_POST['general_submit']) || isset($_POST['more_submit']) /* || isset($_POST['edu_submit']) */)
{
echo "<center><br><span style=\"font-size:12px;font-weight:bold;font-family:Verdana;\">... Account Details Updated ...</span></center><br>";
}
?>

<table border="0" cellpadding="0" cellspacing="0" width="100%">

<tr><td class=topblue colspan=3>Edit Your Profile</tr>

<tr>

<!-- Javascript Navigation Tabs -->
<td align="center" onClick=showtab("general") onMouseover=changeColor(this) onMouseout=origColor(this) class=section id=sec_gen width=32%>General
<td align="center" onClick=showtab("more") onMouseover=changeColor(this) onMouseout=origColor(this) class=section id=sec_more width=32%>More About Me
<!-- Javascript Navigation Tabs -->
</tr>

<tr>

<td class=form colspan=3>

<!-- DIV section for "general" -->
<div class=general id=general >
<table border=0 cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>

<table border=0 cellpadding="0" cellspacing="0" style="padding:10px; padding-right:30px; border-right:1px #3B5998 dotted">
<form name="generalform" method="POST" action="editprofile.php">
<tr><td>Name: <td><input type="text" name="name" value="<?php echo $profile['name']; ?>"></tr>

<tr><td>Date Of Birth: <td><input type="text" size="2" maxlength="2" value="<?php echo $dateofbirth[2] ?>" name=day>&nbsp;/&nbsp;<input type="text" size="2" maxlength="2" value="<?php echo $dateofbirth[1] ?>" name=month>&nbsp;/&nbsp;<input type="text" size="4" maxlength="4" value="<?php echo $dateofbirth[0] ?>" name=year></tr>

<tr><td>City : <td><input type="text" name="city" value="<?php echo $profile['city']; ?>"></tr>

<tr><td>Country : <td><?php include('country.php'); ?></tr>
</table>

<td>
</tr>

<tr>
<td colspan="2" class=check><input type=submit value="Save Changes" name="general_submit" /> &nbsp; <input type=reset />
</form>
</tr>


</table>
</div>

<!-- DIV section for "general" -->

<!-- DIV section for "More about me" -->

<div class=more id=more>
<table border=0 cellpadding="0" cellspacing="0" class=tab  width="100%">
<tr>
<td>

<table border=0 cellpadding="0" cellspacing="0" style="padding:10px; padding-right:30px; border-right:1px #3B5998 dotted">
<form id="form1" name="moreform" method="POST" action="editprofile.php">
<tr><td>About Me : <td><textarea rows=2 cols=20 name=abtMe><?php echo $profile['abtMe'] ?></textarea></tr>
</table>


<td>




</tr>

<tr>
<td colspan="2" class=check><input type=submit value="Save Changes" name="more_submit" /> &nbsp; <input type=reset />
</form>
</tr>


</table>
</div>

<!-- DIV section for "More about me" -->

</tr>


</table>




<?php

}

?>