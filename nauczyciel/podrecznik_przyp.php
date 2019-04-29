<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$id_pod= htmlentities($_POST['podr'], ENT_QUOTES, 'UTF-8');
$id_przed = htmlentities($_POST['przedmiot'], ENT_QUOTES, 'UTF-8');
$id_kl=$_GET['id_kl']; 

if($result = $mysqli->query("SELECT * FROM klasy_podreczniki WHERE id_pod='$id_pod' AND id_przed='$id_przed' AND id_kl='$id_kl'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 0)
  {
	zapytanie($id_pod,$id_przed,$id_kl);  
  }
}

function zapytanie($id_pod,$id_przed,$id_kl)
{
 global $mysqli;

  if($id_pod != 0 && $id_przed != 0 && $id_kl != '')
  {
	if($stmt = $mysqli->prepare("INSERT klasy_podreczniki (id_pod,id_przed,id_kl) VALUES (?,?,?)"))
	{
	  $stmt->bind_param("iii",$id_pod,$id_przed,$id_kl);
	  $stmt->execute();
	  $stmt->close();
	}else {
	  echo 'Błąd: ' . $mysqli->error;
	}
  }
}
?>