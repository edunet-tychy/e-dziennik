<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL.
include_once('db_connect.php');
  
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
	echo $id=$_GET['id'];
	if($stmt=$mysqli->prepare("DELETE FROM zawod WHERE id_zw = ? LIMIT 1"))
	{
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}
 //zamykamy połączenie z bazą danych
 $mysqli->close();
 
 //przekierowanie do strony z tabelą
 header('location: db_zawod.php');
} else {
 	header('location: db_zawod.php');	
}
?>
