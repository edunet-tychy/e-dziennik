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

$ile =  htmlentities($_POST['ile'], ENT_QUOTES, 'UTF-8');
$data = htmlentities($_POST['data'], ENT_QUOTES, 'UTF-8');
$tresc = htmlentities($_POST['tresc'], ENT_QUOTES, 'UTF-8');
$id_kl = $_SESSION['id_kl'];
$id_wych = $_SESSION['id_db'];
$ob='';

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

function zapytanie($data,$tresc,$ob,$id_kl,$id_wych)
{
 global $mysqli;

  if($data != '' && $tresc != '' && $ob != '' && $id_kl != '' && $id_wych != '')
  {
	if($stmt = $mysqli->prepare("INSERT rodz_zebrania (data,tresc,ob,id_kl,id_wych) VALUES (?,?,?,?,?)"))
	{
	  $stmt->bind_param("sssii",$data,$tresc,$ob,$id_kl,$id_wych);
	  $stmt->execute();
	  $stmt->close();
	}else {
	  echo 'Błąd: ' . $mysqli->error;
	}
  }

}
zapytanie($data,$tresc,$ob,$id_kl,$id_wych);

?>
</body>
</html>