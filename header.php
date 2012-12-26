<link rel="stylesheet" href="./css/global.css">

<div class=header>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<td class=h_options width="25%" onClick="location.href='./home.php'">Home&nbsp;<sub>[Logged
				in as <?php if (isset($_SESSION['username'])) { 
					echo $_SESSION['username'];
				} else if (isset($_SESSION['guestusername'])) {
					echo $_SESSION['guestusername']; 
				}?>]
		</sub>
		</td>
		<?php if (isset($_SESSION['uid'])){
		?> <td class=h_options width="25%"
			onClick="location.href='./profile.php?uid=<?php echo $_SESSION['uid'] ?>'">View
			My Profile</td>
		<?php } ?>
		<td class=h_options width="25%" onClick="location.href='./logout.php'">Logout
		</td>
		<td class=h_options width="25%"><form method=POST
				action=searchcontent.php?>
				Search : <input type=text name=tagsearch><input type=hidden name=uid
					value=<?php if (isset($_SESSION['uid'])){
						echo $_SESSION['uid'];
					}
					else if (isset($_SESSION['guestid'])){
						echo $_SESSION['guestid'];
					}?>>
					<input type=submit value="Search">
			</form>
		</td>



	</table>
</div>
<div class=seperator></div>
