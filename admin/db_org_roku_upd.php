<?php
include_once('status.php');
include_once('db_connect.php');

//Sprawdzenie stanu połączenia z bazą
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

for($i=1; $i<12; $i++)
{
  //Zmienne
  $id_rszk = $i;
  $wydarzenie = $_POST['wydarzenie'.$i];
  $od = htmlentities($_POST['od'.$i], ENT_QUOTES, 'UTF-8');
  $do = htmlentities($_POST['do'.$i], ENT_QUOTES, 'UTF-8');

  //Sprawdzenie, czy w bazie istnieje podana treść
  if($result = $mysqli->query("SELECT * FROM org_roku_szkol WHERE id_rszk='$id_rszk'"))
  {
	if($result->num_rows == 1)
	{ 
	   if(!is_numeric($id_rszk))
	   {
			$error = 'Wypełnij wszystkie pola!';
	   } else {
		  if($stmt = $mysqli->prepare("UPDATE org_roku_szkol SET wydarzenie = ?, od = ?, do = ? WHERE id_rszk = ?"))
		  {
			 $stmt->bind_param("sssi",$wydarzenie,$od,$do,$id_rszk);
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