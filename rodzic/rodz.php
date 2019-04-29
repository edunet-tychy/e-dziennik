<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/jquery.tooltipster.min.js"></script>
<script type="text/javascript" src="javascript/script_01.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<link href="styl/tooltipster.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function()
{
  $('.tooltip').tooltipster();
});
</script>
</head>
<body>
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
include_once('../class/poczta_new.class.php');
include_once('../class/rodzice.class.php');
include_once('../class/dzieci.class.php');
include_once('../class/dane_ucznia.class.php');
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');
include_once('../class/kalendarz.class.php');
include_once('../class/sem.class.php');

//Zmienna
$kto=$_SESSION['zalogowany'];
$query = "SELECT id, nazwisko, imie, id_st FROM users WHERE login='$kto'";

//Obiekty
$wiadomosc = new news;
$baza = new zapytanie;
$baza->pytanie($query);

$id_db = $baza->tab[0];
$nazwisko_db = $baza->tab[1];
$imie_db = $baza->tab[2];
$rola_db = $baza->tab[3];

$bazaPoczta = new nowaPoczta;
$sem = new semestr;

//Zmienne sesyjne
$_SESSION['id_db'] = $id_db;
$_SESSION['nazwisko_db'] = $nazwisko_db;
$_SESSION['imie_db'] = $imie_db;
$_SESSION['rola_db'] = $rola_db;

//Ustawienie zmiennej ID
$id = $_SESSION['id_db'];

//Funkcja - View: potomek
function int_potomek($id)
{
  $nr = 0;

  $bazaDzieci = new dzieci;
  $potomek = $bazaDzieci->potomek($id);
  
  $bazaDaneUcznia = new daneUcznia;
  
  echo '<ul class="nawigacja_new">';
	foreach($potomek as $dziecko)
	{
	 $nr++;
	 $dane = $bazaDaneUcznia->dane($dziecko);
	 
	 if ($nr == 1)
	 {
	  echo '<li><a href="#" title="uczen" class="zaj aktywna" id="'.$dziecko.'">'.$dane.'</a></li> ';		 
	 } else {
	  echo '<li><a href="#" title="uczen" class="zaj" id="'.$dziecko.'">'.$dane.'</a></li> ';	 
	 }
	   	
	}
  echo '</ul>';
}

