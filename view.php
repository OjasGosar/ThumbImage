<?php
session_start();
include('config.php');
//require_once("ratings.php"); $rr = new RabidRatings();


include('./header.php');
?>
<link rel=stylesheet
	href=./css/global.css />
<link rel="stylesheet"
	href="./css/view.css">
<style type=text/css>
#mainphoto {
	cursor: pointer;
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

.123456 {
	width: 12px;
	height: 12px;
}

.012345 {
	width: 12px;
	height: 12px;
}

#rateMe li a:hover,#rateMe .on {
	background: url(./images/star-black24.png) no-repeat;
}

#rateMe a {
	float: left;
	background: url(./images/star-white24.png) no-repeat;
	width: 24px;
	height: 24px;
}

#ratingSaved {
	display: none;
}

.saved {
	color: red;
}

a {
	text-decoration: none;
	color: blue;
}

.submitbutton {
	border: 3px black groove;
}

a:hover {
	text-decoration: underline;
	color: red;
}

td {
	padding-left: 2px;
	padding-right: 2px;
	padding-top: 2px;
	padding-bottom: 2px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
}

table {
	padding-top: 2px;
	padding-bottom: 2px;
}

.loginbox {
	border: 0px;
	right: 0px;
	top: 150px;
}

.loginfields {
	border: 0px;
	border-bottom: 1px black dotted;
	height: 25px;
	font-style: italic;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}

.footer {
	position: absolute;
	bottom: 10px;
	left: 45%;
}

.lastmsgs {
	background-color: #DFE4EE;
	padding: 5px;
	border: 2px white solid;
	font-family: Verdana;
	font-size: 12px;
}
</style>
<script
	language="javascript" src="./resize.js"></script>
<script
	language="javascript" src="./ref.js"></script>
<script
	language="javascript" src="ratingsys.js"></script>
