<?php
include_once('status.php');

//Nawiązanie połączenia serwerem MySQL.
include_once('db_connect.php');

if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$nazwa = $_POST['nazwaZawodu'];
$symbol = htmlentities($_POST['symbolZawodu'], ENT_QUOTES, 'UTF-8');
$sb = htmlentities($_POST['skrotZawodu'], ENT_QUOTES, 'UTF-8');

//sprawdzenie, czy w bazie istnieje podany zawod
if($result = $mysqli->query("SELECT * FROM zawod WHERE nazwa='$nazwa'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
	if($result->num_rows == 0)
	{
		
	   if($nazwa != '' && $symbol != '' && $sb != 'x')
	   {
		if($stmt = $mysqli->prepare("INSERT zawod (nazwa,symbol,sb) VALUES (?,?,?)"))
		{
		  $stmt->bind_param("sss",$nazwa,$symbol,$sb);
		  $stmt->execute();
		  $stmt->close();
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}

?>