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
  $("#news").datepicker({dateFormat: 'yy-mm-dd', firstDay: 1, dayNamesMin: ['Nd', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So'], monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'], maxDate: new Date(2015, 7, 31), minDate: new Date(2014, 7, 1)});
  var url_k = "db_news_pok.php";
  $("#pokazNews").load(url_k);
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
include_once('../class/news.class.php');
include_once('../class/zapytanie.class.php');

//Obiekty
$wiadomosc = new news;

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   $mysqli->connect_error;
}

//Zmienne
$id_db = $_SESSION['id_db'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$id = $_GET['id'];

$news = "SELECT * FROM news WHERE id_news='$id'";
$baza = new zapytanie;
$baza->pytanie($news);

$id = $baza->tab[0];
$data = $baza->tab[1];
$tresc = $baza->tab[2];

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
  <h3 id="nagKalendarz">NEWS</h3>
  <div id="pokazNews"></div>
  <h3 id="nagKalendarz">EDYCJA WYDARZENIA</h3>
    <form action="db_news_upd.php" method="post" name="form" id="form">
    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
        <table id="kalendarz">
        <tr>
          <td>DATA : <input type="text" id="news" size="10" class="pole-center" name="news" value="<?php if(isset($data)){echo $data;}; ?>"></td>
          <td><input type="text" id="wydarzenieNews" size="120" class="pole-left" name="wydarzenieNews" value="<?php if(isset($tresc)){echo $tresc;}; ?>"></td>
          <td>KTO :
            <select name="odb" id="odbiorca">
              <option value="0">...</option>
              <option value="1">Nauczyciel</option>
              <option value="2">Rodzic</option>
            </select>
          </td>
        </tr>
        </table>
        <input type="button" value="Popraw wydarzenie" class="button" id="poprawNews">
    </form><br><br>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>