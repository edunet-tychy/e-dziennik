<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
</head>
<body>

<?php
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');
 
//Sprawdzenie nawiązania połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

$id_uw = htmlentities($_POST['id_uw'], ENT_QUOTES, 'UTF-8');
$data = htmlentities($_POST['data'], ENT_QUOTES, 'UTF-8');
$tresc = htmlentities($_POST['tresc'], ENT_QUOTES, 'UTF-8');
$id_ucz = htmlentities($_POST['uczen'], ENT_QUOTES, 'UTF-8');
$id_naucz = $_SESSION['id_db'];
$id_kl = $_SESSION['id_kl'];

//sprawdzenie, czy w bazie istnieje podany przedmiot
if($result = $mysqli->query("SELECT * FROM uwagi WHERE id_uw='$id_uw'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {      
	 if($data == '' || $tresc == '' || $id_ucz == '' || $id_naucz == '' || $id_kl == '')
	 {
		$error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE uwagi SET data = ?, tresc = ? , id_ucz = ?, id_naucz = ?, id_kl = ? WHERE id_uw = ?"))
		{
		   $stmt->bind_param("ssiiii",$data,$tresc,$id_ucz,$id_naucz,$id_kl,$id_uw);
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
</body>
</html>