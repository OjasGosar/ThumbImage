<html>
<head>
<style type="text/css">
a
{
font-family:Arial;
font-size:13px;
color:#6D84B4;
}
a:hover
{
font-family:Arial;
font-size:13px;
color:red;

}
.buttn
{
height:40px;
width:90px;
border:1px #CCCCCC solid;
background-color:white;
color:black;
font-family:Arial;
font-size:12px;
}

.reqd
{color:red;
}

.inputfields
{
border:1px #CCCCCC solid;
font-family:Arial;
font-size:12px;
}

.acc
{
border-bottom:8px white solid;
border-top:8px white solid;
font-family:Arial;
font-size:12px;
padding-left:10px;
}

.tab
{
position:absolute;
margin:auto;
left:500px;
top:100px;

}

.topblue
{
background-color:#6D84B4;
text-align:center;
border:1px #3B5998 solid;
height:40px;
color:white;
font-family:Arial;
font-size:15px;
width:500px;
}

.form
{
width:125px;
border:1px #F2F2F2 solid;
height:300px;
font-family:Arial;
font-size:15px;
width:250px;
}

.check
{
text-align:center;
height : 40px;
border:1px #CCCCCC solid;
background-color:#F2F2F2;
font-family:Arial;
font-size:10px;
width:250px;
}

.sep
{
width:5px;
border:2px white solid;
}	

</style>

<script language="javascript" src="ref.js"></script>

<script language="javascript"> 

accountarr = document.getElementsByTagName("input");
function validation(elements)
{
	window.confirm("Do you really want to reset the form and start over again ?")
	var counter=0;
	var fieldsdone=0;
	for (counter=0; counter < elements; counter++)
	{
			if(accountarr[counter].value!="")
			{
				fieldsdone=fieldsdone+1;
			}			
	}
	if(fieldsdone==elements)
	{
		$("check1").innerHTML="Success !&nbsp;<img src='./images/good.gif'>";
		document.regform.submit();
	}
	else
	{
		$("check1").innerHTML="You have "+parseInt(elements-fieldsdone)+" fields remaining&nbsp;<img src='./images/bad.gif'>";
	}
}

function qReset()
{
	if(window.confirm("Do you really want to reset the form and start over again ?"))
	{
		document.regform.reset();
		checkGender($('genderSelector'));
		validation(3);
		
	}
}
/*
function checkGender(selector)
{
	if(selector.selectedIndex==0)
	{
		$("check2").innerHTML="Please select your Gender&nbsp;<img src='./images/bad.gif'>";
		return 0;
	}
	else
	{
		$("check2").innerHTML="Success&nbsp;<img src='./images/good.gif'>";
		return 1;
	}
}
*/

function checkFilled()
{
	if($('username').value!="")
	{
		document.regform.submit();		
	}
	else if
	{
		$("check2").innerHTML="Please enter your UserName&nbsp;<img src='./images/bad.gif'>";
	}
	else
	{
		validation(3);
	}
}
</script>

</head>
<body>


<?php
if ( $_POST["pass"] && $_POST["email"] && $_POST["username"])
//if(0)
{
	include ('config.php');
	$check_existing_user_query = "select username from user where username='$_POST[username]'";
	$check_existing_email_query = "select email from user where username='$_POST[email]'";
	
	if(mysql_num_rows(mysql_query($check_existing_user_query))!=0)
	{
		echo "Sorry, User already exists !";
	}	
	elseif(mysql_num_rows(mysql_query($check_existing_email_query))!=0)
	{
		echo "Sorry, Email-Address already exists !";
	}
	else
	{
		$reg_query = "insert into user(userName,userPass,email) values ('$_POST[username]','$_POST[pass]','$_POST[email]')";
		$query_res = mysql_query($reg_query,$conn);
		
		if ($query_res)
		{
			$uniqueid = mysql_fetch_array(mysql_query("select uid from user where username='$_POST[username]'"));
			if(mysql_query("insert into usertrack(uid) values('$uniqueid[uid]')"))
			{
				echo "Registration Complete<br>You can login <a href=\"./index.php\">Here</a>";
				
			}
		}
		else
		{
			echo "Error in query";
		} 
	}
}
else
{
	?>
	<br><BR>
<center><span style="font-family:Arial;color:#6D84B4;font-size:15px;font-weight:bold;">Already Have an account ? <a href="./index.php">Login Here</a></span></center>
<br>
<form id="form1" name="regform" method="POST" action="register.php">
<div style="margin:auto; width:70%; top:100px; ">
	<table border="0" width="50%" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td class=topblue colspan="2">Profile Details</td>
		</tr>
		<tr>
			<td><br></td>
		</tr>
	<!--registration fields -->
		<tr>
			<td class=acc align="right">Email <span class=reqd>*</span> : </td>
			<td class=acc align="left"><input type="text" name="email"  class="inputfields" onBlur=validation(4)><br></td>
		</tr>
		<tr>
			<td class=acc align="right">Password <span class=reqd>*</span> : </td>
			<td class=acc align="left"><input type="password" name="pass"  class="inputfields" onBlur=validation(4)><br></td>
		</tr>
		<tr>
			<td class=acc align="right">UserName <span class=reqd>*</span> : </td>
			<td class=acc align="left"><input type="text" name="username" class="inputfields" onBlur=validation(4)><br><br></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><br><span style="font-size:10px;padding-left:10px;">Additional details can be filled when you login.</span><br></td>
		</tr>
		<tr>
			<td align="right" style="padding:10px"><br><input type=button class="buttn" value="Reset" onclick="qReset()"><br></td>
			<td align="left" style="padding:10px"><br><input type=button value="Register" class="buttn" name="register" onclick="validation(3)"><br></td>
		</tr>
		<tr>
			<td class=check id=check1 colspan="2"><span class=reqd>*</span>&nbsp;<span style="font-size:10px">Denotes compulsory field</span></td>
		</tr>
		<tr>
			<td class=check id=check2 colspan="2"></td>
		</tr>
	</table>
	</div>
</form>

<?php 
}
?>

</body>

</html>