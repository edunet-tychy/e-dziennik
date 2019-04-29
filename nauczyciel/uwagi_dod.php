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
$data = date('Y-m-d');
$tresc = htmlentities($_POST['tresc'], ENT_QUOTES, 'UTF-8');
$id_ucz = htmlentities($_POST['uczen'], ENT_QUOTES, 'UTF-8');
$id_naucz = $_SESSION['id_db'];
$id_kl = $_GET['id_kl'];

if($id_ucz=='x') {$id_ucz = '';}

zapytanie($data,$tresc,$id_ucz,$id_naucz,$id_kl);

//Funkcja - Uwaga
function zapytanie($data,$tresc,$id_ucz,$id_naucz,$id_kl)
{
  global $mysqli;
 
  if($result = $mysqli->query("SELECT * FROM uwagi WHERE tresc='$tresc' AND id_ucz='$id_ucz' AND id_naucz='$id_naucz' AND id_kl='$id_kl'"))
  {
	if($result->num_rows == 0)
	{
	  if($data != '' && $tresc != '' && $id_ucz != '' && $id_naucz != '' && $id_kl != '')
	  {
		if($stmt = $mysqli->prepare("INSERT uwagi (data,tresc,id_ucz,id_naucz,id_kl) VALUES (?,?,?,?,?)"))
		{
		  $stmt->bind_param("ssiii",$data,$tresc,$id_ucz,$id_naucz,$id_kl);
		  $stmt->execute();
		  $stmt->close();
		}
	  }
	} 
  }	
}

?>