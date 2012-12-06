<?php
session_start();
include('config.php');
?>

<style type=text/css>
pre
{
	font-family:verdana;
	font-size:12px;
}
</style>

<?

// --- insert test scores into dB
$dt = date("Y-m-d G:i:s");
$questionsarr = explode(",",$_GET[questions]);
$questions = count($questionsarr);

$score="$_GET[correct]"."/"."$questions";
mysql_query("insert into reports(subjectid,userid,score,date) values('$_GET[subject]','$_SESSION[uid]','$score','$dt')");

echo "<center><h2>You answered $_GET[correct] answers correctly out of ".$questions."</h2><br><hr noshade color=#cccccc><h3>The answers to the questions asked are :</h3>";




$questions = mysql_query("select * from tests where questionid in($_GET[questions])");

while($row=mysql_fetch_array($questions))
{
	echo "<pre>$row[question]</pre><br>Correct Answer : <b><font color=red>$row[answer]</font></b><hr noshade color=#cccccc>";

}
?>