function aktualnyKalendarz()
{
  $kal = new Kalendarz();
  
  $dzien = Kalendarz::dzien;	
  
  $miesiac  = $kal->getMsc();
  $dnia     = $kal->getDzien();
  $rok      = $kal->getRok();
  
  $czas     = $kal->getCzas();
  $nazwa    = $kal->getNazwa();
  $ile_dni  = $kal->getDni();
  $pierwszy = $kal->getPierwszy();
  
  $data = $rok.'-'.$miesiac.'-'.$ile_dni;  
  $dzien_tyg = date('N',strtotime($data));
  $dzien_tyg; 
  
  //Zmiana obowiązuje w sytuacji, gdy ostatni dzień miesiąca
  //przypada na sobotę
  
  if ($pierwszy == 0 && $dzien_tyg == 6 && $ile_dni == 28) {
	$pierwszy = 7;
  } elseif ($pierwszy == 0 && $dzien_tyg == 2 && $ile_dni == 31) {
	$pierwszy = 7;
  } elseif ($pierwszy == 0 && $dzien_tyg == 1 && $ile_dni == 30) {
	$pierwszy = 7; 
  }
  
  $link     = htmlspecialchars($_SERVER['PHP_SELF']);
  $wstecz   = strtotime('-1 month', $czas);
  $wprzod   = strtotime('+1 month', $czas);
  
  echo '<table class="kalendarz">';
  echo '<tr class="kalendarz">';
  echo '<th class="lk"><a class="kalendarz" href="'.$link.'?t='.$wstecz.'">o</a></th>';
  
  // Miesiąc i rok
  for ($i = 1; $i <= 12 ; $i++) { 
	if ('0'.$i == $miesiac) {
	  echo '<th class="kalendarz" colspan="5">'.$nazwa[$miesiac].' '.$rok.'</th>';
	  break;
	}
  }
  
  echo '<th class="lk"><a class="kalendarz" href="'.$link.'?t='.$wprzod.'">o</a></th>';
  echo '</tr>';
  echo '<tr class="kalendarz">
  <th class="kalendarz">Po</th>
  <th class="kalendarz">Wt</th>
  <th class="kalendarz">Śr</th>
  <th class="kalendarz">Czw</th>
  <th class="kalendarz">Pt</th>
  <th class="kalendarz">So</th>
  <th class="kalendarz">Nd</th></tr>';
  
  // Dni
  while ($dzien <= $ile_dni) {

	echo '<tr class="kalendarz">';
	  for ($i = 1; $i <= 7; $i++) {
	  
		if (($dzien == 1 && $i < $pierwszy) || ($dzien > $ile_dni)) {
		  if($i == 6 || $i == 7) {
			// Pusta kratka
			echo '<td class="sn">&nbsp</td>';
		  } else {
			// Pusta kratka
			echo '<td class="kalendarz">&nbsp</td>'; 
		  }
			continue;
		}
	
		if('0'.$dzien == $dnia) {
		  // Aktualny dzień
		  echo '<td class="ak">'.$dzien.'</td>';
		} else {
		  // Sobota i niedziela
		  if($i == 6 || $i == 7)
		  {
			echo '<td class="sn">'.$dzien.'</td>';
		  } else {
			echo '<td class="kalendarz">'.$dzien.'</td>';
		  }
		}

		$dzien++;
	  }
	
	echo '</tr>';
  }
  
  echo '</table>';
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
    <p class="panel">Witaj! <a href="poczta.php"><?php $bazaPoczta->poczta($id); ?></a></p>
    <div class="linia"></div>
    <?php int_potomek($id); ?>
    <ul class="nawigacja">
    </ul>
    <div id="datownik"><?php aktualnyKalendarz(); ?></div>
      <div id="panel-n">
        <div class="linka">
        <div class="icona"><a class="ocena" href="<?php echo $sem->getSem(); ?>"><img class="tooltip" src="image/icony/calendar.png" alt="Oceny klasy" title="Zobacz oceny"></a></div>
        <div class="info"><a class="ocena" href="<?php echo $sem->getSem(); ?>">OCENY</a></div>
        </div>
  
        <div class="linka">
        <div class="icona"><a class="obecnosc" href="obecnosc.php"><img class="tooltip" src="image/icony/file_edit.png" alt="Frekwencja" title="Zobacz frekwencję"></a></div>
        <div class="info"><a class="obecnosc" href="obecnosc.php">OBECNOŚĆ</a></div>
        </div>
  
        <div class="linka">
        <div class="icona"><a class="uwaga" href="uwagi.php"><img class="tooltip" src="image/icony/message.png" alt="Uwagi o uczniu" title="Zobacz uwagi"></a></div>
        <div class="info"><a class="uwaga" href="uwagi.php">UWAGI</a></div>
        </div>
              
        <div class="odstep"></div>
  
        <div class="linka">
        <div class="icona"><a class="podrecznik" href="podreczniki.php"><img class="tooltip" src="image/icony/document_add.png" alt="Podręcznik" title="Zobacz listę obowiązujących podręczników"></a></div>
        <div class="info"><a class="podrecznik" href="podreczniki.php">PODRĘCZNIKI</a></div>
        </div>
  
        <div class="linka">
        <div class="icona"><a class="plan"  href="plan_zajec.php"><img class="tooltip" src="image/icony/clock.png" alt="Plan zajęć" title="Sprawdź plan zajęć"></a></div>
        <div class="info"><a class="plan"  href="plan_zajec.php">PLAN ZAJĘĆ</a></div>
        </div>

        <div class="linka">
        <div class="icona"><a class="nauczyciele"  href="nauczyciele.php"><img class="tooltip" src="image/icony/user_manage.png" alt="Nauczyciele" title="Sprawdź, kto uczy w klasie"></a></div>
        <div class="info"><a class="nauczyciele"  href="nauczyciele.php">NAUCZYCIELE</a></div>
        </div>

        <div class="odstep"></div>
    </div>
    <div class="linia"></div>
      <div id="panel"">

        <div class="linka">
        <div class="icona"><a href="poczta.php"><img class="tooltip" src="image/icony/mail_write.png" alt="Poczta" title="Napisz list. Odczytaj pocztę"></a></div>
        <div class="info"><a href="poczta.php">POCZTA</a></div>
        </div>
          
        <div class="linka">
        <div class="icona"><a href="konto.php"><img class="tooltip" src="image/icony/user.png" alt="Moje konto" title="Sprawdź swoje ostatnie logowanie"></a></div>
        <div class="info"><a href="konto.php">MOJE KONTO</a></div>
        </div>
  
        <div class="linka">
        <div class="icona"><a href="usr_pass.php"><img class="tooltip" src="image/icony/security_lock.png" alt="Zmień hasło" title="Zmień hasło"></a></div>
        <div class="info"><a href="usr_pass.php">ZMIEŃ HASŁO</a></div>
        </div>
  
        <div class="odstep"></div>
      </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>
