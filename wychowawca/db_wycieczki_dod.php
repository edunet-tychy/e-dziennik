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

$data = htmlentities($_POST['data'], ENT_QUOTES, 'UTF-8');
$czas = htmlentities($_POST['czas'], ENT_QUOTES, 'UTF-8');
$ilu_uczniow = htmlentities($_POST['liczba'], ENT_QUOTES, 'UTF-8');
$dokad = htmlentities($_POST['cel'], ENT_QUOTES, 'UTF-8');
$id_user = htmlentities($_POST['nauczyciel'], ENT_QUOTES, 'UTF-8');
$id_kl = $_SESSION['id_kl'];

function zapytanie($data,$czas,$ilu_uczniow,$dokad,$id_user,$id_kl)
{
 global $mysqli;
  if($result = $mysqli->query("SELECT * FROM wycieczki WHERE data='$data' AND czas='$czas' AND id_kl='$id_kl'"))
  {
	  if($result->num_rows == 0)
	  {
		 if($data != '' && $czas != '' && $ilu_uczniow != '' && $dokad != ''  && $id_user != '' && $id_kl != '')
		 {
		  if($stmt = $mysqli->prepare("INSERT wycieczki (data,czas,ilu_uczniow,dokad,id_user,id_kl) VALUES (?,?,?,?,?,?)"))
		  {
			$stmt->bind_param("ssisii",$data,$czas,$ilu_uczniow,$dokad,$id_user,$id_kl);
			$stmt->execute();
			$stmt->close();
		  }
		 }
	  }
  } else {
	  echo 'Błąd: ' . $mysqli->error;
  }	
}

zapytanie($data,$czas,$ilu_uczniow,$dokad,$id_user,$id_kl);

?>
</body>
</html>