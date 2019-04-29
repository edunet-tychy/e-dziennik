<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_01a.js"></script>
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
include_once('../class/uczen_obecnosc.class.php');
include_once('../class/news.class.php');

//Zmienne
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];

//Zmienna identyfikująca ucznia
$id = $_GET['id_ucz'];
$_SESSION['id']=$id;

//Miesiac
$msc= date("n");

//Obiekty
$wiadomosc = new news;
$baza = new zapytanie;

$query = "SELECT id_kl FROM uczen WHERE id_user='$id'";
$baza->pytanie($query);
$id_kl = $baza->tab[0];

$query = "SELECT klasa, sb FROM vklasy WHERE id_kl='$id_kl'";
$baza->pytanie($query);
$klasa = $baza->tab[0];
$sb = $baza->tab[1];

//Imię i nazwisko ucznia
$query = "SELECT imie, nazwisko FROM users WHERE id='$id'";
$baza->pytanie($query);
$imieU = $baza->tab[0];
$nazwiskoU = $baza->tab[1];

//Funkcja - View - Nieobecność w danym dniu
function pokaz($tabs,$data,$u,$n,$s)
{
  $bazaTablicaUzup = new tablicaObecnosc;
  $bazaDniTygodnia = new dniTygodnia;

  $tb = $bazaTablicaUzup->uzup_tab($tabs);
  $suma = $u + $n;
  $day = date("l",strtotime($data));
  $dzien = $bazaDniTygodnia->dni_tyg($day);
  echo'<tr>';		  
  echo'<td title="'.$dzien.'" id="dzien"> '.$data.'</td>';
  for($j=0; $j<11; $j++)
  {
	  echo'<td>'.$tb[$j].'</td>';
  }
  echo'<td>'.$n.'</td>';
  echo'<td>'.$u.'</td>';
  echo'<td>'.$suma.'</td>';
  echo'<td>'.$s.'</td>';
  echo'</tr>';	
}

//Funkcja - View lista rozwijana
function opcja()
{
  $bazaMiesiace = new miesiace;
  
  for($i=0; $i <= 12; $i++)
  {
	if($i != 0 && $i != 7 && $i != 8)
	echo '<option value="'.$i.'">'.$bazaMiesiace->msc($i).'</option>';	
  }
}

//Funkcja - View: Zliczenie nieobecności 1
function in_zlicz_sem_1($id_kl,$id)
{
	$bazaMiesiace = new miesiace;
	$bazaZliczanie = new zliczanie;

	$ogolem_1=0;
	$uspraw_1=0;
	$nieusp_1=0;
	$spozn_1=0;
	
	for($i=9; $i<=12; $i++)
	{
	  $suma = $bazaZliczanie->suma($i,$id_kl,$id);
	  $dane = explode('; ', $suma);
	  echo'<tr><td class="lewy">'.$bazaMiesiace->msc($i).'</td>';
	  echo'<td>'.$dane[0].'</td>';
	  echo'<td>'.$dane[1].'</td>';
	  echo'<td>'.$dane[2].'</td>';
	  echo'<td>'.$dane[3].'</td></tr>';
	  
	  $ogolem_1 += $dane[0];
	  $uspraw_1 += $dane[1];
	  $nieusp_1 += $dane[2];
	  $spozn_1 += $dane[3];
	}
	//Styczeń
	  $suma = $bazaZliczanie->suma(1,$id_kl,$id);
	  $dane = explode('; ', $suma);
	  echo'<tr><td class="lewy">'.$bazaMiesiace->msc(1).'</td>';
	  echo'<td>'.$dane[0].'</td>';
	  echo'<td>'.$dane[1].'</td>';
	  echo'<td>'.$dane[2].'</td>';
	  echo'<td>'.$dane[3].'</td></tr>';

	  $ogolem_1 += $dane[0];
	  $uspraw_1 += $dane[1];
	  $nieusp_1 += $dane[2];
	  $spozn_1 += $dane[3];
	  
	  echo'<tr><th class="lewy">Razem w semestrze I</td>';
	  echo'<th>'.$ogolem_1.'</th>';
	  echo'<th>'.$uspraw_1.'</th>';
	  echo'<th>'.$nieusp_1.'</th>';
	  echo'<th>'.$spozn_1.'</th></tr>';
	  
	  $sem_1 = $ogolem_1.'; '.$uspraw_1.'; '.$nieusp_1.'; '.$spozn_1;
	  return $sem_1;
}

