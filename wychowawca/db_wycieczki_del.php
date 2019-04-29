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

if (isset($_GET['id_wyk']) && is_numeric($_GET['id_wyk']))
{
	$id_wyk=$_GET['id_wyk'];
	
	//Usunięcie danych z tabeli SAMORZAD
	if($stmt=$mysqli->prepare("DELETE FROM wycieczki WHERE id_wyk = ? LIMIT 1"))
	{
		$stmt->bind_param("i", $id_wyk);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}
	
 //Przekierowanie do strony z tabelą
 header('location: db_wycieczki_dane.php');
} else {
 	header('location: db_wycieczki_dane.php');	
}
?>
</body>
</html>
