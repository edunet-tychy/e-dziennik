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

if (isset($_GET['id_klpr']) && is_numeric($_GET['id_klpr']))
{
	$id_klpr=$_GET['id_klpr'];
	
	//Usunięcie danych z tabeli KLASY_NAUCZYCIELE
	if($stmt=$mysqli->prepare("DELETE FROM klasy_programy WHERE id_klpr = ?"))
	{
		$stmt->bind_param("i", $id_klpr);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}
	
 //Przekierowanie do strony z tabelą
 header('location: program.php?id_kl='.$id_kl);
} else {
 	header('location: program.php?id_kl='.$id_kl);	
}
?>