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
$opis = htmlentities($_POST['pelnaNazwaSzkolyEdycja'], ENT_QUOTES, 'UTF-8');
$ulica = htmlentities($_POST['ulicaSzkolyEdycja'], ENT_QUOTES, 'UTF-8');
$kod = htmlentities($_POST['kodSzkolyEdycja'], ENT_QUOTES, 'UTF-8');
$miasto = htmlentities($_POST['miastoSzkolyEdycja'], ENT_QUOTES, 'UTF-8');
$telefon = htmlentities($_POST['telefonSzkolyEdycja'], ENT_QUOTES, 'UTF-8');
$email = htmlentities($_POST['emailSzkolyEdycja'], ENT_QUOTES, 'UTF-8');
$nip = htmlentities($_POST['nipSzkolyEdycja'], ENT_QUOTES, 'UTF-8');
$regon = htmlentities($_POST['regonSzkolyEdycja'], ENT_QUOTES, 'UTF-8');

         
if($opis == '' && $ulica == '' && $kod == '' && $miasto == '' && $telefon == '' && $email == '' && $nip == '' && $regon == '')
{
	echo $error = 'Wypełnij wszystkie pola!';
} else {
  if($stmt = $mysqli->prepare("INSERT dane_szkoly (opis,ulica,kod,miasto,telefon,email,nip,regon) VALUES (?,?,?,?,?,?,?,?)"))
  {
	   $stmt->bind_param("ssssssss",$opis,$ulica,$kod,$miasto,$telefon,$email,$nip,$regon);
	   $stmt->execute();
	   $stmt->close(); 
  } else {
	   echo "Błąd zapytania";
  }
}

?>