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

$id_sm = htmlentities($_POST['id_sm'], ENT_QUOTES, 'UTF-8');
$rola = htmlentities($_POST['rola'], ENT_QUOTES, 'UTF-8');
$id_user = htmlentities($_POST['uczen'], ENT_QUOTES, 'UTF-8');
 

if($result = $mysqli->query("SELECT * FROM samorzad WHERE id_sm='$id_sm'"))
{
  if($result->num_rows == 1)
  {
	  echo $result->num_rows;
	  if($id_user != 0)
	  {
		if($stmt = $mysqli->prepare("UPDATE samorzad SET id_user = ?, rola = ? WHERE id_sm = ?"))
		{
		   $stmt->bind_param("isi",$id_user,$rola,$id_sm);
		   $stmt->execute();
		   $stmt->close();
		} else {
		   echo "Błąd zapytania";
		}
	 }
  }
}

?>
</body>
</html>