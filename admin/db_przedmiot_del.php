<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
</head>
<?php
//Nawiązanie połączenia serwerem MySQL.
include_once('db_connect.php');
  
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

$kto=$_SESSION['zalogowany'];
$query = "SELECT nazwisko, imie, id_st FROM users WHERE login='$kto'";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
	$id=$_GET['id'];
	if($stmt=$mysqli->prepare("DELETE FROM przedmioty WHERE id_przed = ? LIMIT 1"))
	{
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}
 //zamykamy połączenie z bazą danych
 $mysqli->close();
 
 //przekierowanie do strony z tabelą
 header('location: db_przedmioty.php');
} else {
 	header('location: db_przedmioty.php');	
}
?>
</body>
</html>
