<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

echo $id_tem = $_GET['id_tem'];
echo $temat = htmlentities($_POST['temat'], ENT_QUOTES, 'UTF-8');

if($temat != '')
{
  //sprawdzenie, czy w bazie istnieje podany przedmiot
  if($result = $mysqli->query("SELECT * FROM rozklad_realiz WHERE id_tem='$id_tem'"))
  {
  //zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
	if($result->num_rows == 1)
	{        
	  if($stmt = $mysqli->prepare("UPDATE rozklad_realiz SET temat = ? WHERE id_tem = ?"))
	  {
		 $stmt->bind_param("ii",$temat,$id_tem);
		 $stmt->execute();
		 $stmt->close();
	  } else {
		 echo "Błąd zapytania";
	  }
	}
  } else {
	echo 'Błąd: ' . $mysqli->error;
  }	
}



?>