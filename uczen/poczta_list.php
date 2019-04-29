<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_03.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
//Nawiązanie połączenia serwerem MySQL.
include_once('db_connect.php');
include_once('../class/poczta_user.class.php');
include_once('../class/poczta_dzien.class.php');
include_once('../class/poczta_terminy.class.php');
include_once('../class/poczta.class.php');
include_once('../class/news.class.php');
include_once('../class/zapytanie.class.php');

if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$kto=$_SESSION['zalogowany'];
$id = $_SESSION['id_db'];
$nazwisko = $_SESSION['nazwisko_db'];
$imie = $_SESSION['imie_db'];
$rola = $_SESSION['rola_db'];
$id_pocz = $_GET['id_pocz'];

//Obiekty
$wiadomosc = new news;
$baza = new terminy;
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
  </ul>
  <h3 id="nagRamka1">EDYCJA LISTU</h3>
	<?php 
      $co = $bazaPoczta->poczta($id_pocz); 
    
      $dane = explode('; ', $co);
  
      $do = $dane[0];
      $kto2 =  $dane[1];
      $tytul =  'Re. '.$dane[2];
    ?>
  <br><br></div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>