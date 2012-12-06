<?php
session_start();
?>
<style type=text/css>
.box
{
	padding:25px;
	height:100px;
	width:100px;
	background-color : #6D84B4;
	font-size:20px;
	font-family:Georgia;
	cursor:pointer;
}
pre
{
	font-family:verdana;
	font-size:12px;
}
</style>

<script language=javascript>
function changeColor(selection)
{
	selection.style.backgroundColor="#FFFFFF";
	selection.style.color="#000000";
}

function origColor(selection)
{
	selection.style.backgroundColor="#6D84B4";
	selection.style.color="#000000";
}
</script>

<body>



<center>
<?
if(!isset($_GET[subject]) && !isset($_GET[chapter]))
{
?>
<table border=0>
<tr>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this)></td>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this) onClick='window.location="./learning.php?subject=1"'>Physics</td>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this)></td>
</tr>
<tr>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this) onClick='window.location="./learning.php?subject=2"'>Chemistry</td>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this)></td>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this) onClick='window.location="./learning.php?subject=3"'>Maths</td>
</tr>
<tr>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this)></td>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this) onClick='window.location="./learning.php?subject=4"'>Biology</td>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this)></td>
</tr>

</table>
<?
}
elseif(isset($_GET[subject]) && !isset($_GET[chapter]))
{
	include('config.php');
	$content = mysql_query("select * from chapters where subjectid='$_GET[subject]'");
	
	echo "<ul>";
	while($row=mysql_fetch_array($content))
	{
		echo "<li><a href='./learning.php?subject=$_GET[subject]&chapter=$row[chapterid]'>$row[chapter]</a>";
	}
	echo "</ul>";
}
elseif(isset($_GET[subject]) && isset($_GET[chapter]))
{
	include('config.php');
	
	if(isset($_POST[quickmsg]))
	{
	date_default_timezone_set ("Asia/Calcutta");
	$dt = date("Y-m-d G:i:s");
	$post_msg_q = "insert into comments(comment,contentid,commentby,dt) values ('$_POST[quickmsg]','$_GET[contentid]','$_SESSION[uid]','$dt')";
	echo $post_msg_q;
	mysql_query($post_msg_q);
	}
	
	$content = mysql_fetch_array(mysql_query("select * from chap_content where subjectid='$_GET[subject]' and chapterid='$_GET[chapter]'"));
	
	echo "$content[content]";
	
	// Retrieve comments from dB

	$comments = mysql_query("select * from comments where contentid=$content[contentid] order by dt desc");
	
	echo "<br><br><br><br><br><br><table border=1 width=700px cellpadding=7 cellspacing=0>";
	
	echo "<tr><th class=lastmsgs width=16% align=center>From</th><th class=lastmsgs align=center>Comments</th></tr>";
	
	while($row = mysql_fetch_array($comments))
	{
		// If comment posted either belongs to logged in user or is posted by logged in user
		
		if($row[commentby]==$_SESSION[uid])
		{
		echo "<tr><td class=lastmsgs width=16% align=center><b>$row[commentby]</td><td class=lastmsgs><div style=\"font-size:10px;text-align:right\">$row[dt]</div>$row[comment]<div style=\"text-align:right\"><input type=button value=Delete style=\"font-size:9px;border:1px grey solid;color:black\" onClick=location.href=\"deletemsg.php?msg=$row[msg_uid]\"></div></td></tr>";

		}
		else
		{
		echo "<tr><td class=lastmsgs width=16% align=center><b>$row[commentby]</td><td class=lastmsgs><div style=\"font-size:10px;text-align:right\">$row[dt]</div>$row[comment]</td></tr>";
		}
	}
	echo "</table>";
?>

<br><form action="learning.php?subject=<?php echo $_GET[subject] ?>&chapter=<? echo $_GET[chapter]; ?>&contentid=<? echo $content[contentid]; ?>" method=post>
<textarea rows=6 cols=80 name="quickmsg" class=textfield id=textfield> Enter your message here</textarea>
<bR /><br>
<center><input type="submit" value="Post Comment"></center>
</form>
</center>';
<?
}
?>
