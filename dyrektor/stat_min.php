<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_03.js"></script>
<link href="styl/styl_stat.css" rel="stylesheet" type="text/css">
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
include_once('../class/minmax_uczen.class.php');
include_once('../class/news.class.php');

//Zmienne
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$zm = 2.0;

//Miesiac
$msc= date("n");

//Obiekty
$wiadomosc = new news;

//Funkcja - interfejs nieklasyfikowania
function interfejsNkl($sem,$zm)
{
  $bazanajUczniowie = new najlpSpUczniowie;

  $tab = $bazanajUczniowie->bez_nkl($sem,$zm);
  $nr = 0;
  
  if(isset($tab))
  foreach($tab as $uczen)
  {
	  $nr++;
	  $uczen = explode('; ', $uczen);
	  
	  $sr = $uczen[0];
	  $kl = $uczen[1];
	  $sb = $uczen[2];
	  $nazwisko = $uczen[3];
	  $imie = $uczen[4];
	  $przedmiot = $uczen[4];
  
	  $klasa = $kl.' '.$sb;
	  $dane = $nazwisko.' '.$imie;
	  $srednia = $sr;
	  
	  echo'<tr>';
	  echo'<td>'.$nr.'</td>';
	  echo'<td>'.$klasa.'</td>';
	  echo'<td class="kto-co">'.$dane.'</td>';
	  echo'<td>'.$srednia.'</td>';
	  echo'</tr>';	  
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
      <h3 id="nagRamka4">UCZNIOWIE ZE ŚREDNIĄ MNIEJSZĄ - <span class="red">2.00</span></h3>
      <table id="zestawienie-2">
        <tr>
        <th class="nr">Nr</th>
        <th class="kl">Klasa</th>
        <th class="dane">Nazwisko i imię</th>
        <th>Średnia</th>
        </tr>
        <?php
          if($msc < 6)
          {
            interfejsNkl('ocen_sem',$zm);
          } elseif ($msc > 5 && ($msc != 7 || $msc != 8)) {
            interfejsNkl('ocen_rok',$zm); 
          }
        ?>
      </table>        
      
      <div id="user"></div>
    </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>