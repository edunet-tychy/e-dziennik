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
$id_kl = $_GET['id_kl'];

if (isset($_GET['id_zag']) && is_numeric($_GET['id_zag']))
{
	$id_zag=$_GET['id_zag'];
	
	//Usunięcie danych z tabeli KLASY_NAUCZYCIELE
	if($stmt=$mysqli->prepare("DELETE FROM rozklad WHERE id_zag = ?"))
	{
		$stmt->bind_param("i", $id_zag);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}
	
 //Przekierowanie do strony z tabelą
 header('location: rozklad_dane.php?id_kl='.$id_kl);
} else {
 	header('location: rozklad_dane.php?id_kl='.$id_kl);	
}
?>
