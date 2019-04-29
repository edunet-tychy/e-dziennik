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

if (isset($_GET['id_kp']) && is_numeric($_GET['id_kp']))
{
	$id_kp=$_GET['id_kp'];
	
	//Usunięcie danych z tabeli KLASY_PRZEDMIOTY
	if($stmt=$mysqli->prepare("DELETE FROM klasy_przedmioty WHERE id_kp = ? LIMIT 1"))
	{
		$stmt->bind_param("i", $id_kp);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}
	
	//Usunięcie danych z tabeli KLASY_NAUCZYCIELE
	if($stmt=$mysqli->prepare("DELETE FROM klasy_nauczyciele WHERE id_kp = ?"))
	{
		$stmt->bind_param("i", $id_kp);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}
	
 //Przekierowanie do strony z tabelą
 header('location: db_przedmioty.php');
} else {
 	header('location: db_przedmioty.php');	
}
?>
</body>
</html>
