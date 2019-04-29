<?php
include_once('status.php');

//Nawiązanie połączenia serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$data = htmlentities($_POST['news'], ENT_QUOTES, 'UTF-8');
$tresc = htmlentities($_POST['wydarzenieNews'], ENT_QUOTES, 'UTF-8');
$odb = $_POST['odb'];

//Sprawdzenie, czy w bazie istnieje podana treść
if($result = $mysqli->query("SELECT * FROM news WHERE informacje='$tresc'"))
{
//Sprawdzamy, czy ilość rekordów jest równa 0
	if($result->num_rows == 0)
	{
	   if($data != '' && $tresc != '' && $odb != 0)
	   {
		if($stmt = $mysqli->prepare("INSERT news (data,informacje,odb) VALUES (?,?,?)"))
		{
		  $stmt->bind_param("ssi",$data,$tresc,$odb);
		  $stmt->execute();
		  $stmt->close();
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}
?>
