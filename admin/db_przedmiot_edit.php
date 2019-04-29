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
$id = $_GET['id'];

$baza = new zapytanie;
$query = "SELECT * FROM przedmioty WHERE id_przed='$id'";
$baza->pytanie($query);

$id_przed = $baza->tab[0];
$nazwa = $baza->tab[1];
$skrot = $baza->tab[2];
$licz_sr = $baza->tab[3];
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
  <h3 id="naglPrzedmiot">EDYCJA PRZEDMIOTU</h3>
  <form action="db_przedmiot_upd.php" method="post" name="formUp" id="formUp">
  <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
    <table>
    <tr>
      <td class="opis">Nazwa przedmiotu:*</td>
      <td><input type="text" id="przedEdycja" size="40" class="pole" name="przedEdycja" value="<?php if(isset($nazwa)){echo $nazwa;}; ?>" maxlength="30"></td>
    </tr>
    <tr>
      <td class="opis">Skrócona nazwa:*</td>
      <td><input type="text" id="skrotEdycja" size="40" class="pole" name="skrotEdycja" value="<?php if(isset($skrot)){echo $skrot;}; ?>" maxlength="7"></td>
    </tr>
    <tr>
      <td class="opis">Liczony do średniej:</td>
      <td><input type="checkbox" id="sredEdycja" class="pole" name="sredEdycja" value="<?php if(isset($licz_sr)){echo $licz_sr;}; ?>" checked></td>
    </tr>
    <tr>
      <td></td><td><input type="button" value="Popraw dane" class="button" id="poprawPrzedmiot"></td>
    </tr>
    </table>
  </form>
    <div id="informacje-3">
    <p>* - w tym polu dane są obowiązkowe</p>
    </div>
  </div>
  <div class="right">
    <h3>PRZEDMIOTY</h3>
    <div id="pokazPrzedmioty"></div><br><br>
  </div>

  </div>
  <div id="stopka">
    <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>