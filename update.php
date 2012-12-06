<?php

session_start();
include('config.php');

if($_GET[newname]!="")
{
$updateDispName_q = "update user set displayname=\"$_GET[newname]\" where uid=\"$_SESSION[uid]\"";
mysql_query($updateDispName_q);
}
$_SESSION[displayname]=$_GET[newname];




?>