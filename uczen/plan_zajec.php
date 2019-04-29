<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_05.js"></script>
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
include_once('../class/przedmioty_klasy.class.php');
include_once('../class/plan_uczen.class.php');
include_once('../class/news.class.php');

//Zmienne
$id = $_SESSION['id_db'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$ile = 0;
if(!isset($_GET['gr'])) {$gr=1;} else {$gr=$_GET['gr'];}

//Obekty
$wiadomosc = new news;
$baza = new zapytanie;
$query = "SELECT id_kl FROM uczen WHERE id_user='$id'";
$baza->pytanie($query);
$id_kl = $baza->tab[0];

$query = "SELECT klasa, sb FROM vklasy WHERE id_kl='$id_kl'";
$baza->pytanie($query);
$klasa = $baza->tab[0];
$sb = $baza->tab[1];

//Funcja - View: Szkielet tabeli
function szkielet($gr)
{
  global $ile;
  global $mysqli;
  
  $bazaPrzedmioty = new przedmiotyKlasy;
  $bazaPlanUcznia = new planUcznia;
  
  $plan_z = $bazaPlanUcznia->plan($gr);
  
  if($result = $mysqli->query("SELECT nr, pocz, kon FROM godziny WHERE pocz != ''"))
  {	  
	if($result->num_rows > 0)
	{
		while($row=$result->fetch_object())
		{
		  echo '<tr><th class="ng">'.$row->nr.'</th><td class="godz">'. $row->pocz .'-'. $row->kon .'</td>';
		  for($i=0; $i<5; $i++)
		  {
			echo '<td class="jeden">';
			
			for($j=0; $j<$ile; $j++)
			{
			  $id_pl = $plan_z[0][$j];
			  $dzien = $plan_z[1][$j];
			  $godz = $plan_z[2][$j];
			  $przed = $plan_z[3][$j];
			  $gr = $plan_z[4][$j];
			  
			  if($dzien == $i && $godz == $row->nr && $gr == 1)
			  {
			   $bazaPrzedmioty->przedmiot($przed);
			  } elseif($dzien == $i && $godz == $row->nr && $gr == 2)
			  {
				$bazaPrzedmioty->przedmiot($przed);
			  }
			}
			echo '</td>';
		  }
		  echo '</tr>';
		}
	}
  }	
}

//Funkcja - View: Zakładki
function zakladki($gr)
{
   if($gr == 1)
   {
	  echo'<li><a href="plan_zajec.php?gr=1" title="Grupa I" class="zaj aktywna">Grupa I</a></li> ';
	  echo'<li><a href="plan_zajec.php?gr=2" title="Grupa II" class="zaj">Grupa II</a></li> ';
   } elseif($gr == 2)
   {
	  echo'<li><a href="plan_zajec.php?gr=1" title="Grupa I" class="zaj">Grupa I</a></li> ';
	  echo'<li><a href="plan_zajec.php?gr=2" title="Grupa II" class="zaj aktywna">Grupa II</a></li> ';
   }
}

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
  <h3 id="nagRamka">PLAN ZAJĘĆ KLASY <?php echo $klasa. ' '. $sb?></h3>
  <ul class="nawigacja_plan">
	<?php zakladki($gr); ?>
  </ul>
    <table id="plan">
      <tr>
        <th colspan="2">LEKCJA</th>
        <th>PONIEDZIAŁEK</th>
        <th>WTOREK</th>
        <th>ŚRODA</th>
        <th>CZWARTEK</th>
        <th>PIĄTEK</th>
      </tr>
      <?php szkielet($gr); ?>
    </table>
  <br><br>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>