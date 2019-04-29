<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Klasy
include_once('../class/zapytanie.class.php');

//Zmienne
@$id_kl = $nazwa = htmlentities($_POST['id_kl'], ENT_QUOTES, 'UTF-8');

//Obiekt
$baza = new zapytanie;
$kl = "SELECT klasa, sb FROM vklasy WHERE id_kl='$id_kl'";
$baza->pytanie($kl);
$klasa = $baza->tab[0];
$sb = $baza->tab[1];

echo 'AKTYWNA KLASA: '.$klasa .' '. $sb;

?>