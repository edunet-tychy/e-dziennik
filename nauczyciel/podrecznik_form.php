<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_pod.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
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
$nazwisko = $_SESSION['nazwisko_db'];
$imie = $_SESSION['imie_db'];
$rola = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$klasa = $_SESSION['klasa'];
$sb = $_SESSION['sb'];
$id_kl = $_GET['id_kl'];
?>

<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie,' ',$nazwisko,' - ', $_SESSION['kto'] ?></p>
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
    <ul class="nawigacja_new">
    <li><a href="podrecznik.php?id_kl=<?php echo $id_kl ?>" title="Podręcznik" class="zaj" id="pod_1">Przypisz podręcznik</a></li>
    <li><a href="podrecznik_form.php?id_kl=<?php echo $id_kl ?>" title="Podręcznik" class="zaj aktywna" id="pod_2">Dodaj podręcznik</a></li>
    </ul>
    <div id="lista" class="zawartosc">
      <h3 id="nagRamka1">DODAJ NOWY PODRĘCZNIK</h3>
      <form action="podrecznik_dod.php?id_kl=<?php echo $id_kl;?>" method="post" name="form" id="form">
        <table id="center-tabela-pod-3">
          <tr><td class="dane-3" colspan="2">Nr dopuszczenia:*</td></tr>
          <tr><td class="dane-3"><input class="dane-1" type="text" name="nr_dop" id="nr_dop"></td></tr>
          <tr><td class="dane-3" colspan="2">Tytuł:*</td></tr>
          <tr><td class="dane-3"><input class="dane" type="text" name="tytul" id="tytul"></td></tr>
          <tr><td class="dane-3" colspan="2">Autorzy:*</td></tr>
          <tr><td class="dane-3"><input class="dane-2" type="text" name="autorzy" id="autorzy"></td></tr>
          <tr><td class="dane-3" colspan="2">Wydawnictwo:*</td></tr>
          <tr><td class="dane-3"><input class="dane-3" type="text" name="wyd" id="wyd"></td></tr>
        <tr>
          <td colspan="2" class="center-3"><input type="button" value="Dodaj podręcznik" class="button" id="dodajPodrecznik"></td>
        </tr>
        </table>
      </form>
    </div><br>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>