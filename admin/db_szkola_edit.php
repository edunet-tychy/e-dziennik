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
<script type="text/javascript">
$(document).ready(function()
{
  var url = "db_szkola_pok.php";
  $("#pokazSzkola").load(url);
});
</script>
</head>
<body onload="window.scrollTo(0, 200)">

<?php
//Nawiązanie połączenia serwerem MySQL.
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
$id_db = $_SESSION['id_db'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$id_sz = $_GET['id'];

//Zapytanie - Uwagi
$szkoly = "SELECT * FROM szkoly WHERE id_sz='$id_sz'";
$baza = new zapytanie;
$baza->pytanie($szkoly);

$id_sz = $baza->tab[0];
$opis = $baza->tab[1];
$skrot = $baza->tab[2];
$typ = $baza->tab[3];

//Funkcja - skrót i pełna nazwa
function skrot($typ)
{
  switch ($typ) 
  {
	case "LO": $nazwa = '<option value="LO">liceum ogólnokształące</option>'; break;
	case "T": $nazwa = '<option value="T">technikum</option>'; break;
	case "ZSZ": $nazwa = '<option value="ZSZ">szkoła zawodowa</option>'; break;
  }
  return $nazwa;
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
  <div class="left" id="formularz">
  <h3 id="naglPrzedmiot">EDYCJA - SZKOŁA</h3>
  <form action="db_szkola_upd.php" method="post" name="formUpSzkola" id="formUpSzkola">
  <input type="hidden" id="id" name="id" value="<?php echo $id_sz; ?>">
    <table id="szkola">
    <tr>
      <td class="opis">Nazwa szkoły:*</td>
      <td><input type="text" id="nazwaSzkolyEdycja" size="40" class="pole" name="nazwaSzkolyEdycja" value="<?php if(isset($opis)){echo $opis;}; ?>"></td>
    </tr>
    <tr>
      <td class="opis">Symbol szkoły:*</td>
      <td><input type="text" id="symbolSzkolyEdycja" size="40" class="pole" name="symbolSzkolyEdycja" value="<?php if(isset($skrot)){echo $skrot;}; ?>"></td>
    </tr>
    <tr><td class="opis">Typ szkoły:*</td>
    <td>
    <select name="typSzkolyEdycja" id="typSzkolyEdycja">
      <?php echo skrot($typ);?>
      <option value="xx">...</option>
      <option value="LO">liceum ogólnokształące</option>
      <option value="T">technikum</option>
      <option value="ZSZ">szkoła zawodowa</option>
    </select>
    </td>
    <tr>
      <td></td><td><input type="button" value="Popraw dane" class="button" id="poprawSzkola"></td><td></td>
    </tr>
    </table>
  </form>
    <div id="informacje-2">
    <p>* - w tym polu dane są obowiązkowe</p>
    </div>
  </div>
    <div class="right">
      <h3>SZKOŁY</h3>
      <div id="pokazSzkola"> </div><br><br>
    </div>
    <div class="kontrola" id="konLoginu"></div><div class="kontrola" id="konPasswd"></div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>