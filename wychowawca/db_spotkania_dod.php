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
$tresc = htmlentities($_POST['tresc'], ENT_QUOTES, 'UTF-8');
$id_ucz = htmlentities($_POST['uczen'], ENT_QUOTES, 'UTF-8');
$id_kl = $_SESSION['id_kl'];
$id_wych = $_SESSION['id_db'];


function nauczyciel($query)
{
 global $mysqli;
	if(!$result = $mysqli->query($query))
	{
	  echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	  $mysqli->close();
	}
	$row = $result->fetch_row();
	$tb[] = $row[0];
 return $tb;
}

function zapytanie($data,$tresc,$id_ucz,$id_wych,$id_kl)
{
 global $mysqli;

  if($data != '' && $tresc != '' && $id_ucz != '0' && $id_wych != '' && $id_kl != '')
  {
	if($stmt = $mysqli->prepare("INSERT rodz_spotkania (data,tresc,id_ucz,id_wych,id_kl) VALUES (?,?,?,?,?)"))
	{
	  $stmt->bind_param("ssiii",$data,$tresc,$id_ucz,$id_wych,$id_kl);
	  $stmt->execute();
	  $stmt->close();
	}else {
	  echo 'Błąd: ' . $mysqli->error;
	}
  }

}

zapytanie($data,$tresc,$id_ucz,$id_wych,$id_kl);

?>
</body>
</html>