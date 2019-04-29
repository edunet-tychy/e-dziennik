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
	var url = 'db_uwagi_pok.php';
	$("#user").load(url);
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
      <li><a href="db_uwagi_dane.php" title="lista" class="zakladki aktywna" id="z_01">POKAŻ INFORMACJE</a></li>
      <li><a href="db_uwagi_form.php" title="dodaj" class="zakladki" id="z_02">DODAJ INFORMACJĘ</a></li>
      <?php
      if(date("n") > 8 || date("n") == 1 || date("n") == 2)
      {
        echo'<li><a href="db_zachowanie_sem.php" title="zachowanie" class="zakladki" id="z_03">OCENA Z ZACHOWANIA</a></li>';
      } else {
        echo'<li><a href="db_zachowanie_kon.php" title="zachowanie" class="zakladki" id="z_03">OCENA Z ZACHOWANIA</a></li>';
      }
      ?>
    </ul>
    <div id="lista" class="zawartosc">
      <h3 id="nagRamka2">INFORMACJE O ZACHOWANIU UCZNIÓW KLASY <?php echo $klasa . ' ' . $sb?></h3>
      <p class="center-2">(osiągnięcia, pochwały, uwagi)</p>
      <div id="user"></div>
    </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>