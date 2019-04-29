<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="../javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/jquery-1.js"></script>
<script type="text/javascript" src="javascript/jquery-ui-1.js"></script>
<script type="text/javascript" src="javascript/script_szkola.js"></script>
<link href="styl/jquery-ui-1.css" rel="stylesheet" type="text/css">
<link href="styl/styl_szkola.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function($)
{
  $("#odKal").datepicker({dateFormat: 'yy-mm-dd', firstDay: 1, dayNamesMin: ['Nd', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So'], monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'], maxDate: new Date(2015, 7, 31), minDate: new Date(2014, 7, 1)});
  $("#doKal").datepicker({dateFormat: 'yy-mm-dd', firstDay: 1, dayNamesMin: ['Nd', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So'], monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'], maxDate: new Date(2015, 7, 31), minDate: new Date(2014, 7, 1)});
  var url_k = "db_kalendarz_pok.php";
  $("#pokazKalendarz").load(url_k);
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
  <h3 id="nagKalendarz">KALENDARZ WYDARZEŃ SZKOLNYCH</h3>
  <div id="pokazKalendarz"></div>
  <h3 id="nagKalendarz">DODAJ NOWE WYDARZENIE</h3>
  <form action="db_kalendarz_dod.php" method="post" name="formKalendarz" id="formKalendarz">
      <table id="kalendarz">
      <tr>
        <td>OD: <input type="text" id="odKal" size="10" class="pole-left" name="odKal"></td>
        <td>DO: <input type="text" id="doKal" size="10" class="pole-left" name="doKal"></td>
        <td><input type="text" id="wydarzenieKal" size="110" class="pole-left" name="wydarzenieKal"></td>
      </tr>
      </table>
      <input type="button" value="Zapisz wydarzenie" class="button" id="dodajWydarzenieKal">
  </form>
  <br><br>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>