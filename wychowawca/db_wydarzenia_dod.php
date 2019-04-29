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

$id_kl = $_SESSION['id_kl'];

echo $data = htmlentities($_POST['data'], ENT_QUOTES, 'UTF-8');
echo $informacje = htmlentities($_POST['informacje'], ENT_QUOTES, 'UTF-8');

function zapytanie($data,$informacje,$id_kl)
{
 global $mysqli;
  if($result = $mysqli->query("SELECT * FROM wydarzenia WHERE informacje='$informacje' AND data='$data' AND id_kl='$id_kl'"))
  {
	  if($result->num_rows == 0)
	  {
		 if($data != '' && $informacje != '' && $id_kl != '')
		 {
		  if($stmt = $mysqli->prepare("INSERT wydarzenia (data,informacje,id_kl) VALUES (?,?,?)"))
		  {
			$stmt->bind_param("ssi",$data,$informacje,$id_kl);
			$stmt->execute();
			$stmt->close();
		  }
		 }
	  }
  } else {
	  echo 'Błąd: ' . $mysqli->error;
  }	
}

zapytanie($data,$informacje,$id_kl);

?>
</body>
</html>