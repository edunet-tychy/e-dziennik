<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Zmienne
$id_kl = $_SESSION['id_kl'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$klasa = $_SESSION['klasa'];
$sb = $_SESSION['sb'];

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

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
      <li><a href="db_uczen.php" title="lista" class="zakladki" id="z_01">LISTA UCZNIÓW</a></li>
      <li><a href="db_uczen_form.php" title="dodaj" class="zakladki aktywna" id="z_02">DODAJ UCZNIA</a></li>
    </ul>
    <div id="lista" class="zawartosc">
      <h3 id="nagRamka1">DODAJ NOWEGO UCZNIA DO KLASY <?php echo $klasa .' '. $sb; ?></h3>
      <form action="db_uczen_dod.php" method="post" name="form" id="form">
        <table class="center">
        <tr>
          <td class="dane">Nazwisko:*</td>
          <td><input type="text" id="nazwisko" size="30" class="pole" name="nazwisko"></td>
          <td><div class="kontrola" id="konNazw"></div></td>
          <td class="dane">Imię:*</td>
          <td><input type="text" id="imie" size="30" class="pole" name="imie"></td>
          <td><div class="kontrola" id="konImie"></div></td>
        </tr>
        <tr>
          <td class="dane">E-mail:*</td>
          <td><input type="email" id="email" size="30" class="pole" name="email" value="Brak"></td>
          <td><div class="kontrola" id="konEmail"></div></td>
          <td class="dane">Login:*</td>
          <td><input type="text" id="login" size="30" class="pole" name="login"></td>
          <td><input type="button" value="Generuj login" class="button" id="genLog"></td>
        </tr>
        <tr>
          <td class="dane">Hasło:*</td>
          <td><input type="password" id="passwd" size="30" class="pole" name="passwd" maxlength="8"></td>
          <td><input type="button" value="Generuj hasło" class="button" id="genHas"></td>
          <td class="dane">Powtórz hasło:*</td>
          <td><input type="password" id="passwdPow" size="30" class="pole" name="passwdPow" maxlength="8"></td>
          <td><div class="kontrola" id="konPasswdPow"></div></td>
        </tr>
        <tr>
          <td class="dane">Nr ewidencyjny:*</td>
          <td><input type="text" id="nrEwiden" size="30" class="pole" name="nrEwiden"></td>
          <td><div class="kontrola" id="konNrEwiden">000/X00</div></td>
          <td class="dane">Pesel:</td><td><input type="text" id="pesel" size="30" class="pole" name="pesel"  maxlength="11"></td>
          <td><div class="kontrola" id="konPesel"></div></td>
        </tr>
        <tr>
          <td class="dane">Data urodzenia:*</td>
          <td><input type="text" id="dataUrodz" size="30" class="pole" name="dataUrodz"></td>
          <td><div class="kontrola" id="konDataUrodz">RRRR-MM-DD</div></td>
          <td class="dane">Miejsce urodz.:*</td>
          <td><input type="text" id="miejsceUrodz" size="30" class="pole" name="miejsceUrodz" value="Tychy"></td>
          <td><div class="kontrola" id="konMiejsceUrodz"></div></td>
        </tr>
        <tr>
          <td class="dane">Płeć:*</td>
          <td>
          <select name="plec" id="plec">
            <option value="m">chłopiec</option>
            <option value="k">dziewczyna</option>
          </select>
          </td>
          <td colspan="4"></td>
        </tr>
        <tr><td></td><td>RODZICE/OPIEKUNOWIE</td><td colspan="4"></td></tr>
        <tr>
          <td class="dane">Imię matki:*</td>
          <td><input type="text" id="imieMatki" size="30" class="pole" name="imieMatki"></td>
          <td><div class="kontrola" id="konImieMatki"></div></td>
          <td class="dane">Nazwisko:*</td>
          <td><input type="text" id="nazwiskoR" size="30" class="pole" name="nazwiskoR" value=""></td>
          <td><div class="kontrola" id="konNazwisko"></div></td>
        </tr>
        <tr>
          <td class="dane">Imię ojca:*</td>
          <td><input type="text" id="imieOjca" size="30" class="pole" name="imieOjca"></td>
          <td><div class="kontrola" id="konImieOjca"></div></td>
        </tr>
        <tr>
          <td></td>
          <td>ADRES ZAMIESZKANIA</td><td colspan="4"></td>
        </tr>
        <tr>
          <td class="dane">Ulica:*</td>
          <td><input type="text" id="ulica" size="30" class="pole" name="ulica"></td>
          <td><div class="kontrola" id="konUlica"></div></td>
          <td class="dane">Miasto:*</td>
          <td><input type="text" id="miasto" size="30" class="pole" name="miasto" value="Tychy"></td>
          <td><div class="kontrola" id="konMiasto"></div></td>
        </tr>
        <tr>
          <td class="dane">Lokal:*</td>
          <td><input type="text" id="lokal" size="30" class="pole" name="lokal"></td>
          <td><div class="kontrola" id="konLokal"></div></td>
          <td class="dane">Województwo:*</td>
          <td><input type="text" id="woj" size="30" class="pole" name="woj" value="śląskie"></td>
          <td><div class="kontrola" id="konWoj"></div></td>
        </tr>
        <tr>
          <td class="dane">Kod:*</td>
          <td><input type="text" id="kod" size="30" class="pole" name="kod" value="43-100"></td>
          <td colspan="4"><div class="kontrola" id="konKod"></div></td>
        </tr>
        <tr>
          <td></td>
          <td>DANE KONTAKTOWE</td>
          <td colspan="4"></td>
        </tr>
        <tr>
          <td class="dane">E-mail:</td>
          <td><input type="text" id="emailRodzic" size="30" class="pole" name="emailRodzic"></td>
          <td><div class="kontrola" id="konEmailRodzic"></div></td>
          <td class="dane">Telefon:*</td>
          <td><input type="text" id="telefon" size="30" class="pole" name="telefon"></td>
          <td><div class="kontrola" id="konTelefon">000-000-000</div></td>
        </tr>
        <tr>
          <td colspan="6" class="center-2"><input type="button" value="Dodaj ucznia do klasy" class="button" id="dodajUcznia"></td>
        </tr>
        <tr>
          <td colspan="6"><div class="kontrola" id="konLoginu"></div><div class="kontrola" id="konPasswd"></div></td>
        </tr>
        </table>
        <div id="informacje">
          <p>* - w tym polu dane są obowiązkowe</p>
        </div
      ></form>
    </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>