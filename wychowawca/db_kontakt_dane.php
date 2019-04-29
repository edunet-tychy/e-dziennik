<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function()
{
	var adr = 'db_zebrania_pok.php';
	$("#view-1").load(adr);
	
	var url = 'db_spotkania_pok.php';
	$("#view-2").load(url);
});
</script>

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
    <ul class="nawigacja">
      <li><a href="db_zebrania_form.php" title="lista" class="zakladki" id="z_01">DODAJ ZEBRANIE Z RODZICAMI</a></li>
      <li><a href="db_spotkania_form.php" title="dodaj" class="zakladki" id="z_02">DODAJ SPOTKANIE INDYWIDUALNE</a></li>
    </ul>
    <div id="lista" class="zawartosc">
      <h3 id="nagRamka2">ZEBRANIA Z RODZICAMI KLASY <?php echo $klasa . ' ' . $sb?></h3>
      <div id="view-1"></div>
      <h3 id="nagRamka3">SPOTKANIA INDYWIDUALNE RODZICÓW <?php echo $klasa . ' ' . $sb?> Z WYCHOWAWCĄ</h3>
      <div id="view-2"></div>
    </div>
    <br><br>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>