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
//Nawiązanie połączenia serwerem MySQL.
include_once('db_connect.php');
  
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

$kto=$_SESSION['zalogowany'];
$id_sz = htmlentities($_POST['id'], ENT_QUOTES, 'UTF-8');
$opis = $_POST['nazwaSzkolyEdycja'];
$skrot = $_POST['symbolSzkolyEdycja'];
$typ = $_POST['typSzkolyEdycja'];

//sprawdzenie, czy w bazie istnieje podany przedmiot
if($typ != 'xx')
{
  if($result = $mysqli->query("SELECT * FROM szkoly WHERE opis='$opis'"))
  {
  //zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
	if($result->num_rows == 0)
	{          
	   if($opis == '' && $skrot == '')
	   {
			echo $error = 'Wypełnij wszystkie pola!';
	   } else {
		  if($stmt = $mysqli->prepare("UPDATE szkoly SET opis = ?, skrot = ?, typ = ? WHERE id_sz = ?"))
		  {
				echo 'ok'; 
			   $stmt->bind_param("sssi",$opis,$skrot,$typ,$id_sz);
			   $stmt->execute();
			   $stmt->close(); 
		  } else {
			   echo "Błąd zapytania";
		  }
	   }
	} elseif($result->num_rows == 1)
	{
	   if($skrot == '')
	   {
			echo $error = 'Wypełnij wszystkie pola!';
	   } else {
		  if($stmt = $mysqli->prepare("UPDATE szkoly  SET opis = ?, skrot = ?, typ = ? WHERE id_sz = ?"))
		  {
			   $stmt->bind_param("sssi",$opis,$skrot,$typ,$id_sz);
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
}
?>
</body>
</html>