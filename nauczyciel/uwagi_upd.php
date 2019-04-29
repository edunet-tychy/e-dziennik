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
$id_uw = $_GET['id_uw'];
$id_ucz = htmlentities($_POST['uczen'], ENT_QUOTES, 'UTF-8');
$tresc = htmlentities($_POST['tresc'], ENT_QUOTES, 'UTF-8');

if($result = $mysqli->query("SELECT * FROM uwagi WHERE id_uw='$id_uw'"))
{
  if($result->num_rows == 1)
  {
	 if($id_ucz == '0' || $tresc == '')
	 {
		$error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE uwagi SET id_ucz = ?, tresc = ? WHERE id_uw = ?"))
		{
		   $stmt->bind_param("isi",$id_ucz,$tresc,$id_uw);
		   $stmt->execute();
		   $stmt->close();
		} else {
		   echo "Błąd zapytania";
		}
	 }
  }
} else {
	echo 'Błąd: ' . $mysqli->error;
}
?>