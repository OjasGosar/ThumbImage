<?php

session_start();

if (isset($_SESSION['uid']))
{
	header('Location:home.php');
}

else
{
	?>

<html>
<head>


<style type="text/css">
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
	padding-left: 5px;
	padding-right: 5px;
	padding-top: 5px;
	padding-bottom: 5px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
}

table {
	padding-top: 5px;
	padding-bottom: 5px;
}

.loginbox {
	border: 0px;
	position: absolute;
	right: 600px;
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
</style>

<title>Login</title>
</head>





<body>

	<div class=loginbox style="text-align: center;">
		<form name=loginform action="./checklogin.php" method=POST>

				<div
					style="font-size: 48px; font-style: italic; font-face: verdana; padding: 10px; font-weight: bold">ThumbTag</div>

			<table>
				<tr>
					<td>Email Address :
					
					<td><input type="text" name="email" class="loginfields" /><br />
				
				</tr>
				<tr>
					<td>Password :
					
					<td><input type="password" name="pass" class="loginfields" /><br />
				
				</tr>
				<tr>
					<td align=center colspan=""><br /> <input type=submit
						value="Login" class=submitbutton name=submitlogin><br />
					<form name=guestUser action="./checklogin.php" method=POST>
					<td align=center colspan=""><br /> <input type="hidden" name="guest" value="guestuser"/>
						<input type="submit" name="guestlogin" class=submitbutton value="Sneak In"/>
						</form>
				
				<tr>
					<td align=center colspan="2">
						<hr color="#CCCCCC"> <a href="./register.php">Register</a>
					<td align=center colspan="2">
					
			
			</table>
		</form>
	</div>

	<div class="footer">
		<? include('footer.php'); ?>
	</div>
</body>
</html>

<?php

}

?>