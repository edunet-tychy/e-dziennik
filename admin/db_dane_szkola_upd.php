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
$id = htmlentities($_POST['id'], ENT_QUOTES, 'UTF-8');
$opis = $_POST['pelnaNazwaSzkolyEdycja'];
$ulica = $_POST['ulicaSzkolyEdycja'];
$kod = htmlentities($_POST['kodSzkolyEdycja'], ENT_QUOTES, 'UTF-8');
$miasto = $_POST['miastoSzkolyEdycja'];
$telefon = htmlentities($_POST['telefonSzkolyEdycja'], ENT_QUOTES, 'UTF-8');
$email = htmlentities($_POST['emailSzkolyEdycja'], ENT_QUOTES, 'UTF-8');
$nip = htmlentities($_POST['nipSzkolyEdycja'], ENT_QUOTES, 'UTF-8');
$regon = htmlentities($_POST['regonSzkolyEdycja'], ENT_QUOTES, 'UTF-8');

//Sprawdzenie, czy w bazie istnieje podany przedmiot
if($result = $mysqli->query("SELECT * FROM dane_szkoly WHERE id='$id'"))
{
//Sprawdzenie, czy w bazie jest jeden rekord
  if($result->num_rows == 1)
  {          
	 if($opis == '' && $ulica == '' && $kod == '' && $miasto == '' && $telefon == '' && $email == '' && $nip == '' && $regon == '')
	 {
		  echo $error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE dane_szkoly SET opis = ?, ulica = ?, kod = ?, miasto = ?, telefon = ?, email = ?, nip = ?, regon = ? WHERE id = ?"))
		{
			 $stmt->bind_param("ssssssssi",$opis,$ulica,$kod,$miasto,$telefon,$email,$nip,$regon,$id);
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