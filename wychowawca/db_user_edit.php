<?php
include_once('status.php');
$_SESSION['wstecz'] = 1;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="../javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_pas.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<link href="styl/styl_szkola.css" rel="stylesheet" type="text/css">

</head>
<body onload="window.scrollTo(0, 200)">
<?php

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerm MySQL
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
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$id_db = $_SESSION['id_db'];
$kto = $_SESSION['kto'];

$id = $_GET['id'];
$zw = $_GET['zw'];

$baza = new zapytanie;
$query = "SELECT * FROM users WHERE id='$id'";
$baza->pytanie($query);

//Dane użytkownika
$id = $baza->tab[0];
$nazwisko = $baza->tab[1];
$imie = $baza->tab[2];
$login = $baza->tab[3];
$passwd = $baza->tab[4];
$email = $baza->tab[6];

function iden($kto)
{
  if($_SESSION['kto'] == "Wychowawca")
  {
	 return $_SESSION['idenfyfikator'];
  }	else {
	 return $_SESSION['kto'];
  }
}
?>
<div class="wpis" id="<?php echo $zw;?>">
<div id="kontener">
  <div id="logo">
    <img src="../image/logo_user.png" alt="Logo">
    <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $_SESSION['imie_db'],' ',$_SESSION['nazwisko_db'],' - ', $_SESSION['kto'],' klasy: ',$_SESSION['klasa'],' ',$_SESSION['sb']; ?></p>
  </div>
  <div id="opis"><div id="nowosc"><?php $wiadomosc->wiadomosc(); ?></div>
   <p class="info">
   <a class="linki" href="../logout.php">Wylogowanie</a>
   </p>
  </div>
  <div id="spis"><?php include_once('menu.php');?></div>  
  <div id="czescGlowna">
  <div class="center" id="formularz">
  <div id="edycja"><h3 class="center">ZMIANA HASŁA UŻYTKOWNIKA - <?php echo $imie .' '. $nazwisko ?></h3></div>
  <form action="db_user_pass_upd.php" method="post" name="formUpr" id="formUpr">
  <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
  <input type="hidden" id="wpis" name="wpis" value="<?php echo $zw; ?>">
  <table id="center-3-tabela">
    <tr>
      <td class="prawy">Login:*</td>
      <td class="prawy"><input type="text" id="login" size="37" class="pole" name="login" value="<?php echo $login ; ?>"></td>
      <td class="prawy"><div class="kontrola" id="Login_kon"></div></td>
    </tr>
    <tr>
      <td class="prawy">Hasło:*</td>
      <td class="prawy"><input type="text" id="passwd" size="37" class="pole" name="passwd" value="<?php echo $passwd ; ?>"></td>
      <td class="prawy"><div class="kontrola" id="Passwd_kon"></div></td>
    </tr>
    <tr>
      <td colspan="3" class="srodek"><input type="button" value="Zapisz zmianę" class="button" id="zmien"></td>
    </tr>
  </table>
  </form>
    <div id="informacje-6">
    <p>* - w tym polu dane są obowiązkowe</p>
    </div>
  </div>
  <div class="kontrola" id="konDanych"></div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>