<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
</head>
<?php
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');
 
//Sprawdzenie nawiązania połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

$id_user1 = htmlentities($_POST['uczen1'], ENT_QUOTES, 'UTF-8');
$id_user2 = htmlentities($_POST['uczen2'], ENT_QUOTES, 'UTF-8');
$id_user3 = htmlentities($_POST['uczen3'], ENT_QUOTES, 'UTF-8');
$rola1='p';
$rola2='z';
$rola3='s';
$id_kl = $_SESSION['id_kl'];

function zapytanie($id_user,$id_kl,$rola)
{
 global $mysqli;
  if($result = $mysqli->query("SELECT * FROM samorzad WHERE id_user='$id_user'"))
  {
	  if($result->num_rows == 0)
	  {
		 if($id_user != 0 && $id_kl != '')
		 {
		  if($stmt = $mysqli->prepare("INSERT samorzad (id_user,id_kl,rola) VALUES (?,?,?)"))
		  {
			$stmt->bind_param("iis",$id_user,$id_kl,$rola);
			$stmt->execute();
			$stmt->close();
		  }
		 }
	  }
  } else {
	  echo 'Błąd: ' . $mysqli->error;
  }	
}

zapytanie($id_user1,$id_kl,$rola1);
zapytanie($id_user2,$id_kl,$rola2);
zapytanie($id_user3,$id_kl,$rola3);

?>
</body>
</html>