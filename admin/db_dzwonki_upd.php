<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

for($i=1; $i<16; $i++)
{
  //Zmienne
  $id_godz = $i;
  $nr = htmlentities($_POST['nr'.$i], ENT_QUOTES, 'UTF-8');
  $pocz = htmlentities($_POST['pocz'.$i], ENT_QUOTES, 'UTF-8');
  $kon = htmlentities($_POST['kon'.$i], ENT_QUOTES, 'UTF-8');

  //Wybranie danych z bazy
  if($result = $mysqli->query("SELECT * FROM godziny WHERE id_godz='$id_godz'"))
  {
	//Sprawdzenie, czy w bazie istnieje podana wartość
	if($result->num_rows == 1)
	{ 
	   if(!is_numeric($nr))
	   {
		  $error = 'Wypełnij wszystkie pola!';
	   } else {
		  if($stmt = $mysqli->prepare("UPDATE godziny SET pocz = ?, kon = ?, nr = ? WHERE id_godz = ?"))
		  {
			 $stmt->bind_param("ssii",$pocz,$kon,$nr,$id_godz);
			 $stmt->execute();
			 $stmt->close(); 
		  }
	   }
	}
	
  } else {
	  echo 'Błąd: ' . $mysqli->error;
  }
}
?>