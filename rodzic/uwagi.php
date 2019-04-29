<?php
include_once('status.php');

//Zmienna identyfikująca ucznia
$id=$_GET['id_ucz'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function()
{
  var url = 'uwagi_pok.php?id_ucz=<?php echo $id ;?>';
  $("#user").load(url);
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

//Zmienne
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];

//Obiekty
$wiadomosc = new news;
$baza = new zapytanie;
$query = "SELECT imie, nazwisko FROM users WHERE id='$id'";
$baza->pytanie($query);

$imieU = $baza->tab[0];
$nazwiskoU = $baza->tab[1];
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
    <div id="lista" class="zawartosc">
      <h3 id="nagRamka2">INFORMACJE O ZACHOWANIU</h3>
      <?php 
        echo'<ul class="nawigacja">';
        echo'<li><a href="#" title="uczen" class="ucz aktywna">'.$imieU.' '.$nazwiskoU.'</a></li>';
        echo'</ul>'; 
      ?>
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