<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="../javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_zawod.js"></script>
<link href="styl/styl_szkola.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function()
{
  var url = "db_zawod_pok.php";
  $("#pokazZawod").load(url);
});
</script>
</head>
<body onload="window.scrollTo(0, 200)">

<?php
//Nawiązanie połączenia z serwerem MySQL.
include_once('db_connect.php');

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;
 
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
$id = $_GET['id'];

$baza = new zapytanie;
$query = "SELECT nazwa,symbol,sb FROM zawod WHERE id_zw='$id'";
$baza->pytanie($query);

$tab = $baza->tab[0];
$nazwa = $baza->tab[0];
$symbol = $baza->tab[1];
$sb = $baza->tab[2];

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
	<h3 id="naglPrzedmiot">EDYCJA - ZAWODY</h3>
	<form action="db_zawod_upd.php" method="post" name="form" id="form">
    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
      <table id="szkola">
      <tr>
        <td class="opis">Nazwa zawodu:*</td>
        <td><input type="text" id="nazwaZawoduEdycja" size="40" class="pole" name="nazwaZawoduEdycja" value="<?php if(isset($nazwa)){echo $nazwa;}; ?>"></td>
      </tr>
      <tr>
        <td class="opis">Symbol zawodu:*</td>
        <td><input type="text" id="symbolZawoduEdycja" size="40" class="pole" name="symbolZawoduEdycja" value="<?php if(isset($symbol)){echo $symbol;}; ?>"></td>
      </tr>
      <tr>
        <td class="opis">Skrót zawodu:*</td>
        <td><input type="text" id="skrotZawoduEdycja" size="40" class="pole" name="skrotZawoduEdycja" value="<?php if(isset($sb)){echo $sb;}; ?>"></td>
      </tr>
      <tr>
      	<td></td><td><input type="button" value="Popraw dane" class="button" id="poprawZawod"></td><td></td>
      </tr>
      </table>
	</form>
	</div>
      <div class="right">
        <h3>ZAWODY</h3>
        <div id="pokazZawod"></div>
        <br><br>
      </div>
	</div>
	<div id="stopka">
	<p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
	</div>
</div>
</body>
</html>