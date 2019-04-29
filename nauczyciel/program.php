<?php
include_once('status.php');
$_SESSION['wstecz'] = 1;
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
include_once('../class/programy.class.php');
include_once('../class/programy_przedmiot.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

//Zmienne
$kto=$_SESSION['zalogowany'];
$id = $_SESSION['id_db'];
$nazwisko = $_SESSION['nazwisko_db'];
$imie = $_SESSION['imie_db'];
$rola = $_SESSION['rola_db'];
$id_kl = $_GET['id_kl'];

//Obiekty
$baza = new zapytanie;
$kl = "SELECT klasa, sb FROM vklasy WHERE id_kl='$id_kl'";
$baza->pytanie($kl);
$klasa = $baza->tab[0];	
$sb = $baza->tab[1];

//ustawienei zmiennych sesyjnych
$_SESSION['klasa'] = $klasa;
$_SESSION['sb'] = $sb;

$bazaProgarm = new programy;
$bazaPrzedmiot = new program_przedmiot;

$id = $_SESSION['id_db'];

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
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $_SESSION['imie_db'],' ',$_SESSION['nazwisko_db'],' - ', iden($kto) ?></p>
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
    <li><a href="#" title="Program" class="zaj aktywna" id="pod_1">Przypisz program</a></li>
    <li><a href="program_form.php?id_kl=<?php echo $id_kl ?>" title="Program" class="zaj" id="pod_2">Dodaj program</a></li>
    </ul>
    <div id="lista" class="zawartosc">
    <h3 id="nagRamka">KLASA - <?php echo $klasa. ' '. $sb ?></h3>
      <form action="program_przyp.php?id_kl=<?php echo $id_kl ?>" method="post" name="form" id="form">
        <table id="center-tabela-pod-3">
        <tr><td class="dane-3" colspan="2">Nauczany przedmiot:*</td></tr>
        <tr><td class="dane-3" colspan="2">
        <select class="min-6" name="przedmiot">
          <?php $bazaPrzedmiot->przedmiot($id,$id_kl,$mysqli); ?>
        </select>
        </td></tr>
        <tr><td class="dane-3" colspan="2">Tytuł programu:*</td></tr>
        <tr><td class="dane-3" colspan="2">
        <select class="min-5" name="prog">
          <?php $bazaProgarm->program($mysqli); ?>
        </select>
        </td></tr>
        <tr>
        <td colspan="2" class="center-3"><input type="button" value="Przypisz program" class="button" id="przypiszProgram"></td>
        </tr>
        </table>
      </form>
    </div>
    <div id="user"></div><br><br>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>