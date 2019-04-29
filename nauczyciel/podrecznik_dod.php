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
$nr_dop = htmlentities($_POST['nr_dop'], ENT_QUOTES, 'UTF-8');
$tytul = $_POST['tytul'];
$autorzy = htmlentities($_POST['autorzy'], ENT_QUOTES, 'UTF-8');
$wydawnictwo = htmlentities($_POST['wyd'], ENT_QUOTES, 'UTF-8');

if($result = $mysqli->query("SELECT * FROM podreczniki WHERE nr_dop='$nr_dop' AND tytul='$tytul' AND autorzy='$autorzy' AND wydawnictwo='$wydawnictwo'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 0)
  {
	zapytanie($nr_dop,$tytul,$autorzy,$wydawnictwo);
  }
}

function zapytanie($nr_dop,$tytul,$autorzy,$wydawnictwo)
{
 global $mysqli;

  if($nr_dop != '' && $tytul != '' && $autorzy != '' && $wydawnictwo != '')
  {
	if($stmt = $mysqli->prepare("INSERT podreczniki (nr_dop,tytul,autorzy,wydawnictwo) VALUES (?,?,?,?)"))
	{
	  $stmt->bind_param("ssss",$nr_dop,$tytul,$autorzy,$wydawnictwo);
	  $stmt->execute();
	  $stmt->close();
	}else {
	  echo 'Błąd: ' . $mysqli->error;
	}
  }
}
?>