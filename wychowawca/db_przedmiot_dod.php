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

$id_kl = $_SESSION['id_kl'];
$id_przed = htmlentities($_POST['przedmiot'], ENT_QUOTES, 'UTF-8');
$naucz1 = htmlentities($_POST['nauczyciel1'], ENT_QUOTES, 'UTF-8');
$naucz2 = htmlentities($_POST['nauczyciel2'], ENT_QUOTES, 'UTF-8');

//PRZEDMIOT
//sprawdzenie, czy w bazie istnieje podane zestawienie przedmiotu i klasy
if($result = $mysqli->query("SELECT * FROM klasy_przedmioty WHERE id_przed='$id_przed' AND id_kl='$id_kl'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
	if($result->num_rows == 0)
	{
	   if($id_przed != 'x' && $id_kl != 'x' && $naucz1 != 'x')
	   {
		if($stmt = $mysqli->prepare("INSERT klasy_przedmioty (id_przed,id_kl) VALUES (?,?)"))
		{
		  $stmt->bind_param("ii",$id_przed,$id_kl);
		  $stmt->execute();
		  $stmt->close();
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}

//Dane z tabeli KLASY-PRZEDMIOTY
$kp = "SELECT id_kp FROM klasy_przedmioty WHERE id_przed='$id_przed' AND id_kl='$id_kl'";

if(!$zapytanie = $mysqli->query($kp)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}

$wynik = $zapytanie->fetch_row();
$id_kp = $wynik[0];

//NAUCZYCIEL I
//sprawdzenie, czy w bazie istnieje podane zestawienie nauczyciel-klasa-przedmiot
if($result = $mysqli->query("SELECT * FROM klasy_nauczyciele WHERE id_kp='$id_kp' AND id_naucz='$naucz1'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
	if($result->num_rows == 0)
	{
	   if($id_kp != '' && $naucz1 != '' && $naucz1 != 0)
	   {
		if($stmt = $mysqli->prepare("INSERT klasy_nauczyciele (id_kp,id_naucz) VALUES (?,?)"))
		{
		  $stmt->bind_param("ii",$id_kp,$naucz1);
		  $stmt->execute();
		  $stmt->close();
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}

//NAUCZYCIEL II
//sprawdzenie, czy w bazie istnieje podane zestawienie nauczyciel-klasa-przedmiot
if($result = $mysqli->query("SELECT * FROM klasy_nauczyciele WHERE id_kp='$id_kp' AND id_naucz='$naucz2'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
	if($result->num_rows == 0)
	{
	   if($id_kp != '' && $naucz2 != '' && $naucz2 != 0)
	   {
		if($stmt = $mysqli->prepare("INSERT klasy_nauczyciele (id_kp,id_naucz) VALUES (?,?)"))
		{
		  $stmt->bind_param("ii",$id_kp,$naucz2);
		  $stmt->execute();
		  $stmt->close();
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}
?>
</body>
</html>