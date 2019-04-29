<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/jquery-1.js"></script>
<script type="text/javascript" src="javascript/jquery-ui-1.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<link href="styl/jquery-ui-1.css" rel="stylesheet" type="text/css">
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function($)
{
	$(".pole-center").datepicker({dateFormat: 'yy-mm-dd', firstDay: 1, dayNamesMin: ['Nd', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So'], monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień']});
});
</script>
</head>
<body onload="window.scrollTo(0, 200)">
<?php
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');
 
//Sprawdzenie nawiązania połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$id_kl = $_SESSION['id_kl'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$klasa = $_SESSION['klasa'];
$sb = $_SESSION['sb'];

$id_wyd=$_GET['id_wyd'];

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

function zapytanie($nazwa)
{
  global $mysqli;
  
  if(!$zapytanie = $mysqli->query($nazwa))
  {
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
  }
  
  $wynik = $zapytanie->fetch_row();
  $tb[] = $wynik[0];
  $tb[] = $wynik[1];
  
  return $tb;
}

//Identyfikator przedmiotu
$pyt = "SELECT data, informacje FROM wydarzenia WHERE id_wyd='$id_wyd'";
$tab = zapytanie($pyt);
$data = $tab[0];
$wydarzenie = $tab[1];

?>
<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie_db,' ',$nazwisko_db,' - ', $kto,' klasy: ', $klasa,' ', $sb; ?></p>
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
    <ul class="nawigacja">
      <li><a href="db_wydarzenia_dane.php" title="lista" class="zakladki" id="z_01">WYDARZENIA KLASY</a></li>
      <li><a href="db_wydarzenia_form.php" title="dodaj" class="zakladki aktywna" id="z_02">DODAJ WYDARZENIE</a></li>
    </ul>
    <div id="lista" class="zawartosc">
      <h3 id="nagRamka1">EDYCJA WYDARZENIA - KLASA <?php echo $klasa .' '. $sb; ?></h3>
      <form action="db_wydarzenia_upd.php" method="post" name="form" id="form">
      <input type="hidden" name="id_wyd" id="id_wyd" value="<?php echo $id_wyd ?>">
        <table id="center-tabela-pod-3">
        <tr><td class="dane-3">Data:*</td></tr>
        <tr><td class="dane-3"><input type="text" id="data-left" size="30" class="pole-center" name="data" value="<?php echo $data ?>"></td></tr>
        <tr><td class="dane-3">Wydarzenie:*</td></tr>
        <tr><td class="dane-3"><textarea name="informacje" rows="2" cols="80"><?php echo $wydarzenie ?></textarea></td></tr>
        <tr>
          <td colspan="2" class="center-3"><input type="button" value="Popraw wydarzenie" class="button" id="poprawWydarzenie"></td>
        </tr>
        </table>
      </form>
    </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>