<form action="profile.php?uid=<?php echo $_GET[uid] ?>" method=post>
<textarea rows=6 cols=60 name="quickmsg" class=textfield id=textfield onFocus="chkfilled(this)" onBlur="chkempty(this)">Enter your message here</textarea>
<bR /><br>
<center><input type="submit" value="Post Quick Message" style="border:1px #C6CFE1 solid;height:30px;"></center>
</form>

<?php

// Insert any POSTed comments

if (isset($_POST[quickmsg]) && $_POST[quickmsg]!="")
{
	


	date_default_timezone_set ("Asia/Calcutta");
	$dt = date("Y-m-d G:i:s");
	$post_msg_q = "insert into scraps(to_uid,from_uid,dt,msg) values ('$_GET[uid]','$_SESSION[uid]','$dt','$_POST[quickmsg]')";
	mysql_query($post_msg_q);


}

// Retrieve comments from dB

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

echo "</table>";
?>