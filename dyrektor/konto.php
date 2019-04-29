<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="../javascript/jquery-1.11.1.min.js"></script>
<link href="styl/styl_szkola.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/konto.class.php');
include_once('../class/news.class.php');

//Zmienne
$id = $_SESSION['id_db'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto=$_SESSION['zalogowany'];

//Obiekty
$wiadomosc = new news;
$user = new konto;
?>
<div id="kontener">
  <div id="logo">
    <img src="../image/logo_user.png" alt="Logo">
    <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie_db,' ',$nazwisko_db,' - ', $_SESSION['kto']; ?></p>
  </div>
  <div id="opis"><div id="nowosc"><?php $wiadomosc->wiadomosc(); ?></div><p class="info"><a class="linki" href="../logout.php">Wylogowanie</a></p></div>
  <div id="spis"><?php include_once('menu.php');?></div>   
  <div id="czescGlowna">
    <h3 id="nagSzkola">DANE UŻYTKOWNIKA</h3>
    <?php $user->interfejsUsera($kto,$id);?>
  </div>
  <div id="stopka"><p class="stopka">&copy; G.Szymkowiak 2014/2015</p></div>
</div>
</body>
</html>