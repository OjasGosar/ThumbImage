<?php

include('config.php');

$reports = mysql_query("select subjectid,score,date from reports order by date desc");
$subjects = array("","Physics","Chemistry","Maths","Biology"); 

?>

<table border=1 cellpadding=5px cellspacing=0>
<tr><th>Subject</th><th>Date</th><th>Score</th></tr>
<h2>You have given <? echo mysql_num_rows($reports) ?> tests till date</h2>

Details are as follows :<br>

<?
while($row=mysql_fetch_array($reports))
{
$sub=$row[subjectid];
	echo "<tr><td>$subjects[$sub]</td><td>$row[date]</td><td>$row[score]</td></tr>";
}

echo "</table>";

?>