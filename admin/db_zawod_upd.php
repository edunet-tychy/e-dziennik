<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połaczenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$id_zw = htmlentities($_POST['id'], ENT_QUOTES, 'UTF-8');
$nazwa = $_POST['nazwaZawoduEdycja'];
$symbol = htmlentities($_POST['symbolZawoduEdycja'], ENT_QUOTES, 'UTF-8');
$sb = htmlentities($_POST['skrotZawoduEdycja'], ENT_QUOTES, 'UTF-8');

//Sprawdzenie, czy w bazie istnieje podany zawod
if($result = $mysqli->query("SELECT * FROM zawod WHERE id_zw='$id_zw'"))
{
//Zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {          
	 if($nazwa == '' && $symbol == '' && $sb == '')
	 {
		  echo $error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE zawod SET nazwa = ?, symbol = ?, sb = ? WHERE id_zw = ?"))
		{
			 $stmt->bind_param("sssi",$nazwa,$symbol,$sb,$id_zw);
			 $stmt->execute();
			 $stmt->close(); 
		} else {
			 echo "Błąd zapytania";
		}
	 }
  }
} else {
	echo 'Błąd: ' . $mysqli->error;
}
?>