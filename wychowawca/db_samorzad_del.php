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

if (isset($_GET['id_sm']) && is_numeric($_GET['id_sm']))
{
	$id_sm=$_GET['id_sm'];
	
	//Usunięcie danych z tabeli SAMORZAD
	if($stmt=$mysqli->prepare("DELETE FROM samorzad WHERE id_sm = ? LIMIT 1"))
	{
		$stmt->bind_param("i", $id_sm);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}
	
 //Przekierowanie do strony z tabelą
 header('location: db_samorzad.php');
} else {
 	header('location: db_samorzad.php');	
}
?>
</body>
</html>
