<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
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
include_once('../class/przedmioty.class.php');
include_once('../class/oceny_czastkowe.class.php');
include_once('../class/oceny_semestralne.class.php');
include_once('../class/news.class.php');

//Zmienne
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];

//Zmienna identyfikująca ucznia
$id = $_GET['id_ucz'];

//Obiekty
$baza = new zapytanie;
$wiadomosc = new news;

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

//Funkcja - View Przedmioty i oceny
function int_przed($id_kl,$id)
{
  global $mysqli;
  
  $bazaNazwaPrzedmiotu = new nazwaPrzedmiot;
  $bazaOceny = new ocenyCzastkoweSem;
  $bazaOpisOcenyCzastkowej = new opisOcenyCzastkowej;
  $bazaPropozycjaOcenySem = new propOcenySemestr;
  $bazOcenaSemestr = new ocenaSemestr;
  
  $przedmioty = $bazaNazwaPrzedmiotu->naz_przedmiot($id_kl);
  $nr = 0;

  //Przedmioty  
  foreach($przedmioty as $dane)
  {
	$dane = explode('; ', $dane);
	$nr++;
	echo'<tr>';
	echo'<td class="nr">'. $nr .'</td>';
	echo'<td>'. $dane[0] .'</td>';

	//Oceny	cząstkowe
	$oceny = $bazaOceny->oceny($id,$dane[1],$id_kl);
	$opisy = $bazaOpisOcenyCzastkowej->opis_oc($dane[1],$id_kl);
	
	echo'<td class="oceny">';
	if(isset($oceny))
	{
	  foreach($oceny as $ocena)
	  {
		$info='Brak opisu';
		$oc = explode('; ', $ocena);
		
		if (isset($opisy)) {
		  foreach($opisy as $opis)
		  {
			$wynik = explode('; ', $opis);
			$poz = $id.'-'.$wynik[0];
			
			if($oc[0] == $poz)
			{
			  $info = $wynik[1];
			}
		  }
		}
		
		echo'<a class="linki-3" href="#" title="Data wpisu: '.$oc[2].'&#10;Opis oceny: '.$info.'">'.$oc[1].'</a> ';
	  }		
	} else {
		echo '---';
	}
	echo'</td>';

	//Propozycja oceny semestralnej		
	echo'<td class="sem">';
	$prop = $bazaPropozycjaOcenySem->prop_sem($id,$dane[1],$id_kl);
	if(isset($prop))
	{
	  $pr = explode('; ', $prop);
	  echo '<a class="linki-3" href="#" title="Data wpisu: '.$pr[1].'">'.$pr[0].'</a>';
	} else {
	  echo'---';
	}
	echo'</td>';

	//Ocena semestralna	
	echo'<td class="sem">';
	$sem = $bazOcenaSemestr->sem($id,$dane[1],$id_kl);
	if(isset($prop))
	{
	  $sm = explode('; ', $sem);
	  echo '<a class="linki-3" href="#" title="Data wpisu: '.$sm[1].'">'.$sm[0].'</a>';
	} else {
	  echo'---';
	}
	echo'</td>';
  }
}

//Funkcja - View: Tabela
function tabela($imieU,$nazwiskoU,$id_kl,$id)
{
  global $mysqli;
  
  echo'<h3 id="nagRamka1">OCENY - SEMESTR I</h3>';
  echo'<ul class="nawigacja">';
  echo'<li><a href="#" title="uczen" class="ucz aktywna">'.$imieU.' '.$nazwiskoU.'</a></li>';
  echo'</ul>';

  if($result = $mysqli->query("SELECT * FROM klasy WHERE id_kl='$id_kl'"))
  {
	if($result->num_rows > 0)
	{
	  $nr=0;
	  
	  echo'<table id="center-tabela-pod-2">';
	  echo'<tr>';
	  echo'<th>NR</th>';
	  echo'<th>PRZEDMIOT</th>';
	  echo'<th>OCENY</th>';
	  echo'<th>Prop.</th>';
	  echo'<th>Sem.</th>';
	  echo'</tr>';
	  int_przed($id_kl,$id);
	  echo'</table><br><br>';
	}else {
	  echo '<img src="image/pytanie.png" alt="Brak rekordów">';
	  echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
	}
  }else {
  echo 'Błąd: ' . $mysqli->error;
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
  <ul class="nawigacja_new">
  <li><a href="oceny.php?id_ucz=<?php echo $id ;?>" title="Oceny semestr I" class="zaj aktywna">Semestr I</a></li>
  <li><a href="oceny_k.php?id_ucz=<?php echo $id ;?>" title="Oceny semestr II" class="zaj">Semestr II</a></li>
  </ul>
   <?php tabela($imieU,$nazwiskoU,$id_kl,$id) ;?>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>