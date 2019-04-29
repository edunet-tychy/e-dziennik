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
  var url = "db_dane_szkola_pok.php";
  $("#pokazDaneSzkola").load(url);
});
</script>
</head>
<body>

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
$query = "SELECT * FROM dane_szkoly WHERE id='$id'";
$baza->pytanie($query);

$id = $baza->tab[0];
$opis = $baza->tab[1];
$ulica = $baza->tab[2];
$kod = $baza->tab[3];
$miasto = $baza->tab[4];
$telefon = $baza->tab[5];
$email = $baza->tab[6];
$nip = $baza->tab[7];
$regon = $baza->tab[8];

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
  <h3 id="naglPrzedmiot">EDYCJA - DANE SZKOŁY</h3>
  <form action="db_dane_szkola_upd.php" method="post" name="formUpSzkola" id="formUpSzkola">
  <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
    <table id="szkola">
    <tr>
      <td class="opis">Pełna nazwa:*</td>
      <td><input type="text" id="pelnaNazwaSzkolyEdycja" size="40" class="pole" name="pelnaNazwaSzkolyEdycja" value="<?php if(isset($opis)){echo $opis;}; ?>" maxlength="30"></td>
    </tr>
    <tr>
      <td class="opis">Ulica:*</td>
      <td><input type="text" id="ulicaSzkolyEdycja" size="40" class="pole" name="ulicaSzkolyEdycja" value="<?php if(isset($ulica)){echo $ulica;}; ?>" maxlength="30"></td>
    </tr>
    <tr>
      <td class="opis">Kod:*</td>
      <td><input type="text" id="kodSzkolyEdycja" size="40" class="pole" name="kodSzkolyEdycja" value="<?php if(isset($kod)){echo $kod;}; ?>" maxlength="6"></td>
    </tr>
    <tr>
    <td class="opis">Miasto:*</td>
      <td><input type="text" id="miastoSzkolyEdycja" size="40" class="pole" name="miastoSzkolyEdycja" value="<?php if(isset($miasto)){echo $miasto;}; ?>" maxlength="25"></td>
    </tr>
    <tr>
    <td class="opis">Telefon:*</td>
      <td><input type="text" id="telefonSzkolyEdycja" size="40" class="pole" name="telefonSzkolyEdycja" value="<?php if(isset($telefon)){echo $telefon;}; ?>" maxlength="15"></td>
    </tr>
    <tr>
      <td class="opis">Email:*</td>
      <td><input type="text" id="emailSzkolyEdycja" size="40" class="pole" name="emailSzkolyEdycja" value="<?php if(isset($email)){echo $email;}; ?>" maxlength="25"></td>
    </tr>
    <tr>
      <td class="opis">Nip:* (000-000-00-00)</td>
      <td><input type="text" id="nipSzkolyEdycja" size="40" class="pole" name="nipSzkolyEdycja" value="<?php if(isset($nip)){echo $nip;}; ?>" maxlength="13"></td>
    </tr>
    <tr>
      <td class="opis">Regon:*</td>
      <td><input type="text" id="regonSzkolyEdycja" size="40" class="pole" name="regonSzkolyEdycja" value="<?php if(isset($regon)){echo $regon;}; ?>" maxlength="14"></td>
    </tr>
    <tr>
      <td></td><td><input type="button" value="Popraw dane" class="button" id="poprawDaneSzkola"></td><td></td>
    </tr>
    <tr>
      <td></td><td id="informacjaEdycja"></td><td></td>
    </tr>
    </table>
  </form>
  </div>
    <div class="right">
      <h3>DANE SZKOŁY</h3>
      <div id="pokazDaneSzkola"></div><br><br>
    </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>