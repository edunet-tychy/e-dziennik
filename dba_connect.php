<?php

$host = "";
$uzytkownik = "";
$haslo = "";
$baza = "";

$db_obj = new mysqli($host, $uzytkownik, $haslo, $baza);
mysqli_query($db_obj, "SET NAMES utf8 COLLATE utf8_general_ci");