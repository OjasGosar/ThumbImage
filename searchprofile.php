<?php

session_start();
// select * from profiles where name like "%%"
if(isset($_SESSION['uid']))
{
	include('config.php');

	include('header.php');

	?>

<head>
<style type=text/css>
td {
	font-size: 12px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}

.searchres {
	background-color: #DFE4EE;
	border: 1px #C6CFE1 solid;
}
</style>
</head>
<body>

	<table border=0 cellpadding="0" cellspading="0" width="100%">
		<tr>
			<?php 
			if (isset($_GET['search'])) {
				if ($_GET['search'] == "advance") {
			?>
			<td width="20%" valign="top">

				<table border=0 cellpadding=0 cellspacing="0">
					<tr>
						<td class=titlebar>Enter your Search Criteria
					
					</tr>
					<tr>
						<td class=boxbody colspan=2>

							<form name=advancedSearch method=POST action=searchprofile.php>
								<table border="0" cellpadding="5px" cellspacing="0">
									<tr>
										<td colspan="2">
									
									</tr>
									<tr>
										<td colspan=2 align="center"
											style="border-top: 1px #CCCCCC solid; border-bottom: 1px #CCCCCC solid;">Personal
											Details
									
									</tr>
									<tr>
										<td>
										
										<td>
									
									</tr>
									<tr>
										<td>Nickname
										
										<td><input type=text name=userName>
									
									</tr>
									<tr>
										<td>Name :
										
										<td><input type=text name=name>
									
									</tr>

									<tr>
										<td>City :
										
										<td><input type=text name=city>
										
										<td>
										
										<td>
									
									</tr>
									<tr>
										<td>
										
										<td>
									
									</tr>
									<tr>
										<td colspan="2" align="center"
											style="border-top: 1px #CCCCCC solid; padding-top: 9px;"><input
											type="button" value="Reset" onClick=doReset()>&nbsp;&nbsp;<input
											type="submit" name="advanced_search" value="Search" />
									
									</tr>
								</table>
							</form>
				
				</table>
			</td>
			<?php 		
				}
			}
			?>
			<td style="padding-left: 10px;" valign="top"><?php
			if(isset($_POST['advanced_search']))
			{
				
				$adv = "select * from user where userName  like '%$_POST[userName]%'
				union
				select * from user where name like '%$_POST[name]%'
				union
				select * from user where name like '%$_POST[city]%'";
				//$adv = "select * from profiles,user where name like '%$_POST[name]%' and city like '%$_POST[city]%'  and gender='$_POST[gender]' and user.displayname like '%$_POST[displayname]%' and college like '%$_POST[college]%' and profiles.uid=user.uid";
				$advsearch_res = mysql_query($adv);
				echo "<b>Your search returned ".mysql_num_rows($advsearch_res)." result(s)</b><br><br>";

				echo "<table border=0 cellpadding=5 cellspacing=0 width=98%>";
				while($row=mysql_fetch_array($advsearch_res))
				{
					echo "<tr><td width=5% align=center class=searchres><a href=\"profile.php?uid=$row[uId]\"><img src=\"$row[profilePic]\" height=92 width=92 border=0><br>$row[userName]</a><td class=searchres>$row[name]<br><b>City</b> : $row[city]</tr>";
				}
				echo "</table>";
			}
			elseif(isset($_POST['simplesearch']))
			{

				$search_q = "select * from user where userName  like '%$_POST[simplesearch]%'
				union
				select * from user where name like '%$_POST[simplesearch]%'";
				$search_res = mysql_query($search_q);

				echo "<b>Your search returned ".mysql_num_rows($search_res)." result(s)</b><br><br>";

				echo "<table border=0 cellpadding=5 cellspacing=0 width=98%>";
				while($row=mysql_fetch_array($search_res))
				{
					echo "<tr><td width=5% align=center class=searchres><a href=\"profile.php?uid=$row[uId]\"><img src=\"$row[profilePic]\" height=92 width=92 border=0><br>$row[userName]</a><td class=searchres>$row[name]<br><b>City</b> : $row[city]</tr>";
				}
				echo "</table>";
			}
			?>
	
	</table>
</body>
<?php

}

?>