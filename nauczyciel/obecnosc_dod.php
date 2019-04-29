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
$godz = htmlentities($_POST['lek'], ENT_QUOTES, 'UTF-8');
$data = $_POST['wybData'];
$id_kl = $_GET['id_kl'];

//Sprawdzenie, czy przesłana data to sobota lub niedziela
$dzienTygodnia = date("w",strtotime($data));
if($dzienTygodnia == 0 || $dzienTygodnia == 6)
{
  $data = '';
}

$ile = htmlentities($_POST['ile'], ENT_QUOTES, 'UTF-8');

for($i=1; $i<=$ile; $i++)
{
  if(isset($_POST['ucz_'.$i]) && isset($_POST['id_ucz'.$i]) )
  {
	$stan = htmlentities($_POST['ucz_'.$i], ENT_QUOTES, 'UTF-8');
	$id_ucz = htmlentities($_POST['id_ucz'.$i], ENT_QUOTES, 'UTF-8'); 
	
	if($result = $mysqli->query("SELECT * FROM frekwencja WHERE godzina='$godz' AND data='$data' AND id_kl='$id_kl' AND id_ucz='$id_ucz'"))
	{
	//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
	  if ($result->num_rows == 0) {
		zapytanie($data,$godz,$stan,$id_ucz,$id_kl);
	  } elseif ($result->num_rows == 1) {
		zapytUpd($data,$godz,$stan,$id_ucz,$id_kl);
	  }
	}  
  }
}

function zapytanie($data,$godz,$stan,$id_ucz,$id_kl)
{
 global $mysqli;

  if($data != '' && $godz != 'x' && $stan != '' && $id_ucz != '' && $id_kl != '')
  {
	 
	if($stmt = $mysqli->prepare("INSERT frekwencja (data,godzina,stan,id_ucz,id_kl) VALUES (?,?,?,?,?)"))
	{
	  $stmt->bind_param("sisii",$data,$godz,$stan,$id_ucz,$id_kl);
	  $stmt->execute();
	  $stmt->close();
	} else {
	  echo 'Błąd: ' . $mysqli->error;
	}
  }
}

function zapytUpd($data,$godz,$stan,$id_ucz,$id_kl)
{
 global $mysqli;
 
  if($data != '' && $godz != 'x' && $stan != '' && $id_ucz != '' && $id_kl != '')
  {
	if ($stmt = $mysqli->prepare("UPDATE frekwencja SET stan = ? WHERE data = ? AND godzina = ? AND id_ucz = ? AND id_kl = ?")) {	
	  $stmt->bind_param("ssiii",$stan,$data,$godz,$id_ucz,$id_kl);
	  $stmt->execute();
	  $stmt->close();
	} else {
	  echo "Błąd zapytania";
	}	 
  }
}

?>


