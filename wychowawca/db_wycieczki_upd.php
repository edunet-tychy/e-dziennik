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

//Zmienne
$id_wyk = htmlentities($_POST['id_wyk'], ENT_QUOTES, 'UTF-8');
$data = htmlentities($_POST['data'], ENT_QUOTES, 'UTF-8');
$czas = htmlentities($_POST['czas'], ENT_QUOTES, 'UTF-8');
$ilu_uczniow = htmlentities($_POST['liczba'], ENT_QUOTES, 'UTF-8');
$dokad = htmlentities($_POST['cel'], ENT_QUOTES, 'UTF-8');
$id_user = htmlentities($_POST['nauczyciel'], ENT_QUOTES, 'UTF-8');
$id_kl = $_SESSION['id_kl'];

//sprawdzenie, czy w bazie istnieje podany przedmiot
if($result = $mysqli->query("SELECT * FROM wycieczki WHERE id_wyk='$id_wyk'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {      
	 if($data == '' || $czas == '' || $ilu_uczniow == '' || $dokad == '' || $id_user == '')
	 {
		$error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE wycieczki SET data = ?, czas = ? , ilu_uczniow = ?, dokad = ?, id_user = ? WHERE id_wyk = ?"))
		{
		   $stmt->bind_param("ssisii",$data,$czas,$ilu_uczniow,$dokad,$id_user,$id_wyk);
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