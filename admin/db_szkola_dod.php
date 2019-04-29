<?php
include_once('status.php');
include_once('db_connect.php');

//Sprawdzenie stanu połączenia z bazą
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$opis = $_POST['nazwaSzkoly'];
$skrot = $_POST['symbolSzkoly'];
$typ = $_POST['typSzkoly'];

//Sprawdzenie, czy w bazie istnieje podana szkoła
if($result = $mysqli->query("SELECT * FROM szkoly WHERE opis='$opis'"))
{
	if($result->num_rows == 0)
	{
	   if($opis != '' && $skrot != '' && $typ != 'x')
	   {
		if($stmt = $mysqli->prepare("INSERT szkoly (opis,skrot,typ) VALUES (?,?,?)"))
		{
		  $stmt->bind_param("sss",$opis,$skrot,$typ);
		  $stmt->execute();
		  $stmt->close();
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}
?>