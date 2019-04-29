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
$login = htmlentities($_GET['login'], ENT_QUOTES, 'UTF-8');
$noweHaslo = htmlentities($_GET['passwd'], ENT_QUOTES, 'UTF-8');

//Sprawdzenie, czy w bazie istnieje podany login
if($result = $mysqli->query("SELECT haslo, login FROM users WHERE id='$id'"))
{
	
	$row = $result->fetch_row();
    $db_haslo = $row[0];
	$db_login = $row[1];

	if((strlen($noweHaslo)>7) && ($db_login == $login))
	{
		if($stmt = $mysqli->prepare("UPDATE users  SET haslo = ? WHERE id = ?"))
		{
			 $stmt->bind_param("si",$noweHaslo,$id);
			 $stmt->execute();
			 $stmt->close(); 
		} else {
			 echo "Błąd zapytania";
		}
	} elseif ((strlen($noweHaslo)>7) && ($db_login != $login)) {
		
		if($stmt = $mysqli->prepare("UPDATE users  SET haslo = ?,login = ? WHERE id = ?"))
		{
			 $stmt->bind_param("ssi",$noweHaslo,$login,$id);
			 $stmt->execute();
			 $stmt->close(); 
		} else {
			 echo "Błąd zapytania";
		}		
	}
	
} else {
	echo 'Błąd: ' . $mysqli->error;
}

?>