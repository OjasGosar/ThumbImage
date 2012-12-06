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

.timer {
position:absolute;
z-index:20;
left:5px;
   visibility: hidden;
   text-align: center;
   background-color: #ffffff;
   font-family: Arial;
   font-weight: bold;
   border: 2px outset;
   border-left: 2px outset darkgray;
   border-top: 2px outset darkgray;
}

.timer_pad {
   padding: 10px;
}

.digits {
   margin-top: 15px;
   color: #cccccc;
   font-size: 30pt;
   font-family: Verdana;
}

.title {
   color: #000000;   
}

.btn_cont {
   margin-top: 20px;
}

.start, .pause, .resume {
   margin-right: 5px;
}
</style>

<script language=javascript>
correct=0;

function changeColor(selection)
{
	selection.style.backgroundColor="#3B5998";
	selection.style.color="#FFFFFF";
}

function origColor(selection)
{
	selection.style.backgroundColor="#6D84B4";
	selection.style.color="#000000";
}

function validateAnswer(answer,actual,container)
{
	if(answer.value==actual)
	{
		correct=correct+1;
		<? if($_GET[chapter]!=0)
		echo 'document.getElementById(container).innerHTML = "&nbsp; &nbsp; <img src=./images/good.gif> Congrats ! <b>Right Answer</b> !";';
		?>
	}
	else
	{
		
		<? if($_GET[chapter]!=0)
		echo 'document.getElementById(container).innerHTML = "&nbsp; &nbsp; <img src=./images/bad.gif> <b>Oops ! <b>Wrong Answer</b> !";';
		?>
	}
	answer.parentNode.disabled="true";
}

function checkScore(qs)
{
	var reqURL = "checkscore.php?subject=<? echo $_GET[subject]; ?>&correct="+correct+"&questions="+qs;
	
	window.location=reqURL;
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
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this) onClick='window.location="./tests.php?subject=1"'>Physics</td>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this)></td>
</tr>
<tr>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this) onClick='window.location="./tests.php?subject=2"'>Chemistry</td>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this)></td>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this) onClick='window.location="./tests.php?subject=3"'>Maths</td>
</tr>
<tr>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this)></td>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this) onClick='window.location="./tests.php?subject=4"'>Biology</td>
	<td class="box" onMouseOver=changeColor(this) onMouseOut=origColor(this)></td>
</tr>

</table>
<?
}

// --------- if both subject is set and chapter is not set ---------------------

elseif(isset($_GET[subject]) && !isset($_GET[chapter]))
{
	include('config.php');
	$content = mysql_query("select * from chapters where subjectid='$_GET[subject]'");
	
	echo "<ul>";
	echo "<li><a href='./tests.php?subject=$_GET[subject]&chapter=0'>Take Test From All Chapters</a>";
	
	while($row=mysql_fetch_array($content))
	{
		echo "<li><a href='./tests.php?subject=$_GET[subject]&chapter=$row[chapterid]'>$row[chapter]</a>";
	}
	echo "</ul>";
}

// --------- if both subject and chapter are set ---------------------

elseif(isset($_GET[subject]) && isset($_GET[chapter]))
{
	include('config.php');
	
	if($_GET[chapter]!=0)
		$questions = mysql_query("select * from tests where subjectid='$_GET[subject]' and chapterid='$_GET[chapter]' order by rand() limit 0,10");
	else
		$questions = mysql_query("select * from tests where subjectid='$_GET[subject]' order by rand() limit 0,10");
		?>
		
		<table id="CH_utimer1" class="timer">
<tr>
<td class="timer_pad">
<div class="title">Count-up Timer</div>

<div id="CH_utimer1_digits" class="digits"></div>

<div class="btn_cont">
   <input id="CH_utimer1_start" class="start"
          type="button" value="Start" disabled="disabled" />
   <input id="CH_utimer1_pause" class="pause"
          type="button" value="Pause" disabled="disabled" />
   <input id="CH_utimer1_resume" class="resume"
          type="button" value="Resume" disabled="disabled" />
   <input id="CH_utimer1_reset"
          type="button" value="Reset" disabled="disabled" />
</div>
</td>
</tr>
</table>

<script type="text/javascript" src="coolCount.js"></script>
		
		<?
	echo "<div id=page><pre>";
	$qs=array(); 
	while($row=mysql_fetch_array($questions))
	{

	$qs[] = $row[questionid];
	
		echo "$row[question]
		<br>
		<select>
			<option value='0' onClick='validateAnswer(this,$row[answer],$row[questionid])'>Select Your Answer</option>
			<option value='1' onClick='validateAnswer(this,$row[answer],$row[questionid])'>a</option>
			<option value='2' onClick='validateAnswer(this,$row[answer],$row[questionid])'>b</option>
			<option value='3' onClick='validateAnswer(this,$row[answer],$row[questionid])'>c</option>
			<option value='4' onClick='validateAnswer(this,$row[answer],$row[questionid])'>d</option>
		</select><span id='$row[questionid]'></span>
		<hr noshade color=#e5e5e5>";
	}
	$allqs = implode(",",$qs);
	echo "</pre>";
	
	echo "<input type=button value='Check My Score' onClick=checkScore('$allqs')></div>";
	
}
?>

</center>