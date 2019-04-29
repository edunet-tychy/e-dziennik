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

$rodz1 = htmlentities($_POST['rodzic1'], ENT_QUOTES, 'UTF-8');
$tab1 = explode("; ", $rodz1);
$id_rodz1 = $tab1[0];
$plec1 = $tab1[1];

$rodz2 = htmlentities($_POST['rodzic2'], ENT_QUOTES, 'UTF-8');
$tab2 = explode("; ", $rodz2);
$id_rodz2 = $tab2[0];
$plec2 = $tab2[1];

$rodz3 = htmlentities($_POST['rodzic3'], ENT_QUOTES, 'UTF-8');
$tab3 = explode("; ", $rodz3);
$id_rodz3 = $tab3[0];
$plec3 = $tab3[1];

$id_kl = $_SESSION['id_kl'];

function zapytanie($id_rodz,$plec,$id_kl)
{
 global $mysqli;
  if($result = $mysqli->query("SELECT * FROM rada WHERE id_rodz='$id_rodz'"))
  {
	  if($result->num_rows == 0)
	  {
		 if($id_rodz != 0 && $id_kl != '')
		 {
		  if($stmt = $mysqli->prepare("INSERT rada (id_rodz,plec,id_kl) VALUES (?,?,?)"))
		  {
			$stmt->bind_param("isi",$id_rodz,$plec,$id_kl);
			$stmt->execute();
			$stmt->close();
		  }
		 }
	  }
  } else {
	  echo 'Błąd: ' . $mysqli->error;
  }	
}

zapytanie($id_rodz1,$plec1,$id_kl);
zapytanie($id_rodz2,$plec2,$id_kl);
zapytanie($id_rodz3,$plec3,$id_kl);

?>
</body>
</html>