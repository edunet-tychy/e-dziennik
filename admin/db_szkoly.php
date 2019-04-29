<?php
  include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="../javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_szkola.js"></script>
<link href="styl/styl_szkola.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function()
{
  var url = "db_szkola_pok.php";
  $("#pokazSzkola").load(url);
});
</script>
</head>
<body onload="window.scrollTo(0, 200)">

<?php
//Nawiązanie połączenia serwerem MySQL.
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
  <h3 id="naglPrzedmiot">DODAJ SZKOŁĘ</h3>
  <form action="db_szkola_dod.php" method="post" name="formSzkola" id="formSzkola">
    <table id="szkola">
    <tr>
      <td class="opis">Nazwa szkoły:*</td>
      <td><input type="text" id="nazwaSzkoly" size="40" class="pole" name="nazwaSzkoly"></td>
    </tr>
    <tr>
      <td class="opis">Skrót nazwy szkoły:*</td>
      <td><input type="text" id="symbolSzkoly" size="40" class="pole" name="symbolSzkoly"></td>
    </tr>
    <tr>
      <td class="opis">Typ szkoły:*</td>
      <td>
      <select name="typSzkoly" id="typSzkoly">
        <option value="x">...</option>
        <option value="LO">liceum ogólnokształące</option>
        <option value="T">technikum</option>
        <option value="ZSZ">szkoła zawodowa</option>
      </select>
      </td>
    </tr>
    <tr>
      <td></td><td><input type="button" value="Dodaj szkołę" class="button" id="dodajSzkole"></td><td></td>
    </tr>
    </table>
  </form>
    <div id="informacje">
    <p>* - w tym polu dane są obowiązkowe</p>
    <p id="wyr">Na przykład:</p>
    <ul>
    <li>Nazwa szkoły: Zasadnicza Szkoła Zawodowa nr 4</li>
    <li>Skrót nazwy szkoły: ZSZ nr 4</li>
    <li>Typ szkoły: szkoła zawodowa</li>
    </ul>
    </div>
  </div>
    <div class="right">
       <h3>SZKOŁY</h3>
       <div id="pokazSzkola"></div><br><br>
    </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>