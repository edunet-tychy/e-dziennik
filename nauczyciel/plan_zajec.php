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
<script type="text/javascript" src="javascript/script_zaj.js"></script>
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
include_once('../class/plan_kl.class.php');
include_once('../class/plan_przed.class.php');
include_once('../class/plan_nauczyciele.class.php');
include_once('../class/plan_przedmioty_kl.class.php');
include_once('../class/plan_zajecia.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

//Zmienne
$kto=$_SESSION['zalogowany'];
$id = $_SESSION['id_db'];
$nazwisko = $_SESSION['nazwisko_db'];
$imie = $_SESSION['imie_db'];
$rola = $_SESSION['rola_db'];

//Funkcja - View: Plan lekcji
function szkielet($id,$mysqli)
{
  
  $bazaKl = new plan_kl;
  $bazaPrzed = new plan_przed;
  $bazaPlan = new plan_zajecia;
  
  $ile = 0;
  if($result = $mysqli->query("SELECT nr, pocz, kon FROM godziny WHERE pocz != ''"))
  {	  
	if($result->num_rows > 0)
	{
		while($row=$result->fetch_object())
		{
		  echo '<tr><th class="ng">'.$row->nr.'</th><td class="godz-2">'. $row->pocz .'-'. $row->kon .'</td>';
		  
		  for($i=0; $i<5; $i++)
		  {
			echo '<td>';
			
			$zestaw = $bazaPlan->plan_zajec($id,$mysqli);
			
			if(isset($zestaw))
			{
			  foreach($zestaw as $dane)
			  {
				$dane = explode('; ', $dane);
			
				$dzien = $dane[0];
				$nr_godz = $dane[1];
				$id_przed = $dane[2];
				$gr = $dane[3];
				$id_kl = $dane[4];
				
				if($row->nr == $nr_godz && $i == $dzien)
				{
					$ile++;
				}
			  }
			  
			  foreach($zestaw as $dane)
			  {
				$dane = explode('; ', $dane);
			
				$dzien = $dane[0];
				$nr_godz = $dane[1];
				$id_przed = $dane[2];
				$gr = $dane[3];
				$id_kl = $dane[4];
				
				if($row->nr == $nr_godz && $i == $dzien && $ile == 2)
				{
				  echo $bazaPrzed->przed($id_przed,$mysqli).' - '.$bazaKl->kl($id_kl,$mysqli).' (klasa)';
				  break;
				} elseif($row->nr == $nr_godz && $i == $dzien && $ile == 1) {
				  echo $bazaPrzed->przed($id_przed,$mysqli).' - '.$bazaKl->kl($id_kl,$mysqli).' gr. '.$gr;
				}
			  }
			  $ile=0;
			}

			echo '</td>';
		  }
		  echo '</tr>';
		}
	}
  }	
}

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

    <div id="lista" class="zawartosc">
    <h3 id="nagRamka">PLAN ZAJĘĆ</h3>
      <table id="plan">
        <tr>
          <th colspan="2">LEKCJA</th>
          <th>PONIEDZIAŁEK</th>
          <th>WTOREK</th>
          <th>ŚRODA</th>
          <th>CZWARTEK</th>
          <th>PIĄTEK</th>
        </tr>
        <?php szkielet($id,$mysqli); ?>
      </table>      
    </div>
    <div id="user"></div><br><br>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>