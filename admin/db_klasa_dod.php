<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połącenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$klasa = htmlentities($_POST['klasa'], ENT_QUOTES, 'UTF-8');
$id_zw = htmlentities($_POST['zawod'], ENT_QUOTES, 'UTF-8');
$id_sz = htmlentities($_POST['id_sz'], ENT_QUOTES, 'UTF-8');
$id_wych = htmlentities($_POST['nauczyciele'], ENT_QUOTES, 'UTF-8');
$id_st = 3;

//Sprawdzenie, czy w bazie istnieje podana klasa
if($result = $mysqli->query("SELECT * FROM klasy WHERE klasa='$klasa' AND id_zw='$id_zw'"))
{
//Sprawdzenie, czy jest 0 rekordów
	if($result->num_rows == 0)
	{
	   if($klasa != '' && $id_wych != 'xx')
	   {
		if($stmt = $mysqli->prepare("INSERT klasy (klasa,id_zw,id_sz,id_wych) VALUES (?,?,?,?)"))
		{
		  $stmt->bind_param("ssss",$klasa,$id_zw,$id_sz,$id_wych);
		  $stmt->execute();
		  $stmt->close();
		}

		if($stmtup = $mysqli->prepare("UPDATE users SET id_st = ? WHERE id = ?"))
		{
			 $stmtup->bind_param("ii",$id_st,$id_wych);
			 $stmtup->execute();
			 $stmtup->close(); 
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}
?>