//Funkcja - View: Zliczenie nieobecności 2
function in_zlicz_sem_2($id_kl,$id)
{
	$bazaMiesiace = new miesiace;
	$bazaZliczanie = new zliczanie;
		
	$ogolem_2=0;
	$uspraw_2=0;
	$nieusp_2=0;
	$spozn_2=0;
	
	for($i=2; $i<=6; $i++)
	{
	  $suma = $bazaZliczanie->suma($i,$id_kl,$id);
	  $dane = explode('; ', $suma);
	  echo'<tr><td class="lewy">'.$bazaMiesiace->msc($i).'</td>';
	  echo'<td>'.$dane[0].'</td>';
	  echo'<td>'.$dane[1].'</td>';
	  echo'<td>'.$dane[2].'</td>';
	  echo'<td>'.$dane[3].'</td></tr>';

	  $ogolem_2 += $dane[0];
	  $uspraw_2 += $dane[1];
	  $nieusp_2 += $dane[2];
	  $spozn_2 += $dane[3];	
	}

	  echo'<tr><th class="lewy">Razem w semestrze II</td>';
	  echo'<th>'.$ogolem_2.'</th>';
	  echo'<th>'.$uspraw_2.'</th>';
	  echo'<th>'.$nieusp_2.'</th>';
	  echo'<th>'.$spozn_2.'</th></tr>';
	  
	  $sem_2 = $ogolem_2.'; '.$uspraw_2.'; '.$nieusp_2.'; '.$spozn_2;
	  return $sem_2;
}
//Funkcja - View: Zliczenie frekwencji rocznej
function rok($sem_1,$sem_2)
{
  $dane_1 = explode('; ', $sem_1);
  $dane_2 = explode('; ', $sem_2);
  
  $ogolem = $dane_1[0] + $dane_2[0];
  $uspraw = $dane_1[1] + $dane_2[1];
  $nieusp = $dane_1[2] + $dane_2[2];
  $spozn = $dane_1[3] + $dane_2[3];
  
  echo'<tr><th class="lewy">Ogółem w roku szkol.</td>';
  echo'<th>'.$ogolem.'</th>';
  echo'<th>'.$uspraw.'</th>';
  echo'<th>'.$nieusp.'</th>';
  echo'<th>'.$spozn.'</th></tr>';
  
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
    <?php include_once('menu.php'); ?>
    </div>   
    <div id="czescGlowna">
    <?php	
	echo '<h3 id="nagRamka4">NIEOBECNOŚCI I SPÓŹNIENIA</h3>';
	 echo'<ul class="nawigacja">';
	 echo'<li><a href="#" title="uczen" class="ucz aktywna">'.$imieU.' '.$nazwiskoU.'</a></li>';
	 echo'</ul>';
	echo '<div class="lewy-2" id="'.$msc.'">';
	echo '<select class="min-7a" name="miesiac">';
	  echo '<option value="'.$msc.'">Miesiąc bieżący</option>';
	  echo '<option value="0">---</option>';
	  echo opcja();
	  echo '</select>';
	echo '</div>';
    ?>
	<div id="user"></div>
    <?php
	echo '<h3 id="nagRamka4">ZESTAWIENIE SEMESTRALNE/ROCZNE</h3>';
	echo'<table id="plan-ob">';
	echo'<tr>';
	echo'<th rowspan="2" class="opis-3">Miesiąc</th>';
	echo'<th colspan="3">Nieobecności</th>';
	echo'<th rowspan="2">Spóźnienia</th>';
	echo'</tr>';
	echo'<tr>';
	echo'<th class="opis-2">Ogółem</th>';
	echo'<th class="opis-2">Usprawiedliwione</th>';
	echo'<th class="opis-2">Nieusprawiedliwione</th>';
	echo'</tr>';
	$sem_1 = in_zlicz_sem_1($id_kl,$id);
	$sem_2 = in_zlicz_sem_2($id_kl,$id);
	rok($sem_1,$sem_2);
	echo'</table><br><br>';
	?>
    </div>
	<div id="stopka">
	<p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
	</div>
</div>
</body>
</html>