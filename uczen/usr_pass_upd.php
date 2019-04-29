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
$id = htmlentities($_GET['id'], ENT_QUOTES, 'UTF-8');
$st = htmlentities($_GET['st'], ENT_QUOTES, 'UTF-8');
$login = htmlentities($_GET['logon'], ENT_QUOTES, 'UTF-8');
$hasloStare = htmlentities($_GET['passwdStary'], ENT_QUOTES, 'UTF-8');
$noweHaslo = htmlentities($_GET['passwd'], ENT_QUOTES, 'UTF-8');
$hasloPow = htmlentities($_GET['passwdPow'], ENT_QUOTES, 'UTF-8');
$email = htmlentities($_GET['email'], ENT_QUOTES, 'UTF-8');

//Sprawdzenie ilośći znaków w adresie email
if(strlen($email) < 1 )
{
	$email="Brak";
}
//Sprawdzenie, czy w bazie istnieje podany login
if($result = $mysqli->query("SELECT haslo, login FROM users WHERE id='$id'"))
{
	
	$row = $result->fetch_row();
    $db_haslo = $row[0];
	$db_login = $row[1];

	if(($db_haslo == $hasloStare) && (strlen($noweHaslo)>7) && ($db_login == $login))
	{
		if($stmt = $mysqli->prepare("UPDATE users  SET haslo = ?, email = ? WHERE id = ?"))
		{
			 $stmt->bind_param("ssi",$noweHaslo,$email,$id);
			 $stmt->execute();
			 $stmt->close(); 
		} else {
			 echo "Błąd zapytania";
		}
	}
	
	if(($db_haslo == $noweHaslo) && ($db_login == $login))
	{
		echo "Zmiany zostały wprowadzone.";
	} else {
		echo "<br>Wprowadzono błędne dane!";
	}
	
} else {
	echo 'Błąd: ' . $mysqli->error;
}

?>