<link rel="stylesheet" href="./css/global.css">

<div class=header><table border="0" cellpadding="0" cellspacing="0" width="100%"><td class=h_options width="25%" onClick="location.href='./home.php'" 	>Home&nbsp;<sup>[Logged in as <?php echo $_SESSION[username]; ?>]</sup><td class=h_options width="25%" onClick="location.href='./profile.php?uid=<?php echo $_SESSION[uid] ?>'">View My Profile<td class=h_options width="25%" onClick="location.href='./editprofile.php'">Edit Profile<td class=h_options width="25%" onClick="location.href='./logout.php'">Logout</table></div>
<div class=seperator></div>