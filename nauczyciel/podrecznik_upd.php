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
$id_pod = $_GET['id_pod'];
$nr_dop = htmlentities($_POST['nr_dop'], ENT_QUOTES, 'UTF-8');
$tytul = $_POST['tytul'];
$autorzy = htmlentities($_POST['autorzy'], ENT_QUOTES, 'UTF-8');
$wydawnictwo = htmlentities($_POST['wyd'], ENT_QUOTES, 'UTF-8');

//sprawdzenie, czy w bazie istnieje podany przedmiot
if($result = $mysqli->query("SELECT * FROM podreczniki WHERE id_pod='$id_pod'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {        
	 if($nr_dop == '' || $tytul == '' || $autorzy == '' || $wydawnictwo == '')
	 {
		$error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE podreczniki SET nr_dop = ?, tytul = ?, autorzy = ?, wydawnictwo = ? WHERE id_pod = ?"))
		{
		   $stmt->bind_param("ssssi",$nr_dop,$tytul,$autorzy,$wydawnictwo,$id_pod);
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