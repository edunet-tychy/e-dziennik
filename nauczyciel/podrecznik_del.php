<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienna
$id_kl = $_GET['id_kl'];

if (isset($_GET['id_pod']) && is_numeric($_GET['id_pod']))
{
	$id_pod=$_GET['id_pod'];
	
	if($stmt=$mysqli->prepare("DELETE FROM klasy_podreczniki WHERE id_pod = ?"))
	{
		$stmt->bind_param("i", $id_pod);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}
	
 //Przekierowanie do strony z tabelą
 header('location: podrecznik.php?id_kl='.$id_kl);
} else {
 	header('location: podrecznik.php?id_kl='.$id_kl);	
}
?>