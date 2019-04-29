<?php
include_once('status.php');

//Nawiązanie połączenia serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienna
$db_login=$_GET['login'];

if($result = $mysqli->query("SELECT * FROM users WHERE login='$db_login'"))
{
  //Sprawdzenie, czy liczba rekordów jest większa od 0
  if($result->num_rows > 0)
  {
	echo '<p id="OdpLogin">Taki login już istnieje!</p>';
  }
} else {
	echo 'Błąd: ' . $mysqli->error;
}

$mysqli->close();
?>