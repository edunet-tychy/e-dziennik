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
$od = htmlentities($_POST['odKal'], ENT_QUOTES, 'UTF-8');
$do = htmlentities($_POST['doKal'], ENT_QUOTES, 'UTF-8');
$tresc = $_POST['wydarzenieKal'];

//Sprawdzenie, czy w bazie istnieje podana treść
if($result = $mysqli->query("SELECT * FROM kalendarz WHERE tresc='$tresc'"))
{
//Sprawdzamy, czy ilość rekordów jest równa 0
	if($result->num_rows == 0)
	{
	   if($od != '' && $do != '' && $tresc != '')
	   {
		if($stmt = $mysqli->prepare("INSERT kalendarz (od,do,tresc) VALUES (?,?,?)"))
		{
		  $stmt->bind_param("sss",$od,$do,$tresc);
		  $stmt->execute();
		  $stmt->close();
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}
?>
