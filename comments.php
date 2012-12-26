<?php 


// Retrieve comments from dB
$quickcomment_q = "select * from comment,user where commentor=uId and uId='$_GET[uid]' order by comment.timestamp desc limit 0,10";
$quickcomment_res = mysql_query($quickcomment_q);
//$contentOwner_q = "select * from content where contentId='$_GET[image]'";
//$contentOwner_res = mysql_query($contentOwner_q);
//$contentOwnerRow = mysql_fetch_array($contentOwner_res);

echo "<table border=0 width=800px cellpadding=0 cellspacing=0>";
echo "<tr><td colspan=3 class=titlebar width=270px><h3 align=\"left\" >User Comments</h3></td></tr>";
if (mysql_num_rows($quickcomment_res)==0)
{

	// ============= If no messages

	echo "<tr><td class=lastmsgs width=16%>-</td><td class=lastmsgs>The Photo has No Comments</td></tr>";
}
else
{

	echo "<tr><th class=lastmsgs align=left>From</th><th class=lastmsgs align=left>Comment</th></tr>";

	while($row = mysql_fetch_array($quickcomment_res))
	{
		// If scrap posted either belongs to logged in user or is posted by logged in user
		$textWraped = wordwrap($row['text'],25,"\n", true);

		echo "<tr><td class=lastmsgs align=left><a href=\"./profile.php?uid=$row[commentor]\" class=textLinks>$row[userName]</a></td><td class=lastmsgs>$textWraped<div style=\"font-size:10px;text-align:left\"><sub>$row[timestamp]</sub</div>";
		
		echo "</td>";
		echo "</tr>";

	}
}

echo "</table>";


/* 
$quickcomment_q = "select * from scraps,user where to_uid=$_GET[uid] and scraps.to_uid=user.uid order by dt desc";
$quickcomment_res = mysql_query($quickcomment_q);
echo "<table border=0 width=600px cellpadding=0 cellspacing=0>";

if (mysql_num_rows($quickcomment_res)==0)
{

	// ============= If no messages

	echo "<tr><td class=lastmsgs width=16%>-</td><td class=lastmsgs>You have no messages</td></tr>";
}
else
{

	echo "<tr><th class=lastmsgs width=16% align=center>From</th><th class=lastmsgs align=center>Message</th></tr>";

	while($row = mysql_fetch_array($quickcomment_res))
	{
		// If scrap posted either belongs to logged in user or is posted by logged in user

		if($row[from_uid]==$_SESSION[uid] || $_GET[uid]==$_SESSION[uid])
		{
			echo "<tr><td class=lastmsgs width=16% align=center><a href=\"./profile.php?uid=$row[from_uid]\">$row[username]</a></td><td class=lastmsgs><div style=\"font-size:10px;text-align:right\">$row[dt]</div>$row[msg]<div style=\"text-align:right\"><input type=button value=Delete style=\"font-size:9px;border:1px grey solid;color:black\" onClick=location.href=\"deletemsg.php?msg=$row[msg_uid]\"></div></td></tr>";
		}
		else
		{
			echo "<tr><td class=lastmsgs width=16% align=center><a href=\"./profile.php?uid=$row[from_uid]\">$row[username]</a></td><td class=lastmsgs><div style=\"font-size:10px;text-align:right\">$row[dt]</div>$row[msg]</td></tr>";
		}
	}
}

echo "</table>"; */
?>