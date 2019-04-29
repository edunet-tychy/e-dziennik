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
//Nawiązanie połączenia serwerem MySQL.
include_once('db_connect.php');
  
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/poczta_user.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

//Zmienne
$kto=$_SESSION['zalogowany'];
$id = $_SESSION['id_db'];
$nazwisko = $_SESSION['nazwisko_db'];
$imie = $_SESSION['imie_db'];
$rola = $_SESSION['rola_db'];
$id_pocz = $_GET['id_pocz'];

//Funkcja - View: Poczta
function poczta($id_pocz)
{
  global $mysqli;
  
  $bazaUs = new users;
  $bazaSt = new statusy;

  $query = "SELECT * FROM poczta WHERE id_pocz = '$id_pocz'";

  if(!$result = $mysqli->query($query))
  {
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
  }

  if($result->num_rows > 0)
  {
	echo'<table id="center-tabela-pod-3">';
	while($row=$result->fetch_object())
	{
	  echo'<tr><td class="dane-3"><span class="list">Data: </span></td><td class="dane-3">'. $row->data .'</td></tr>';
	  echo'<tr><td class="dane-3"><span class="list">Odbiorca: </span></td><td class="dane-3">'. $bazaUs->user($row->odb) .'</td></tr>';
	  echo'<tr><td class="dane-3"><span class="list">Tytuł i treść listu:</span></td><td class="dane-3">'. $row->tytul .'</td></tr>';
	  echo'<tr><td class="dane-3" colspan="2">'. $row->tresc .'</td></tr>';
	}
	echo'</table>';
  } else {
	echo '<img src="image/pytanie.png" alt="Brak rekordów">';
	echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
  }
}

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
  <li><a href="poczta.php" title="Skrzynka odbiorcza" class="zaj">Skrzynka odbiorcza</a></li>
  </ul>
  <h3 id="nagRamka1">EDYCJA LISTU</h3>
  <?php poczta($id_pocz); ?>
  <br></div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>