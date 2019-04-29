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

$id_kal = htmlentities($_POST['id'], ENT_QUOTES, 'UTF-8');
$od = htmlentities($_POST['odKal'], ENT_QUOTES, 'UTF-8');
$do = htmlentities($_POST['doKal'], ENT_QUOTES, 'UTF-8');
$tresc = $_POST['wydarzenieKal'];

//sprawdzenie, czy w bazie istnieje podany przedmiot
if($result = $mysqli->query("SELECT * FROM kalendarz WHERE id_kal='$id_kal'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {
	 if($tresc == '' || $od == '' || $do == '')
	 {
		  echo $error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE kalendarz  SET tresc = ?, od = ?, do = ? WHERE id_kal = ?"))
		{
			 $stmt->bind_param("sssi",$tresc,$od,$do,$id_kal);
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