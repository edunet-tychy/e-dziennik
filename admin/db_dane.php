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
  var url = "db_dane_szkola_pok.php";
  $("#pokazDaneSzkola").load(url);
});
</script>
</head>
<body>

<?php
//Nawiązanie połączenia serwerem MySQL.
include_once('db_connect.php');

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

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
  <h3 id="naglSzkola-2">DANE SZKOŁY</h3>
  <form action="db_dane_szkola_dod.php" method="post" name="form" id="form">
    <table id="center-tabela-2">
    <tr>
      <td class="opis-2">Pełna nazwa:*</td>
      <td><input type="text" id="pelnaNazwaSzkolyEdycja" size="40" class="pole" name="pelnaNazwaSzkolyEdycja" maxlength="30"></td>
    </tr>
    <tr>
      <td class="opis-2">Ulica:*</td>
      <td><input type="text" id="ulicaSzkolyEdycja" size="40" class="pole" name="ulicaSzkolyEdycja" maxlength="30"></td>
    </tr>
    <tr>
      <td class="opis-2">Kod:*</td>
      <td><input type="text" id="kodSzkolyEdycja" size="40" class="pole" name="kodSzkolyEdycja" maxlength="6"></td>
    </tr>
    <tr>
    <td class="opis-2">Miasto:*</td>
      <td><input type="text" id="miastoSzkolyEdycja" size="40" class="pole" name="miastoSzkolyEdycja" maxlength="25"></td>
    </tr>
    <tr>
    <td class="opis-2">Telefon:*</td>
      <td><input type="text" id="telefonSzkolyEdycja" size="40" class="pole" name="telefonSzkolyEdycja" maxlength="15"></td>
    </tr>
    <tr>
      <td class="opis-2">Email:*</td>
      <td><input type="text" id="emailSzkolyEdycja" size="40" class="pole" name="emailSzkolyEdycja" maxlength="25"></td>
    </tr>
    <tr>
      <td class="opis-2">Nip:*</td>
      <td><input type="text" id="nipSzkolyEdycja" size="40" class="pole" name="nipSzkolyEdycja" maxlength="13"></td>
    </tr>
    <tr>
      <td class="opis-2">Regon:*</td>
      <td><input type="text" id="regonSzkolyEdycja" size="40" class="pole" name="regonSzkolyEdycja" maxlength="14"></td>
    </tr>
    <tr>
      <td></td><td><input type="button" value="Dodaj dane" class="button" id="dodajDaneSzkola"></td>
    </tr>
    </table>
  </form>
  </div>
    <div id="informacje-2">
      <p>* - w tym polu dane są obowiązkowe</p>
      <p id="wyr">Na przykład:</p>
      <ul>
        <li>Pełna nazwa: Zespół Szkół nr 6</li>
        <li>Ulica: al. Piłsudskiego 10</li>
        <li>Kod: 43-100</li>
        <li>Miasto: Tychy</li>
        <li>Telefon: 32 217-00-91</li>
        <li>Email: zsnr6@interia.pl</li>
        <li>Nip: 646-101-07-78</li>
        <li>Regon: 000036280</li>
      </ul>
      <p id="wyr">Sprawdź podmiot KRS:</p>
      <p id="wyr"><a class="linki" href="http://www.krs-online.com.pl/" target="_blank">Wyszukiwarka podmiotów KRS</a></p>
    </div><br>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>