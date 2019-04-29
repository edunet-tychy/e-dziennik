<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="../javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<link href="styl/styl_szkola.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.scrollTo(0, 200)">
<?php

//Nawiązanie połączenia serwerem MySQL
include_once('db_connect.php');

//Klasy
include_once('../class/zapytanie.class.php');

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
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$id = $_GET['id'];

$baza = new zapytanie;
$query = "SELECT * FROM users WHERE id='$id'";
$baza->pytanie($query);

$id = $baza->tab[0];
$nazwisko = $baza->tab[1];
$imie = $baza->tab[2];
$login = $baza->tab[3];
$passwd = $baza->tab[4];
$email = $baza->tab[6];
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
  <div class="left-u" id="formularz">
  <?php
  $r_user=$_GET['st'];
  switch($r_user)
  {
    case 1: $formUser = "ADMINISTRATOR"; break;
    case 2: $formUser = "DYREKTOR"; break;
    case 4: $formUser = "NAUCZYCIEL"; break;
  }	
  ?>
  <h3>EDYCJA UŻYTKOWNIKA - <?php echo $formUser ?></h3>
  <form action="db_user_upd.php" method="post" name="formUp" id="formUp">
  <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
  <input type="hidden" id="st" name="st" value="<?php echo $r_user; ?>">
    <table>
    <tr>
      <td class="dane">Nazwisko:*</td><td><input type="text" id="nazwisko" size="30" class="pole" name="nazwisko" value="<?php if(isset($nazwisko)){echo $nazwisko;}; ?>"></td>
      <td><div class="kontrola" id="konNazw"></div></td>
    </tr>
    <tr>
      <td class="dane">Imię:*</td><td><input type="text" id="imie" size="30" class="pole" name="imie" value="<?php if(isset($imie)){echo $imie;}; ?>"></td>
      <td><div class="kontrola" id="konImie"></div></td>
    </tr>
    <tr>
      <td class="dane">E-mail:</td>
      <td><input type="text" id="email" size="30" class="pole" name="email" value="<?php if(isset($email)){echo $email;}; ?>"></td>
      <td><div class="kontrola" id="konEmail"></div></td>
    </tr>
    <tr>
      <td class="dane">Login:*</td>
      <td><input type="text" id="login" size="30" class="pole" name="login" value="<?php if(isset($login)){echo $login;}; ?>"></td>
      <td><input type="button" value="Generuj login" class="button" id="genLog"></td>
    </tr>
    <tr>
      <td class="dane">Hasło:*</td><td><input type="password" id="passwd" size="30" class="pole" name="passwd" value="<?php if(isset($passwd)){echo $passwd;}; ?>"></td>
      <td><input type="button" value="Generuj hasło" class="button" id="genHas"></td>
    </tr>
    <tr>
      <td class="dane">Powtórz hasło:*</td>
      <td><input type="password" id="passwdPow" size="30" class="pole" name="passwdPow" value="<?php if(isset($passwd)){echo $passwd;}; ?>"></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="3"><input type="button" value="Popraw dane" class="button" id="popraw"></td>
    </tr>
    </table>
  </form>
    <div id="informacje-5">
    <p>* - w tym polu dane są obowiązkowe</p>
    </div>
    <div class="kontrola" id="konLoginu"></div>
    <div class="kontrola" id="konPasswd"></div>
  </div>
  <div class="right-u">
  <h3>LISTA NAUCZYCIELI</h3>
  <div id="user">
  </div>
  <br><br>
  </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>