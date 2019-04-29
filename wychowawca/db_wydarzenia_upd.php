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

$id_kl = $_SESSION['id_kl'];

$id_wyd = htmlentities($_POST['id_wyd'], ENT_QUOTES, 'UTF-8');
$data = htmlentities($_POST['data'], ENT_QUOTES, 'UTF-8');
$informacje = htmlentities($_POST['informacje'], ENT_QUOTES, 'UTF-8');

//sprawdzenie, czy w bazie istnieje podany przedmiot
if($result = $mysqli->query("SELECT * FROM wydarzenia WHERE id_wyd='$id_wyd'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {      
	 if($data == '' || $informacje == '')
	 {
		$error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE wydarzenia SET data = ?, informacje = ? WHERE id_wyd = ?"))
		{
		   $stmt->bind_param("ssi",$data,$informacje,$id_wyd);
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