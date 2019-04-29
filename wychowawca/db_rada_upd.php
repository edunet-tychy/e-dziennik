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

$id_rd = htmlentities($_POST['id_rd'], ENT_QUOTES, 'UTF-8');
$rodz = htmlentities($_POST['rodzic'], ENT_QUOTES, 'UTF-8');
$tab1 = explode("; ", $rodz);
$id_rodz = $tab1[0];
$plec = $tab1[1];
 
if($result = $mysqli->query("SELECT * FROM rada WHERE id_rd='$id_rd'"))
{
  if($result->num_rows == 1)
  {
	  echo $result->num_rows;
	  if($id_user != 0)
	  {	  
		if($stmt = $mysqli->prepare("UPDATE rada SET id_rodz = ?, plec = ? WHERE id_rd = ?"))
		{
		   $stmt->bind_param("isi",$id_rodz,$plec,$id_rd);
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