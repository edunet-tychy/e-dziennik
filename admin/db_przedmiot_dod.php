<?php
include_once('status.php');
include_once('db_connect.php');

//Sprawdzenie stanu połączenia z bazą
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$nazwa = $_POST['przedmiot'];
$skrot = $_POST['skrot'];
$licz_sr = htmlentities($_POST['srednia'], ENT_QUOTES, 'UTF-8');

if($licz_sr == '')
{
	$licz_sr = 0;
}

//Sprawdzenie, czy w bazie istnieje podany przedmiot
if($result = $mysqli->query("SELECT * FROM przedmioty WHERE nazwa='$nazwa'"))
{

	if($result->num_rows == 0)
	{
	   if($nazwa != '' && $skrot != '')
	   {
		if($stmt = $mysqli->prepare("INSERT przedmioty (nazwa,skrot,licz_sr) VALUES (?,?,?)"))
		{
		  $stmt->bind_param("ssi",$nazwa,$skrot,$licz_sr);
		  $stmt->execute();
		  $stmt->close();
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}
?>