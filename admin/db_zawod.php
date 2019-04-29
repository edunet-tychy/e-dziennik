<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="../javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_zawod.js"></script>
<link href="styl/styl_szkola.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function()
{
  var url = "db_zawod_pok.php";
  $("#pokazZawod").load(url);
});
</script>
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

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

//Zmienne
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];

?>
<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie_db,' ',$nazwisko_db,' - ', $_SESSION['kto']; ?></p>
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
  <div class="left" id="formularz">
  <h3 id="naglPrzedmiot">DODAJ ZAWÓD</h3>
  <form action="db_zawod_dod.php" method="post" name="form" id="form">
    <table id="szkola">
    <tr>
      <td class="opis">Nazwa zawodu:*</td>
      <td><input type="text" id="nazwaZawodu" size="40" class="pole" name="nazwaZawodu"></td>
      <td><div class="kontrola" id="nazwaZawod"></div></td>
    </tr>
    <tr>
      <td class="opis">Symbol zawodu:*</td>
      <td><input type="text" id="symbolZawodu" size="40" class="pole" name="symbolZawodu"></td>
      <td><div class="kontrola" id="symbolZawod"></div></td>
    </tr>
    <tr>
      <td class="opis">Skrót zawodu:*</td>
      <td><input type="text" id="skrotZawodu" size="40" class="pole" name="skrotZawodu"></td>
      <td><div class="kontrola" id="skrotZawod"></div></td>
    </tr>
    <tr>
      <td></td><td><input type="button" value="Dodaj zawód" class="button" id="dodajZawod"></td><td></td>
    </tr>
    </table>
  </form>
    <div id="informacje">
    <p>* - w tym polu dane są obowiązkowe</p>
    <p id="wyr">Na przykład:</p>
    <ul>
    <li>Nazwa zawodu: technik informatyk</li>
    <li>Symbol cyfrowy zawodu: 351203</li>
    <li>Skrót zawodu: TIN</li>
    </ul>
    </div>
  </div>
    <div class="right">
      <h3>ZAWODY</h3>
      <div id="pokazZawod"></div>
      <br><br>
    </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>