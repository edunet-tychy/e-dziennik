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
<body>

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
   $mysqli->connect_error;
}

//Zmienne
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$id = $_GET['id'];

//Obiekty
$wiadomosc = new news;

$baza = new zapytanie;
$query_1 = "SELECT * FROM vwychowawca WHERE id_kl='$id'";
$baza->pytanie($query_1);

$id_sz = $baza->tab[0];
$id_kl = $baza->tab[1];
$id_wych = $baza->tab[2];
$nazwisko = $baza->tab[3];
$id_imie = $baza->tab[4];
$klasa = $baza->tab[5];
$sb = $baza->tab[6];

$bazaKlasa = new zapytanie;
$query_2 = "SELECT id_zw FROM klasy WHERE id_wych='$id_wych'";
$bazaKlasa->pytanie($query_2);
$id_zw = $bazaKlasa->tab[0];

$bazaZawod = new zapytanie;
$query_3 = "SELECT nazwa FROM zawod WHERE id_zw='$id_zw'";
$bazaZawod->pytanie($query_3);
$zawod = $bazaZawod->tab[0];

$bazaWychowawca = new zapytanie;
$query_4 = "SELECT nazwisko, imie FROM users WHERE id='$id_wych'";
$bazaWychowawca->pytanie($query_4);
$nazwisko = $bazaWychowawca->tab[0];
$imie = $bazaWychowawca->tab[1];
$wychowawca = $nazwisko.' '.$imie;

$na = new nauczyciele;

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
  <h3 id="naglKlasa">EDYCJA KLASY: <?php echo $klasa .' '. $sb .' - ZMIANA WYCHOWAWCY'; ?></h3>
  <form action="db_klasa_upd.php" method="post" name="formUp" id="formUp">
  <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
  <input type="hidden" id="id_sz" name="id_sz" value="<?php echo $id_sz; ?>">
  <input type="hidden" id="id_zw" name="id_zw" value="<?php echo $id_zw; ?>">
  <input type="hidden" id="klasa" name="klasa" value="<?php echo $klasa; ?>">
  <input type="hidden" id="id_wych" name="id_wych" value="<?php echo $id_wych; ?>">
    <table>
    <tr>
      <td class="opis">Klasa:</td>
      <td><input type="text" id="klasaEdycja" size="40" class="pole" name="klasaEdycja" value="<?php if(isset($klasa)){echo $klasa;}; ?>"></td>
    </tr>
    <tr>
      <td class="opis">Nazwa:</td>
      <td><input type="text" id="zawodEdycja" size="40" class="pole" name="zawodEdycja" value="<?php if(isset($zawod)){echo $zawod;}; ?>"></td>
    </tr>
    <tr>
      <td class="opis">Wychowawca:</td>
      <td>
      <select name="nauczycieleEdycja" id="nauczycieleEdycja">
      <?php 
		echo'<option value="'.$id_wych.'">'.$wychowawca.'</option>';
		echo'<option value="brak">---</option>';
		$na->nauczyciel();
      ?>
      </select>
      </td>
    </tr>
    <tr>
      <td></td><td><input type="button" value="Popraw dane" class="button" id="poprawKlasa"></td><td></td>
    </tr>
    </table>
  </form>
  </div>
  <div class="right">
  <h3>KLASY</h3>
  <div id="pokazKlas">
  </div>
  <script type="text/javascript">
  $(document).ready(function()
  {
      var url = "db_klasa_pok.php?id_sz=" + <?php echo $id_sz?>;
      $("#pokazKlas").load(url);
  });
  </script>
  <br><br>
  </div>

  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>