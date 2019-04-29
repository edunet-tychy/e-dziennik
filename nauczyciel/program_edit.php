<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_prog.js"></script>
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
$id_prog = $_GET['id_prog'];

//Obiekt
$baza = new zapytanie;
$query = "SELECT * FROM programy WHERE id_prog = '$id_prog'";
$baza->pytanie($query);
$tytul = $baza->tab[1];

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
    <li><a href="program.php?id_kl=<?php echo $id_kl ?>" title="Program" class="zaj" id="pod_1">Przypisz program</a></li>
    <li><a href="program_form.php?id_kl=<?php echo $id_kl ?>" title="Program" class="zaj" id="pod_2">Dodaj program</a></li>
    </ul>
    <div id="lista" class="zawartosc">
      <h3 id="nagRamka1">EDYCJA - DANE PROGRAMU</h3>
      <form action="program_upd.php?id_kl=<?php echo $id_kl;?>&id_prog=<?php echo $id_prog;?>" method="post" name="form" id="form">
        <table id="center-tabela-pod-3">
          <tr><td class="dane-3" colspan="2">Tytuł programu:*</td></tr>
          <tr><td class="dane-3"><input class="dane" type="text" name="tytul" id="tytul" value="<?php echo $tytul; ?>"></td></tr>
        <tr>
          <td colspan="2" class="center-3"><input type="button" value="Popraw dane programu" class="button" id="poprawProgram"></td>
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