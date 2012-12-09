<?php

$server = "127.0.0.1";
$user = "root";
$pass = "";
$dbname = "dbproject";

$conn = mysql_connect($server,$user,$pass);
//echo '$conn = ' .$conn;
if(!$conn)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db($dbname,$conn);

?>