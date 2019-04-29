<?php

$server='sqlhosting5';
$user='edunet_dziennik';
$pass='alinka@12';
$db='edunet_dziennik';

$mysqli = new MySQLi($server,$user,$pass,$db);
mysqli_query($mysqli, "SET NAMES utf8 COLLATE utf8_general_ci");