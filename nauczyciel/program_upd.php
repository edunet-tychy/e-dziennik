<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$id_prog = $_GET['id_prog'];
$tytul = htmlentities($_POST['tytul'], ENT_QUOTES, 'UTF-8');

//sprawdzenie, czy w bazie istnieje podany przedmiot
if($result = $mysqli->query("SELECT * FROM programy WHERE id_prog='$id_prog'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {        
	 if($tytul == '')
	 {
		$error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE programy SET tytul_prog = ? WHERE id_prog = ?"))
		{
		   $stmt->bind_param("si",$tytul,$id_prog);
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