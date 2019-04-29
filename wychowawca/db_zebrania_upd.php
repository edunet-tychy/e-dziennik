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

$id_zeb = htmlentities($_POST['id_zeb'], ENT_QUOTES, 'UTF-8');
$data = htmlentities($_POST['data'], ENT_QUOTES, 'UTF-8');
$tresc = htmlentities($_POST['tresc'], ENT_QUOTES, 'UTF-8');
$id_kl = $_SESSION['id_kl'];
$id_wych = $_SESSION['id_db'];

$ob='';
$ile =  htmlentities($_POST['ile'], ENT_QUOTES, 'UTF-8');

for($i=0; $i<$ile; $i++)
{
	${'ob_'+$i}=htmlentities($_POST['ob_'.$i], ENT_QUOTES, 'UTF-8');
	
	if(${'ob_'+$i} != '0')
	{
		$ob .= ${'ob_'+$i}.', ';
	}
}

//usunięcie ostatniego znaku - "przecinka"
$ob = substr($ob,0,strlen($ob)-2);

//sprawdzenie, czy w bazie istnieje podany przedmiot
if($result = $mysqli->query("SELECT * FROM rodz_zebrania WHERE id_zeb='$id_zeb'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {      
	 if($data == '' || $tresc == '' || $ob == '' || $id_wych == '' || $id_kl == '')
	 {
		$error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE rodz_zebrania SET data = ?, tresc = ? , ob = ?, id_wych = ?, id_kl = ? WHERE id_zeb = ?"))
		{
		   $stmt->bind_param("sssiii",$data,$tresc,$ob,$id_wych,$id_kl,$id_zeb);
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