<?php

$host = "sqlhosting5";
$uzytkownik = "edunet_dziennik";
$haslo = "alinka@12";
$baza = "edunet_dziennik";

$db_obj = new mysqli($host, $uzytkownik, $haslo, $baza);
mysqli_query($db_obj, "SET NAMES utf8 COLLATE utf8_general_ci");