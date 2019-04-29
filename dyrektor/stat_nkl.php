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
include_once('../class/nkl_uczen.class.php');
include_once('../class/news.class.php');

//Zmienne
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];

//Miesiac
$msc= date("n");

//Obiekty
$wiadomosc = new news;

//Funkcja - View: Uczniowie nieklasyfikowani
function interfejsNkl($sem,$ocena)
{
  $bazaNkl = new uczniowieNieklasyfikowani;
  $tab = $bazaNkl->nkl($sem,$ocena);
  $nr = 0;
  $pom_nazwisko = '';
  $przedmioty = '';
  $next = 0;
  
  if(isset($tab))
  foreach($tab as $uczen)
  {
	  $uczen = explode('; ', $uczen);
	  
	  $kl = $uczen[0];
	  $sb = $uczen[1];
	  $nazwisko = $uczen[2];
	  $imie = $uczen[3];
	  $przedmiot = $uczen[4];
	  $ile =  $uczen[5];
	  
	  
	  $klasa = $kl.' '.$sb;
	  $dane = $nazwisko.' '.$imie;
	  
	  if($ile > 1)
	  {
		  
		if($przedmioty == '')
		{
		   $przedmioty = $przedmiot;
		} else {
		  $przedmioty = $przedmioty.' | '.$przedmiot;
		}
		
		$next++;
		
	  	if($next == $ile)
		{
		  $tab_uczen[] = $klasa.'; '.$dane.'; '.$przedmioty.'; '.$ile;
		  $next=0;
		  $przedmioty='';
		}
		
	  } else {
		$przedmioty = ' '.$przedmiot;
		$tab_uczen[] = $klasa.'; '.$dane.'; '.$przedmioty.'; '.$ile;
		$przedmioty='';
	  }
  }

  if(isset($tab_uczen))
  foreach($tab_uczen as $uczen)
  {
	  $nr++;
	  $uczen = explode('; ', $uczen);
	  
	  echo'<tr>';
	  echo'<td>'.$nr.'</td>';
	  echo'<td>'.$uczen[0].'</td>';
	  echo'<td class="kto-co">'.$uczen[1].'</td>';
	  echo'<td>'.$uczen[3].'</td>';
	  echo'<td class="kto-co">'.$uczen[2].'</td>';
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
      <h3 id="nagRamka4">UCZNIOWIE NIEKLASYFIKOWANI</h3>
      <table id="zestawienie">
        <tr>
        <th class="nr">Nr</th>
        <th class="kl">Klasa</th>
        <th class="dane">Nazwisko i imię</th>
        <th class="nr">Ilość</th>
        <th>Przedmiot</th>
        </tr>
        <?php
		//$msc >= 9 || $msc == 1
		//$msc != 7 || $msc != 8
        if($msc < 6)
        {
          interfejsNkl('ocen_sem','N');
        } elseif ($msc > 5 && ($msc != 7 || $msc != 8)) {
          interfejsNkl('ocen_rok','N'); 
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