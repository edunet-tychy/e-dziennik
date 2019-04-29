<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_02.js"></script>
<script type="text/javascript" src="javascript/jquery-1.js"></script>
<script type="text/javascript" src="javascript/jquery-ui-1.js"></script>
<link href="styl/jquery-ui-1.css" rel="stylesheet" type="text/css">
<link href="styl/styl.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.scrollTo(0, 200)">
<?php
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');
 
//Sprawdzenie nawiązania połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$id_kl = $_SESSION['id_kl'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$klasa = $_SESSION['klasa'];
$sb = $_SESSION['sb'];

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

//Data
$dzis = date("Y-m-d");

//Funkcja - Klasa
function klasa($id_kl)
{
  global $mysqli;
  
  $kl = "SELECT klasa, sb FROM vklasy WHERE id_kl='$id_kl'";
  
  if(!$zapytanie = $mysqli->query($kl)){
	echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	$mysqli->close();
  }

  $wynik = $zapytanie->fetch_row();
  $klasa = $wynik[0];	
  $sb = $wynik[1];
  
  $tab = $klasa .' '. $sb;
  
  return $tab;
}

?>
<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie_db,' ',$nazwisko_db,' - ', $kto,' klasy: ', $klasa,' ', $sb; ?></p>
  </div>
  <div id="opis"><div id="nowosc"><?php $wiadomosc->wiadomosc(); ?></div>
   <p class="info">
   <a class="linki" href="../logout.php">Wylogowanie</a>
   </p>
  </div>
  <div id="spis">
  <?php include_once('menu.php');?>
  </div>   
  <div id="czescGlowna">
  <h3 id="nagRamka">STAN OBECNOŚCI KLASY</h3>
  <?php
	echo '<div class="lewy-2">';
	echo '<p class="termin">Wybierz datę: ';
	echo '<input type="text" id="data" size="14" class="pole-center" name="data" value="'.$dzis.'"></p>';
	echo '</div>';
	echo '<form action="db_frekwencja_upd.php" method="post" name="formFrek" id="formFrek">';
	echo '<div class="prawy-2"><div id="zapis"></div>';
	echo '<input type="button" value="Zapisz stan obecności" class="button" id="zapiszFrek">';
	echo '</div>';
	echo '<div id="frek">';
	echo '<div class="loader">';
    echo '<p class="info-2"><img src="image/preloader.gif"></div>';
	echo '</div>';
	echo '</form>';
  ?>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>

