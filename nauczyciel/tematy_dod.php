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
$godz = htmlentities($_POST['godz'], ENT_QUOTES, 'UTF-8');
$data = $_GET['dt'];
$temat = htmlentities($_POST['temat'], ENT_QUOTES, 'UTF-8');
$id_kl = $_GET['id_kl'];
$id_przed = htmlentities($_POST['id_przed'], ENT_QUOTES, 'UTF-8');;
$id_user = $_GET['id'];

if($temat == ''){ $temat = 'x'; }

if($result = $mysqli->query("SELECT * FROM rozklad_realiz WHERE godz='$godz' AND data='$data' AND id_kl='$id_kl' AND id_przed='$id_przed'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 0)
  {
	zapytanie($godz,$data,$temat,$id_kl,$id_przed,$id_user);
  }
}

function zapytanie($godz,$data,$temat,$id_kl,$id_przed,$id_user)
{
 global $mysqli;

  if($godz != 'x' && $data != '' && $temat != 'x' && $id_kl != '' && $id_przed != 'x' && $id_user != '')
  {
	if($stmt = $mysqli->prepare("INSERT rozklad_realiz (godz,data,temat,id_kl,id_przed,id_user) VALUES (?,?,?,?,?,?)"))
	{
	  $stmt->bind_param("issiii",$godz,$data,$temat,$id_kl,$id_przed,$id_user);
	  $stmt->execute();
	  $stmt->close();
	}else {
	  echo 'Błąd: ' . $mysqli->error;
	}
  }
}

?>