<?php

$server='';
$user='';
$pass='';
$db='';

$mysqli = new MySQLi($server,$user,$pass,$db);
mysqli_query($mysqli, "SET NAMES utf8 COLLATE utf8_general_ci");