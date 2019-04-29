<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_poczta.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
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
include_once('../class/poczta_user.class.php');
include_once('../class/poczta_dzien.class.php');
include_once('../class/poczta_terminy.class.php');
include_once('../class/poczta.class.php');
include_once('../class/news.class.php');

//Zmienne
$kto=$_SESSION['zalogowany'];
$id = $_SESSION['id_db'];
$nazwisko = $_SESSION['nazwisko_db'];
$imie = $_SESSION['imie_db'];
$rola = $_SESSION['rola_db'];

$id_pocz = $_GET['id_pocz'];

//Obiekty
$wiadomosc = new news;
$bazaUser = new terminy;
$bazaDz = new dzien;
$bazaPoczta = new post;

?>
<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie,' ',$nazwisko,' - ', $_SESSION['kto'] ?></p>
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
  <ul class="nawigacja_new">
  <li><a href="poczta.php" title="sk_od" class="zaj">Skrzynka odbiorcza</a></li>
  <li><a href="#" title="sk_nad" class="zaj">Odpowiedz na list</a></li>
  </ul>
  <h3 id="nagRamka1">EDYCJA LISTU</h3>
  <?php 
    $co = $bazaPoczta->poczta($id_pocz); 
  
    $dane = explode('; ', $co);
  
    $do = $dane[0];
    $kto2 =  $dane[1];
    $tytul =  'Re. '.$dane[2];
  ?>
  <div id="sk_nad" class="zawartosc">
  <h3 id="nagRamka1">ODPOWIEDŹ</h3>
    <p class="center-4">Dzisiaj jest <?php echo $bazaDz->dzw().', '. $bazaUser->data(); ?> roku. Godz.: <?php echo $bazaUser->godz(); ?>.</p>
    <form action="poczta_dod.php?dt=<?php echo $bazaUser->dt(); ?>" method="post" name="form" id="form">
    <table id="center-tabela-pod-3">
    <tr><td class="dane-3">Do: <?php echo $kto2; ?></td></tr>
    <input type="hidden" name="kto" id="kto" value="<?php echo $do; ?>">
    <tr><td class="dane-3">Temat: </td></tr>
    <tr><td class="dane-3"><input class="dane-4" type="text" name="tytul" id="tytul" value="<?php echo $tytul; ?>"></td></tr>
    <tr><td class="dane-3">Treść:*</td></tr>
    <tr><td class="dane-3">
    <textarea name="tresc" id="tresc" cols="100" rows="4"></textarea>
    </td></tr>
    <tr><td class="dane-3"><input type="button" value="Wyślij list" class="button" id="odp-list"></td></tr>
    </form>
    </table>
  </div>
  <br><br></div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>