<script type="text/javascript">
function enlightenUp(id){
	document.getElementById(id).src="./images/dark_thumbsup.png";
}
function enlightenDn(id){
	document.getElementById(id).src="./images/dark_thumbsdown.png";
}
function darkenUp(id){
	document.getElementById(id).src="./images/enlighten_thumbsup.png";
}
function darkenDn(id){
	document.getElementById(id).src="./images/enlighten_thumbsdown.png";
}
</script>
<body onLoad="init()">


	<!-- Main Photo -->
	<table style="margin: auto;">
		<tr>
			<td valign="top" width="3%" align="left"
				style="background-color: #F2F2F2; padding-top: 5px; padding-left: px; padding-right: px; border-left: 1px #CCCCCC solid; border-bottom: 1px #CCCCCC solid; border-top: 1px #CCCCCC solid; border-right: 1px #CCCCCC solid;">
				<table>
					<tr>
						<td><?php 
						// Retrieve Tags from dB
						$quicktag_q = "select * from tag,user where taggedBy=uId and contentId='$_GET[image]' order by tag.timestamp desc";
						$quicktag_res = mysql_query($quicktag_q);
						$contentOwner_q = "select * from content where contentId='$_GET[image]'";
						$contentOwner_res = mysql_query($contentOwner_q);
						$contentOwnerRow = mysql_fetch_array($contentOwner_res);
						
						$contentOwnerDETAILS_q = "select * from content, user where ownedBy=uId and contentId='$_GET[image]'";
						$contentOwnerDETAILS_res = mysql_query($contentOwnerDETAILS_q);
						
						

						echo "<table border=0 width=300px cellpadding=0 cellspacing=0>";
						echo "<tr><td colspan=3 class=titlebar width=270px><h3 align=\"left\" >User Tags</h3></td></tr>";
						if (mysql_num_rows($quicktag_res)==0)
						{

							// ============= If no Tags

							echo "<tr><td class=lastmsgs width=16%>-</td><td class=lastmsgs>This Photo has No Tags</td></tr>";
						}
						else
						{

							echo "<tr><th class=lastmsgs align=left>From</th><th class=lastmsgs align=left>Tag</th><th class=lastmsgs align=left></th></tr>";

							while($row = mysql_fetch_array($quicktag_res))
							{
								// If tags posted either belongs to logged in user or is posted by logged in user
								$textWraped = wordwrap($row['text'],25,"\n", true);

								echo "<tr><td class=lastmsgs align=left><a href=\"./profile.php?uid=$row[taggedBy]\" class=textLinks>$row[userName]</a></td><td class=lastmsgs>$textWraped<div style=\"font-size:10px;text-align:left\"><sub>$row[timestamp]</sub></div>";
								if (isset($_SESSION['uid']))
								{
									echo "<div id='tagThumbs' class='discussion-meta column span-3'>";
									$r_ifUserThumbed = mysql_fetch_array(mysql_query("select * from tagconfirm where tagId = '".$row['tagId']."' and thumber = ".$_SESSION['uid']));
									// echo $r_ifUserThumbed['thumb'];
									$thumbsUp = "$row[tagId]1";
									$thumbsDn = "$row[tagId]0";
									if($r_ifUserThumbed['confirm']==1 && $r_ifUserThumbed['confirm']!=null) echo "<img src='./images/dark_thumbsup.png' heigth=20px width=20px>";

									else echo "<a href='thumb.php?tagId=$row[tagId]&contentID=$_GET[image]&thumb=1' onmouseover=enlightenUp('$thumbsUp') onmouseout=darkenUp('$thumbsUp')><img id='$thumbsUp' src='images/enlighten_thumbsup.png' heigth=12px width=12px></a>";
									if($r_ifUserThumbed['confirm']==0 && $r_ifUserThumbed['confirm']!=null) echo "<img src='./images/dark_thumbsdown.png' heigth=20px width=20px>";
									else echo "<a href='thumb.php?tagId=$row[tagId]&contentID=$_GET[image]&thumb=0' onmouseover=enlightenDn('$thumbsDn') onmouseout=darkenDn('$thumbsDn')><img id='$thumbsDn' src='images/enlighten_thumbsdown.png' heigth=12px width=12px></a>";

									echo "</div></td>";

									if($row['taggedBy']==$_SESSION['uid'] || $contentOwnerRow['ownedBy']==$_SESSION['uid'])
									{
										echo "<td class=lastmsgs><div style=\"text-align:right\"><input type=button value=Delete style=\"font-size:9px;border:1px grey solid;color:black\" onClick=location.href=\"deletetag.php?tagId=$row[tagId]&image=$_GET[image]\"></div></td></tr>";
									}
								}
							}
						}

						echo "</table>";
						?>
						</td>
					</tr>

					<tr>
						<td><?php 
						// Retrieve comments from dB
						$quickcomment_q = "select * from comment,user where commentor=uId and contentId='$_GET[image]' order by comment.timestamp ASC";
						$quickcomment_res = mysql_query($quickcomment_q);
						$contentOwner_q = "select * from content where contentId='$_GET[image]'";
						$contentOwner_res = mysql_query($contentOwner_q);
						$contentOwnerRow = mysql_fetch_array($contentOwner_res);

						echo "<table border=0 width=300px cellpadding=0 cellspacing=0>";
						echo "<tr><td colspan=3 class=titlebar width=270px><h3 align=\"left\" >User Comments</h3></td></tr>";
						if (mysql_num_rows($quickcomment_res)==0)
						{

							// ============= If no messages

							echo "<tr><td class=lastmsgs width=16%>-</td><td class=lastmsgs>The Photo has No Comments</td></tr>";
						}
						else
						{

							echo "<tr><th class=lastmsgs align=left>From</th><th class=lastmsgs align=left>Comment</th><th class=lastmsgs align=left></th></tr>";

							while($row = mysql_fetch_array($quickcomment_res))
							{
								// If scrap posted either belongs to logged in user or is posted by logged in user
								$textWraped = wordwrap($row['text'],25,"\n", true);

								echo "<tr><td class=lastmsgs align=left><a href=\"./profile.php?uid=$row[commentor]\" class=textLinks>$row[userName]</a></td><td class=lastmsgs>$textWraped<div style=\"font-size:10px;text-align:left\"><sub>$row[timestamp]</sub</div>";
								if (isset($_SESSION['uid']))
								{
									echo "<div id='commThumbs' class='discussion-meta column span-3'>";
									$r_ifUserThumbed = mysql_fetch_array(mysql_query("select * from commentconfirm where commentId = '".$row['commentId']."' and thumber = ".$_SESSION['uid']));
									// echo $r_ifUserThumbed['thumb'];
									$thumbsUp = "$row[commentId]1";
									$thumbsDn = "$row[commentId]0";
									if($r_ifUserThumbed['thumb']==1 && $r_ifUserThumbed['thumb']!=null) echo "<img src='./images/dark_thumbsup.png' heigth=20px width=20px>";

									else echo "<a href='thumb.php?commentId=$row[commentId]&contentID=$_GET[image]&thumb=1' onmouseover=enlightenUp('$thumbsUp') onmouseout=darkenUp('$thumbsUp')><img id='$thumbsUp' src='images/enlighten_thumbsup.png' heigth=12px width=12px></a>";
									if($r_ifUserThumbed['thumb']==0 && $r_ifUserThumbed['thumb']!=null) echo "<img src='./images/dark_thumbsdown.png' heigth=20px width=20px>";
									else echo "<a href='thumb.php?commentId=$row[commentId]&contentID=$_GET[image]&thumb=0' onmouseover=enlightenDn('$thumbsDn') onmouseout=darkenDn('$thumbsDn')><img id='$thumbsDn' src='images/enlighten_thumbsdown.png' heigth=12px width=12px></a>";

									echo "</div></td>";
									if($row['commentor']==$_SESSION['uid'] || $contentOwnerRow['ownedBy']==$_SESSION['uid'])
									{
										echo "<td class=lastmsgs><div style=\"text-align:right\"><input type=button value=Delete style=\"font-size:9px;border:1px grey solid;color:black\" onClick=location.href=\"deletemsg.php?commentId=$row[commentId]&image=$_GET[image]\"></div></td></tr>";
									}
								}

							}
						}

						echo "</table>";
						?>
						</td>
					</tr>
				</table>
			</td>
			<td width="10%" align="center" valign="top">
				<center>
					<a href='javascript:history.back()' class='vsmalltext'>Back</a><br />
					<br />
					<div id=sizeChanger onClick=toggleSize()></div>
				</center>
				<div id=imageContainer>
					<!-- Main Photo -->

					<?php
					$image=mysql_fetch_array(mysql_query("select * from content where contentId='$_GET[image]'"));
					$pics = mysql_query("select content, rating from content where contentId='$_GET[image]'");
					$row=mysql_fetch_array($pics);
					//$star="Star";
					echo "<img src='./uploads/$image[content]' id=mainphoto onClick='toggleSizeImg()'>";

					echo "</br><span style=\"font-size: 20px;\"><b><U> Rating: </U></b></br></span>";
					$rate = round($row['rating']);
					for ($i=0;$i<$rate;$i++) {
					?>
					<img src="./images/star-black24.png">
					<?php
					}
					for ($i=0;$i<5-$rate;$i++) {
					?>
					<img src="./images/star-white24.png">
					<?php
					}
					/* if($rate>1) {
					 $star = "Star's";
					} */
					echo "<b><i> $rate of 5 Star's</i></b>";
					$contentOwnerRowDETAILS = mysql_fetch_array($contentOwnerDETAILS_res);
					echo "</br></br> Owned By:<a href = \"profile.php?uid=$contentOwnerRowDETAILS[uId]\"style=\"font-size: 15px;\"> $contentOwnerRowDETAILS[userName]</a>";
					?>
			
			</td>
			<td valign="top" width="1%" align="right"
				style="background-color: #F2F2F2; padding-top: 10px; padding-left: 8px; padding-right: 8px; border-left: 1px #CCCCCC solid; border-bottom: 1px #CCCCCC solid; border-top: 1px #CCCCCC solid; border-right: 1px #CCCCCC solid;">
				<h3 align="center" class="titlebar">User Activity</h3> </br> <?php if (isset($_SESSION['uid'])) 
				{
					?>
				<table>

					<tr>
						<td><?php
						$ratingQuery = "select * from rating where ratedBy='$_SESSION[uid]' and contentId='$_GET[image]'";
						$r_Rating = mysql_query($ratingQuery);
						if(mysql_num_rows($r_Rating)>0){
							$rating =
							mysql_fetch_array($r_Rating);
							$star = "Star";
							if($rating['rating']>1) {
								$star = "Star's";
							}
							echo "<h3>You have Rated $rating[rating] $star </h3>";
							for($i = 0; $i < $rating['rating']; $i++){
										echo "<img src='./images/star-black24.png'>";
									}
									for($i = 0; $i < 5-$rating['rating']; $i++){
										echo "<img src='./images/star-white24.png'>";
									}
						}
						else{
						?>
							<h2>Rate?</h2>
							<div class="code">
								<span id="rateStatus">Rate Me...</span> <span id="ratingSaved">Rating
									Saved!</span>
								<div id="rateMe">
									<a onclick="rateIt(this)" id="_1" title="ehh..."
										onmouseover="rating(this)" onmouseout="off(this)"></a> <a
										onclick="rateIt(this)" id="_2" title="Not Bad"
										onmouseover="rating(this)" onmouseout="off(this)"></a> <a
										onclick="rateIt(this)" id="_3" title="Pretty Good"
										onmouseover="rating(this)" onmouseout="off(this)"></a> <a
										onclick="rateIt(this)" id="_4" title="Out Standing"
										onmouseover="rating(this)" onmouseout="off(this)"></a> <a
										onclick="rateIt(this)" id="_5" title="Freakin' Awesome!"
										onmouseover="rating(this)" onmouseout="off(this)"></a>
								</div>
								<div id="form">
									<form name="rateForm" method="post" action="ratedByUser.php">
										<input type="hidden" name="rating"> <input type="hidden"
											name="contentID" value="<?php echo $_GET['image'] ?>"> <input
											type="hidden" name="userID"
											value="<?php echo $_SESSION['uid'] ?>">
									</form>
								</div>
							</div> <?php
						}
						?>
						</td>
					</tr>
					<tr>
						<td>
							<div>
								<form name=loginform action="./taggedByUser.php" method=POST>
									<table>
										<tr>
											<td>Tag:</td>
											<td><input type="text" name="tag" class="loginfields" /> <input
												type="hidden" name="contentID"
												value="<?php echo $_GET['image'] ?>"> <input type="hidden"
												name="userID" value="<?php echo $_SESSION['uid'] ?>"></td>
											<td align=center colspan="2"><input type=submit
												value="Tag IT!" class=submitbutton name=submitTag><br />
											</td>
										</tr>
										<tr>
											<td colspan="3"><?php
											if(isset($_GET['resultTag'])) {
												if($_GET['resultTag'] == true) {
												echo "<center><span style=\"font-size:12px;font-weight:bold;font-family:Verdana;\">... Content Successfully Tagged ...</span></center>";
												} else if ($_GET['result'] == false) {
												echo "<center><span style=\"font-size:12px;font-weight:bold;font-family:Verdana;\">... Tag Already Exists ...</span></center>";
												}
												}
												?>
											</td>
										</tr>
									</table>
								</form>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<form action="addComment.php" method=post>
								<textarea rows=6 cols=30 name="comment" class=textfield
									id=textfield
									onFocus="if (this.value == this.defaultValue) { this.value = ''; }"
									onBlur="if (this.value == '') { this.value = this.defaultValue; }">Enter your comment here!</textarea>
								<input type="hidden" name="contentID"
									value="<?php echo $_GET['image'] ?>"> <input type="hidden"
									name="userID" value="<?php echo $_SESSION['uid'] ?>"> <bR /> <br>
								<center>
									<input type="submit" value="Comment!"
										style="border: 1px #C6CFE1 solid; height: 30px;">
								</center>
							</form>
						</td>

					</tr>
					<tr>
						<td><?php 

						if ($_SESSION['uid'] == $contentOwnerRow['ownedBy']) {
						echo "<br><form method=POST
						action=showgallery.php?uid=$_SESSION[uid]>
						<input type=hidden name=deletePic
						value=$_GET[image]><center><input type=submit value=\"Delete\" style=\"border: 1px #C6CFE1 solid; height: 30px;\"></center>
						</form>";
						}
						?>
						</td>
					</tr>
					<tr>
						<td colspan="3"><?php
						if(isset($_GET['resultComment'])) {
						if($_GET['resultComment'] == true) {
						echo "<center><span style=\"font-size:12px;font-weight:bold;font-family:Verdana;\">... Comment Successfully Posted ...</span></center>";
						} else if ($_GET['result'] == false) {
						echo "<center><span style=\"font-size:12px;font-weight:bold;font-family:Verdana;\">... Can't Post the Comment at This Moment ...</span></center>";
						}
						}
						?>
						</td>
					</tr>
				</table> <?php 
				}?>

			</td>
		</tr>
		</br>
		</br>
	</table>
</body>
