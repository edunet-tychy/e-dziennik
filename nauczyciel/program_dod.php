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
$tytul = $_POST['tytul'];


if($result = $mysqli->query("SELECT * FROM programy WHERE tytul_prog='$tytul'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 0)
  {
	zapytanie($tytul);
	break;
  }
}

function zapytanie($tytul)
{
 global $mysqli;

  if($tytul != '')
  {
	if($stmt = $mysqli->prepare("INSERT programy (tytul_prog) VALUES (?)"))
	{
	  $stmt->bind_param("s",$tytul);
	  $stmt->execute();
	  $stmt->close();
	}else {
	  echo 'Błąd: ' . $mysqli->error;
	}
  }
}
?>