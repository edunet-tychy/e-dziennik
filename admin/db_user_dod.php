<?php
include_once('status.php');

//Nawiązanie połączenia serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL 
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$nazwisko = $_POST['nazwisko'];
$imie = $_POST['imie'];
$email = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
$login = htmlentities($_POST['login'], ENT_QUOTES, 'UTF-8');
$pass = htmlentities($_POST['passwd'], ENT_QUOTES, 'UTF-8');
$id_st = htmlentities($_POST['st'], ENT_QUOTES, 'UTF-8');

//Szyfrowanie hasła
//$haslo = crypt($pass);

//Testowo - brak szyfrowania
$haslo = $pass;

if($email == '')
{
  $email = 'Brak';
}
//sprawdzenie, czy w bazie istnieje podany login
if($result = $mysqli->query("SELECT * FROM users WHERE login='$login'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 0)
  {
	 if($nazwisko != '' && $imie != '' && $login != '' && $haslo != '' && $id_st != '')
	 {
	  if($stmt = $mysqli->prepare("INSERT users (nazwisko,imie,login,haslo,id_st,email) VALUES (?,?,?,?,?,?)"))
	  {
		$stmt->bind_param("ssssis",$nazwisko,$imie,$login,$haslo,$id_st,$email);
		$stmt->execute();
		$stmt->close();
	  }
	 }
  }
} else {
	echo 'Błąd: ' . $mysqli->error;
}
$mysqli->close();
?>