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

//Funkcja - Dzwonki
function dzwonki()
{
  global $mysqli;
  
  $zapytanie = "SELECT * FROM godziny";
  
  if($odp = $mysqli->query($zapytanie))
  {
	if($odp->num_rows > 0)
	 {
		$ile=0;
		while($wiersz=$odp->fetch_object())
		{
		  $ile++;
		  echo '<tr>';
		  echo '<td><input type="text" id="nr'.$ile.'" size="2" class="pole-center" name="nr'.$ile.'" value="'.$wiersz->nr.'"></td>';
		  echo '<td><input type="text" id="pocz'.$ile.'" size="5" class="pole-center" name="pocz'.$ile.'" value="'.$wiersz->pocz.'"></td>';
		  echo '<td><input type="text" id="kon'.$ile.'" size="5" class="pole-center" name="kon'.$ile.'" value="'.$wiersz->kon.'"></td>';
		  echo '</tr>';
		}
	}	
  }
}

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
  <h3 id="nagDzwonki">EDYCJA - ROZKŁAD DZWONKÓW LEKCYJNYCH</h3>
  <form action="db_dzwonki_upd.php" method="post" name="formUp" id="formUp">
  
    <table id="dzwonki">
    <tr><th>LEKCJA</th><th>POCZĄTEK</th><th>KONIEC</th></tr>
    <?php dzwonki();?>
    <tr><th class="kn" colspan="3"><div id="konWpis"></div></th></tr>
    </table>
    <div id="przycisk"><input type="button" value="Popraw dane" class="button" id="poprawDzwonki"></div>
    
  </form>
  <br><br>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>