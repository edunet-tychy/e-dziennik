<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.scrollTo(0, 200)">
<?php
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$id_db = $_SESSION['id_db'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$id_kl = $_SESSION['id_kl'];
$id_zaj = $_GET['id_zaj'];

echo'<h2 class="opis">OPIS OCEN CZĄSTKOWYCH:</h2>';
echo'<ul class="opis">';
if($result = $mysqli->query("SELECT * FROM oceny_op_k WHERE id_kl='$id_kl' AND id_przed='$id_zaj' ORDER BY poz"))
{
  if($result->num_rows > 0)
  {
	$nr=0;
	while($row=$result->fetch_object())
	{
	  $nr++;
	  $sk = $row->sk;
	  $opis = $row->opis;
	  echo'<li>'.$sk.' - '.$opis.'</li>';
	}
  }
}
echo'</ul><br><br>';
?>
</body>
</html>