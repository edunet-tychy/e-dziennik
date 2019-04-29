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
$id_zag = $_GET['id_zag'];
$msc = htmlentities($_POST['miesiac'], ENT_QUOTES, 'UTF-8');
$zagadnienie = htmlentities($_POST['wpis'], ENT_QUOTES, 'UTF-8');
$il_godz = htmlentities($_POST['godz'], ENT_QUOTES, 'UTF-8');

//Sprawdzenie, czy w bazie istnieje podany przedmiot
if($result = $mysqli->query("SELECT * FROM rozklad WHERE id_zag='$id_zag'"))
{
//Zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {        
	 if($msc == '' || $zagadnienie == '' || $il_godz == '')
	 {
		$error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE rozklad SET msc = ?, zagadnienie = ?, il_godz = ? WHERE id_zag = ?"))
		{
		   $stmt->bind_param("isii",$msc,$zagadnienie,$il_godz,$id_zag);
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