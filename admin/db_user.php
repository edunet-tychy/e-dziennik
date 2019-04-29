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

//Zmienne
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$r_user=$_GET['st'];

//Funkcja - User
function user($r_user)
{
  switch($r_user)
  {
	case 1: $formUser = "ADMINISTRATOR"; break;
	case 2: $formUser = "DYREKTOR"; break;
	case 4: $formUser = "NAUCZYCIEL"; break;
  }	
  return $formUser;	
}
//Wywołanie funkcji User
$formUser = user($r_user);
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
  <h3>DODAJ NOWEGO UŻYTKOWNIKA - <?php echo $formUser ?></h3>
  <form action="db_user_dod.php" method="post" name="form" id="form">
    <table>
    <tr>
      <td class="dane">Nazwisko:*</td>
      <td><input type="text" id="nazwisko" size="30" class="pole" name="nazwisko"></td>
      <td><div class="kontrola" id="konNazw"></div></td>
    </tr>
    <tr>
      <td class="dane">Imię:*</td>
      <td><input type="text" id="imie" size="30" class="pole" name="imie"></td>
      <td><div class="kontrola" id="konImie"></div></td>
    </tr>
    <tr>
      <td class="dane">E-mail:</td>
      <td><input type="email" id="email" size="30" class="pole" name="email"></td>
      <td><div class="kontrola" id="konEmail"></div></td>
    </tr>
    <tr>
      <td class="dane">Login:*</td>
      <td><input type="text" id="login" size="30" class="pole" name="login"></td>
      <td><input type="button" value="Generuj login" class="button" id="genLog"></td>
    </tr>
    <tr>
    <td class="dane">Hasło:*</td>
      <td><input type="password" id="passwd" size="30" class="pole" name="passwd" maxlength="8"></td>
      <td><input type="button" value="Generuj hasło" class="button" id="genHas"></td>
    </tr>
    <tr>
      <td class="dane">Powtórz hasło:*</td>
      <td><input type="password" id="passwdPow" size="30" class="pole" name="passwdPow" maxlength="8"></td>
      <td><div class="kontrola" id="konPasswdPow"></div></td>
    </tr>
    <tr>
      <td colspan="3"><input type="button" value="Dodaj użytkownika" class="button" id="dodaj"></td>
    </tr>
    </table>
  <input type="hidden" id="st" name="st" value="<?php echo $r_user; ?>">
  </form>
    <div id="informacje-5">
    <p>* - w tym polu dane są obowiązkowe</p>
    </div>
      <div class="kontrola" id="konLoginu"></div>
      <div class="kontrola" id="konPasswd"></div>
  </div>
    <div class="right-u">
      <h3>LISTA NAUCZYCIELI</h3>
      <div id="user"></div><br><br>
    </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>