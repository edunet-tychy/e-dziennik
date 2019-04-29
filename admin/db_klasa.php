<?php
include_once('status.php');
$id_sz=$_GET['id_sz'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_szkola.js"></script>
<link href="styl/styl_szkola.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function()
{
  var url = "db_klasa_pok.php?id_sz=" + <?php echo $id_sz?>;
  $("#pokazKlas").load(url);
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

include_once('../class/zapytanie.class.php');
include_once('../class/zawody.class.php');
include_once('../class/nauczyciele.class.php');
include_once('../class/news.class.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];

//Obiekty
$wiadomosc = new news;
$zw = new zawody;
$na = new nauczyciele;

$baza = new zapytanie;
$query = "SELECT opis FROM szkoly WHERE id_sz='$id_sz'";
$baza->pytanie($query);

$opis = $baza->tab[0];
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
	<h3 id="naglKlasa">DODAJ KLASĘ DO SZKOŁY - <?php echo mb_strtoupper($opis,"UTF-8"); ?></h3>
	<form action="db_klasa_dod.php" method="post" name="form" id="form">
      <table>
      <tr>
        <td class="opis">Klasa:* (np. 1a, 1)</td>
        <td><input type="text" id="klasa" size="30" class="pole" name="klasa" maxlength="2"></td>
        <td><div class="kontrola" id="konKlasa"></div></td>
      </tr>
      <tr>
      <td class="opis">Nazwa:*</td>
      <td>
      <select name="zawod" id="zawod">
        <option value="x">...</option>
        <?php $zw->zawod(); ?> 
      </select>
      </td></tr>
      <tr><td class="opis">Wychowawca:*</td>
      <td>
      <select name="nauczyciele" id="nauczyciele">
        <option value="xx">...</option>
        <?php $na->nauczyciel(); ?>
      </select>
      </td></tr>
      <tr>
        <td></td><td><input type="button" value="Dodaj klasę" class="button" id="dodajKlase"></td><td></td>
      </tr>
      </table>
    <input type="hidden" id="id_sz" name="id_sz" value="<?php echo $id_sz; ?>">
	</form>
	</div>
    <div class="right">
	<h3>LISTA KLAS</h3>
	<div id="pokazKlas"></div>
	</div>

	</div>
	<div id="stopka">
	<p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
	</div>
</div>
</body>
</html>