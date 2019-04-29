<?php
include_once('status.php');
//Nawiązanie połączenia serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$id_st = htmlentities($_POST['st'], ENT_QUOTES, 'UTF-8');
$id = htmlentities($_POST['id'], ENT_QUOTES, 'UTF-8');
$nazwisko = $_POST['nazwisko'];
$imie = $_POST['imie'];
$login = htmlentities($_POST['login'], ENT_QUOTES, 'UTF-8');
$haslo = htmlentities($_POST['passwd'], ENT_QUOTES, 'UTF-8');
$email = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');

//Sprawdzenie ilości znaków w adresie email
if(strlen($email) < 1 )
{
	$email="Brak";
}
//Sprawdzenie, czy w bazie istnieje podany login
if($result = $mysqli->query("SELECT * FROM users WHERE login='$login'"))
{
//Sprawdzenie, czy rekordów jest więcej niż 0
  if($result->num_rows == 0)
  {           
	 if($nazwisko == '' || $imie == '' || $email == '' || $login == '' || $haslo == '')
	 {
		  $error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE users  SET nazwisko = ?, imie = ?, login = ?, haslo = ?, id_st = ? , email = ? WHERE id = ?"))
		{
			 $stmt->bind_param("ssssisi",$nazwisko,$imie,$login,$haslo,$id_st,$email,$id);
			 $stmt->execute();
			 $stmt->close(); 
		} else {
			 echo "Błąd zapytania";
		}
	 }
  } elseif($result->num_rows == 1)
  {
	 if($nazwisko == '' || $imie == '' || $email == '' || $haslo == '')
	 {
		  $error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE users  SET nazwisko = ?, imie = ?, haslo = ?, id_st = ? , email = ? WHERE id = ?"))
		{
			 $stmt->bind_param("sssisi",$nazwisko,$imie,$haslo,$id_st,$email,$id);
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