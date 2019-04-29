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
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');
 
//Sprawdzenie nawiązania połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
	$id=$_GET['id'];
	
	//Usunięcie ucznia z tabeli USERS
	if($stmt=$mysqli->prepare("DELETE FROM users WHERE id = ? LIMIT 1"))
	{
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}
	
	//Wyszukanie id_ucz z tabeli UCZEN
	$query = "SELECT id_ucz FROM uczen WHERE id_user='$id'";
	
	if(!$result = $mysqli->query($query)){
	   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	   $mysqli->close();
	}
	
	$row = $result->fetch_row();
	$id_ucz =	$row[0];
	
	//Usunięcie ucznia z tabeli UCZEN
	if($stmt=$mysqli->prepare("DELETE FROM uczen WHERE id_ucz = ? LIMIT 1"))
	{
		$stmt->bind_param("i", $id_ucz);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}	

 	//Wyszukanie id_rodz z tabeli RODZICE
	$query = "SELECT id_rodz FROM rodzice WHERE id_ucz='$id_ucz'";	 
	
	if(!$result = $mysqli->query($query)){
	   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	   $mysqli->close();
	}
	$row = $result->fetch_row();
	$id_rodz =	$row[0];

	//Usunięcie wpisów  z tabeli RODZICE
	if($stmt=$mysqli->prepare("DELETE FROM rodzice WHERE id_rodz = ? LIMIT 1"))
	{
		$stmt->bind_param("i", $id_rodz);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}

 	//Wyszukanie id_rodz z tabeli RODZIC
	$query = "SELECT id_ad, id_tel, id_user FROM rodzic WHERE id_rodz='$id_rodz'";

	if(!$result = $mysqli->query($query)){
	   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	   $mysqli->close();
	}
	$row = $result->fetch_row();
	$id_ad =	$row[0];
	$id_tel =	$row[1];
	$id_user =	$row[2];
	
	//Usunięcie wpisów  z tabeli RODZIC
	if($stmt=$mysqli->prepare("DELETE FROM rodzic WHERE id_rodz = ? LIMIT 1"))
	{
		$stmt->bind_param("i", $id_rodz);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}

	//Usunięcie wpisów  z tabeli ADRESY
	if($stmt=$mysqli->prepare("DELETE FROM adresy WHERE id_ad = ? LIMIT 1"))
	{
		$stmt->bind_param("i", $id_ad);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}
	
	//Usunięcie wpisów  z tabeli TELEFONY
	if($stmt=$mysqli->prepare("DELETE FROM telefony WHERE id_tel = ? LIMIT 1"))
	{
		$stmt->bind_param("i", $id_tel);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}
	
	//Usunięcie rodzica z tabeli USERS
	if($stmt=$mysqli->prepare("DELETE FROM users WHERE id = ? LIMIT 1"))
	{
		$stmt->bind_param("i", $id_user);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}

 //przekierowanie do strony z tabelą
 header('location: db_uczen.php');
} else {
 header('location: db_uczen.php');	
}
?>
</body>
</html>
