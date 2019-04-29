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

$baza = new zapytanie;
$query = "SELECT * FROM users WHERE id='$id_db'";
$baza->pytanie($query);

//Dane użytkownika
$id = $baza->tab[0];
$nazwisko = $baza->tab[1];
$imie = $baza->tab[2];
$login = $baza->tab[3];
$passwd = $baza->tab[3];
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

<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie_db,' ',$nazwisko_db,' - '. iden($kto);  ?></p>
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
  <div class="center" id="formularz">

  <div id="edycja"><h3>ZMIANA HASŁA UŻYTKOWNIKA - <?php echo $imie_db .' '. $nazwisko_db ?></h3></div>
  <form action="usr_pass_upd.php" method="post" name="formUpr" id="formUpr">
  <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
  <input type="hidden" id="st" name="st" value="<?php echo $rola_db; ?>">
  <table id="center-tabela">
    <tr>
      <td class="prawy">Podaj swój login:*</td><td class="srodek"><input type="text" id="logon" size="37" class="pole" name="logon" value=""></td>
      <td><div class="kontrola" id="konLogin"></div></td>
    </tr>
    <tr>
      <td class="prawy">Podaj dotychczasowe hasło:*</td>
      <td><input type="password" id="passwdStary" size="37" class="pole" name="passwdStary" value=""></td>
      <td><div class="kontrola" id="konPasswdStary"></div></td>
    </tr>
    <tr>
      <td class="prawy">Podaj nowe hasło:*</td>
      <td><input type="password" id="passwd" size="37" class="pole" name="passwd" value=""></td>
      <td><div class="kontrola" id="konPasswdPow"></div></td>
    </tr>
    <tr>
      <td class="prawy">Powtórz hasło:*</td>
      <td><input type="password" id="passwdPow" size="37" class="pole" name="passwdPow" value=""></td>
      <td> <div class="kontrola" id="konHasla"></div></td>
    </tr>
    <tr>
      <td colspan="3"><div class="kontrola" id="konPasswd"></div></td>
    </tr>
    <tr>
    <td class="prawy">E-mail:</td>
      <td><input type="text" id="email" size="37" class="pole" name="email" value="<?php if(isset($email)){echo $email;}; ?>"></td>
      <td><div class="kontrola" id="konEmail"></div></td>
    </tr>
    <tr>
      <td colspan="3"><input type="button" value="Zapisz zmianę" class="button" id="zmien"></td>
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