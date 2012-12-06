<?php

session_start();

if(isset($_SESSION[uid]))
{


?>
<head>

<style type=text/css>
td
{
font-family:Verdana, Arial, Helvetica, sans-serif;
vertical-align:top;
font-size:13px;
padding:2px;
}
.topblue
{
background-color:#6D84B4;
text-align:center;
border:1px #3B5998 solid;

color:white;
font-family:Arial;
font-size:15px;

}

.form
{

border:1px #F2F2F2 solid;

font-family:Arial;
font-size:15px;
width:250px;

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

</style>

<script language="javascript">
function submitform()
{

}
</script>
</head>

<body>


<table border="0" cellpadding="0" cellspacing="0" class=tab width="100%">

<tr>
<td class=topblue>Account Settings
</tr>

<tr>
<td class=form>


<?php

include('config.php');

if(isset($_POST[update]))
{

if(mysql_query("update user set email='$_POST[email]',pass='$_POST[pass]',sec_q='$_POST[secret_q]',sec_ans='$_POST[secret_ans]' where uid='$_SESSION[uid]'"))
{
echo "<center><br><span style=\"font-size:12px;font-weight:bold;font-family:Verdana;\">... Account Details Updated ...</span></center>";
}

}

$accdetails = mysql_fetch_array(mysql_query("select * from user where uid='$_SESSION[uid]'"));

?>

<form method=POST action=settings.php name=accform>
<table border=0 cellpadding="0" cellspacing="0" style="padding:10px;">
<tr><td>Email Address : <td><input type=text name=email size="40" value="<?php echo $accdetails[email] ?>"/></tr>
<tr><td>Password : <td><input type=text name=pass size="40" value="<?php echo $accdetails[pass] ?>"></tr>
<tr><td>Secret Question : <td><input type=text name=secret_q size="40" value="<?php echo $accdetails[sec_q] ?>"></tr>
<tr><td>Secret Answer : <td><input type=text name=secret_ans size="40" value="<?php echo $accdetails[sec_ans] ?>"></tr>

</table>
</tr>


<tr>
<td class=check><input type=submit value="Save Changes" name="update">
</tr>

</table>

</form>

<?

}

?>