<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_szkola.js"></script>
<link href="styl/styl_szkola.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.scrollTo(0, 200)">

<?php
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Nawiązanie połączenia z serwerem MySQL
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
$id_db = $_SESSION['id_db'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];

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
  <h3 id="naglPrzedmiot">NAZWA PRZEDMIOTU</h3>
  <form action="db_przedmiot_dod.php" method="post" name="formPrzedmiot" id="formPrzedmiot">
    <table>
    <tr>
      <td class="opis">Nazwa przedmiotu:*</td>
      <td><input type="text" id="przedmiot" size="40" class="pole" name="przedmiot" maxlength="35"></td>
    </tr>
    <tr>
      <td class="opis">Skrócona nazwa:*</td>
      <td><input type="text" id="skrot" size="40" class="pole" name="skrot" maxlength="7"></td>
    </tr>
    <tr>
      <td class="opis">Liczony do średniej:</td>
      <td><input type="checkbox" value="1" id="srednia" size="30" class="pole" name="srednia" checked></td>
    </tr>
    <tr>
      <td></td><td><input type="button" value="Dodaj przedmiot" class="button" id="dodajPrzedmiot"></td>
    </tr>
    </table>
  </form>
    <div id="informacje">
    <p>* - w tym polu dane są obowiązkowe</p>
    <p id="wyr">Na przykład:</p>
    <ul>
    <li>Nazwa przedmiotu: Język polski</li>
    <li>Skrócona nazwa (max: 7 liter): pol.</li>
    </ul>
    </div>
  </div>
    <div class="right">
      <h3>PRZEDMIOTY</h3>
      <div id="pokazPrzedmioty"></div><br><br>
    </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>