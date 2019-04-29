<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_d.js"></script>
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
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$klasa = $_SESSION['klasa'];
$sb = $_SESSION['sb'];

$id_przed = $_GET['id_przed'];

if($result = $mysqli->query("SELECT nazwa FROM przedmioty WHERE id_przed='$id_przed'"))
{
  if($result->num_rows > 0)
  {
	while($row=$result->fetch_object())
	{
	  $nazwa = $row->nazwa;
	}
  }
}

?>

<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie_db,' ',$nazwisko_db,' - ', $kto; ?></p>
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
    <div id="lista" class="zawartosc">
      <h3 id="nagRamka1"><?php echo mb_strtoupper($nazwa,"UTF-8"); ?> - DODAJ NOWE ZAGADNIENIE - KLASA <?php echo $klasa .' '. $sb; ?></h3>
      <form action="rozklad_dod.php?id_kl=<?php echo $_GET['id_kl'];?>&id_przed=<?php echo $_GET['id_przed'];?>" method="post" name="form" id="form">
        <table id="center-tabela-pod-3">
        <tr><td class="dane-3" colspan="2">Miesiąc realizacji:*</td></tr>
        <tr><td class="dane-3" colspan="2">
        <select class="min-1" name="miesiac">
          <option value="1">Wrzesień</option>
          <option value="2">Październik</option>
          <option value="3">Listopad</option>
          <option value="4">Grudzień</option>
          <option value="5">Styczeń</option>
          <option value="6">Luty</option>
          <option value="7">Marzec</option>
          <option value="8">Kwiecień</option>
          <option value="9">Maj</option>
          <option value="10">Czerwiec</option>
        </select>
        </td></tr>
        <tr><td class="dane-3" colspan="2">Treść zagadnienia:*</td></tr>
        <?php
        for($i=0; $i < 10; $i++)
        {
          echo'<tr>';
          echo'<td class="dane-3">';
          echo'<input class="dane" type="text" name="wpis_'.$i.'" id="">';
          echo'</td>';
          echo'<td class="dane-6">';
          echo'<select class="min-4" name="godz_'.$i.'">';
            echo'<option value="1">1 godz.</option>';
            echo'<option value="2">2 godz.</option>';
            echo'<option value="3">3 godz.</option>';
            echo'<option value="4">4 godz.</option>';
            echo'<option value="5">5 godz.</option>';
            echo'<option value="6">6 godz.</option>';
          echo'</select>';
          echo'</td>';
          echo'</tr>';
        }
        ?>
        <tr>
          <td colspan="2" class="center-3"><input type="button" value="Dodaj zagadnienie" class="button" id="dodajZagadnienie"></td>
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