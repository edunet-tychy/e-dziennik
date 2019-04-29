<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL.
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$data = $_GET['dt'];
@$odb = htmlentities($_POST['kto'], ENT_QUOTES, 'UTF-8');
$nad = $_SESSION['id_db'];
$tytul = htmlentities($_POST['tytul'], ENT_QUOTES, 'UTF-8');
$tresc = htmlentities($_POST['tresc'], ENT_QUOTES, 'UTF-8');
$odczyt = 1;

if($result = $mysqli->query("SELECT * FROM poczta WHERE data='$data' AND odb='$odb' AND nad='$nad' AND tytul='$tytul' AND tresc='$tresc'"))
{
  if($result->num_rows == 0)
  {
	zapytanie($data,$odb,$nad,$tytul,$tresc,$odczyt);
  }
}

//Funkcja - Zapisywanie wiadomości
function zapytanie($data,$odb,$nad,$tytul,$tresc,$odczyt)
{
 global $mysqli;

  if($data != '' && $odb != 'x' && $nad != '' && $tytul != '' && $tresc != '' && $odczyt != '')
  {
	if($stmt = $mysqli->prepare("INSERT poczta (data,odb,nad,tytul,tresc,odczyt) VALUES (?,?,?,?,?,?)"))
	{
	  $stmt->bind_param("siisss",$data,$odb,$nad,$tytul,$tresc,$odczyt);
	  $stmt->execute();
	  $stmt->close();
	  echo '<p class="poczta">List został zapisany</p>';
	}else {
	  echo 'Błąd: ' . $mysqli->error;
	}
  }
}

?>