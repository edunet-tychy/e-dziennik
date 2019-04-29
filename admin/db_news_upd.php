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

$id_news = htmlentities($_POST['id'], ENT_QUOTES, 'UTF-8');
$data = htmlentities($_POST['news'], ENT_QUOTES, 'UTF-8');
$tresc = htmlentities($_POST['wydarzenieNews'], ENT_QUOTES, 'UTF-8');
$odb = $_POST['odb'];

//sprawdzenie, czy w bazie istnieje podany przedmiot
if($result = $mysqli->query("SELECT * FROM news WHERE id_news='$id_news'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {
	 if($tresc == '' || $data == '' || $odb == 0)
	 {
		  echo $error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE news SET informacje = ?, data = ?, odb = ? WHERE id_news = ?"))
		{
			 $stmt->bind_param("ssii",$tresc,$data,$odb,$id_news);
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