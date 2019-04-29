<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_uw.js"></script>
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
include_once('../class/uwagi_klasa.class.php');
include_once('../class/uwagi_uczniowie.class.php');
include_once('../class/uwagi_edycja.class.php');
include_once('../class/uwagi_edycjaUser.class.php');
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

//Zmienne
$kto=$_SESSION['zalogowany'];
$id = $_SESSION['id_db'];
$nazwisko = $_SESSION['nazwisko_db'];
$imie = $_SESSION['imie_db'];
$rola = $_SESSION['rola_db'];
$id_kl = $_GET['id_kl'];

$id_uw =  $_GET['id_uw'];

//Obiekty
$bazaKlasa = new uwagiKlasa;
$wynik = $bazaKlasa->klasa($id_kl,$mysqli);
$klasa = $wynik[0];	
$sb = $wynik[1];

$bazaEdycjaUwagi = new uwagiEdycja;
$wynik = $bazaEdycjaUwagi->uwaga($id_uw,$mysqli);	
$tresc = $wynik[2];
$id_ucz =  $wynik[3];

$bazaEdycjaUczen = new uwagaUczen;
$user = $bazaEdycjaUczen->uczen($id_ucz,$mysqli);
$nazwisko = $user[0];
$imie =  $user[1];

//Funkcja - View: Uczniowie
function lista($id_kl,$mysqli)
{
  $bazaUczniowie = new uwagiUczniowie;
  $zestaw = $bazaUczniowie->uczniowie($id_kl,$mysqli);
  
  foreach($zestaw as $dane)
  {
	$dane = explode('; ', $dane);	
	echo'<option value="'.$dane[0].'">'.$dane[1].' '.$dane[2].'</option>';		 
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
  <h3 id="nagRamka1">EDYCJA WPISU  -  KLASA <?php echo $klasa. ' '. $sb ?></h3>
  <h2 class="opis-2">(osiągnięcia, pochwały, uwagi)</h2>
   <form action="uwagi_upd.php?id_kl=<?php echo $id_kl; ?>&id_uw=<?php echo $id_uw; ?>" method="post" name="form" id="form">
    <table id="center-tabela-pod-3">
    <tr><td class="dane-3" colspan="2">Nazwisko i imię ucznia:*</td></tr>
    <tr><td class="dane-3" colspan="2">
    <select class="min" name="uczen">
    <?php
      echo'<option value="'.$id_ucz.'">'.$nazwisko.' '.$imie.'</option>';
      echo'<option value="0">---</option>';	
      lista($id_kl,$mysqli);
    ?>
    </select>
    </td></tr>
    <tr><td class="dane-3" colspan="2">Treść uwagi:*</td></tr>
    <tr><td class="dane-3" colspan="2">
    <textarea name="tresc" id="tresc" cols="100" rows="3"><?php echo $tresc; ?></textarea>
    </td></tr>
    <tr>
    <td colspan="2" class="center-3"><input type="button" value="Popraw informację" class="button" id="poprawInformacje"></td>
    </tr>
    </table>
  </form>
  <div id="user"></div><br><br>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>