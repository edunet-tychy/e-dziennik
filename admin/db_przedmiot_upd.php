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

$id_przed = htmlentities($_POST['id'], ENT_QUOTES, 'UTF-8');
$nazwa = $_POST['przedEdycja'];
$skrot = $_POST['skrotEdycja'];

if(isset($_POST['sredEdycja']))
{
	echo $licz_sr = 1;
} else {
	echo $licz_sr = 0;
}

//sprawdzenie, czy w bazie istnieje podany przedmiot
if($result = $mysqli->query("SELECT * FROM przedmioty WHERE nazwa='$nazwa'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 0)
  {           
	 if($nazwa == '' && $skrot == '')
	 {
		  $error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE przedmioty  SET nazwa = ?, skrot = ?, licz_sr = ? WHERE id_przed = ?"))
		{
			 $stmt->bind_param("ssii",$nazwa,$skrot,$licz_sr,$id_przed);
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
		if($stmt = $mysqli->prepare("UPDATE przedmioty  SET nazwa = ?, skrot = ?, licz_sr = ? WHERE id_przed = ?"))
		{
			 $stmt->bind_param("ssii",$nazwa,$skrot,$licz_sr,$id_przed);
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
</body>
</html>