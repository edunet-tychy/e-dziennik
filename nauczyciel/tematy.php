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
<script type="text/javascript" src="javascript/script_tem.js"></script>
<script type="text/javascript" src="javascript/jquery-1.js"></script>
<script type="text/javascript" src="javascript/jquery-ui-1.js"></script>
<link href="styl/jquery-ui-1.css" rel="stylesheet" type="text/css">
<link href="styl/tooltipster.css" rel="stylesheet" type="text/css">
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function()
{
  $('.tooltip').tooltipster();
  $(".min-7").change(function()
  {
	var lek = $(this).val();
	var kl = $("#klasa").val();
	var data = $("#wybData").val();
	var link = "tematy.php?lek=" + lek + "&id_kl=" + kl + "&data=" + data ;
	$(location).attr('href',link);
  });
  
});
</script>
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
include_once('../class/tematy_users.class.php');
include_once('../class/tematy_godziny.class.php');
include_once('../class/tematy_dzien.class.php');
include_once('../class/tematy_naucz_przed.class.php');
include_once('../class/tematy_klas_przed.class.php');
include_once('../class/tematy_id_przed.class.php');
include_once('../class/tematy_nazwa_przed.class.php');
include_once('../class/news.class.php');

if(!isset($_GET['lek'])) {$lek=0;} else { $lek = $_GET['lek']; }
if(!isset($_GET['data'])) {$dt=dt();} else { $dt = $_GET['data']; }

//Zmienne
$kto=$_SESSION['zalogowany'];
$id = $_SESSION['id_db'];
$nazwisko = $_SESSION['nazwisko_db'];
$imie = $_SESSION['imie_db'];
$rola = $_SESSION['rola_db'];
$id_kl = $_GET['id_kl'];
$nr=0;

//Obiekty
$wiadomosc = new news;
$baza = new zapytanie;
$kl = "SELECT klasa, sb FROM vklasy WHERE id_kl='$id_kl'";
$baza->pytanie($kl);
$klasa = $baza->tab[0];
$sb = $baza->tab[1];

//Ustawienie zmiennych sesyjnych
$_SESSION['klasa'] = $klasa;
$_SESSION['sb'] = $sb;

$bazaDzien = new tematyDzien;

//Funkcja - View: Uczniowie
function lista($id_kl,$mysqli,$dt,$lek)
{
  $bazaUsers = new tematUsers;
  $bazaZapytanie = new zapytanie;
  
  $zestaw = $bazaUsers->uczniowie($id_kl,$mysqli);
  if(isset($zestaw))
  {
	$nr = 0;
	$ile = count($zestaw);
	sort($zestaw);
	
	echo'<input type="hidden" name="ile" value="'.$ile.'">';
	foreach($zestaw as $dane)
	{
	  $dane = explode('; ', $dane);
	  $nr++;
	  
	  // Polskie znaki - zmiana
	  $search = array('Szz','Lzz','Nzz');
	  $replace = array('Ś','Ł','Ź');
	  $dane[0] = str_replace($search, $replace, $dane[0]);
	  
	  echo'<input type="hidden" name="id_ucz'.$nr.'" value="'.$dane[2].'">';
	  echo'<tr><td>'.$nr.'</td>';
	  echo'<td class="ucz">'.$dane[0].' '.$dane[1].'</td>';
	  echo'<td><input class="opcja1" type="radio" name="ucz_'.$nr.'" value="o"></td>';
	  echo'<td><input class="opcja2" type="radio" name="ucz_'.$nr.'" value="n"></td>';
	  echo'<td><input class="opcja3" type="radio" name="ucz_'.$nr.'" value="s"></td>';
	  
	  $query = "SELECT stan FROM frekwencja WHERE data='$dt' AND godzina='$lek' AND id_ucz='$dane[2]' AND id_kl='$id_kl'";
	  $bazaZapytanie->pytanie($query);
	  $stan = $bazaZapytanie->tab[0];

	  switch ($stan) {
		  case 'o': echo'<td><img src="image/ob.png" alt="nb"></td>'; break;
		  case 'n': echo'<td><img src="image/nb.png" alt="nb"></td>'; break;
		  case 'u': echo'<td><img src="image/nb.png" alt="nb"></td>'; break;
		  case 's': echo'<td><img src="image/sp.png" alt="nb"></td>'; break;
		  default : echo'<td><img src="image/br.png" alt="br"></td>'; break;
	  }
	  
	  echo'</tr>';		 
	} 
  }
}

//Funkcja - View: Godziny
function tabGodz($mysqli,$lek)
{
  $bazaGodziny = new tematyGodziny;
  $zestaw =  $bazaGodziny->godziny($mysqli);
  $nr = 0;
  
  echo'<option value="x" selected>...</option>';
  
  foreach($zestaw as $dane)
  {
	$dane = explode(';', $dane);
	$nr++;
	if($dane[0] == $lek)
	{
		echo'<option value="'.$dane[0].'" selected>'.$dane[0].' | '.$dane[1].' - '.$dane[2].'</option>';
	} else {
		echo'<option value="'.$dane[0].'">'.$dane[0].' | '.$dane[1].' - '.$dane[2].'</option>';	 		
	}

  }
}

//Funkcja - View: Nazwa przedmiotu
function inNazPrzed($id,$id_kl,$mysqli)
{
  $bazaTematyNazwaPrzed = new tematyNazwaPrzedmiotu;
  $przedmiot = $bazaTematyNazwaPrzed->nazwaPrzed($id,$id_kl,$mysqli);
  
  foreach($przedmiot as $dane)
  {
	$dane = explode(';', $dane);
	echo'<option value="'.$dane[0].'">'.$dane[1].'</option>';		 
  }
}

//Funkcja - Miesiąc
function msc()
{
  $miesiac = date("m");
  switch($miesiac)
  {
	case "09" : $miesiac = '1'; break;
	case "10" : $miesiac = '2'; break;
	case "11" : $miesiac = '3'; break;
	case "12" : $miesiac = '4'; break;
	case "01" : $miesiac = '5'; break;
	case "02" : $miesiac = '6'; break;
	case "03" : $miesiac = '7'; break;
	case "04" : $miesiac = '8'; break;
	case "05" : $miesiac = '9'; break;
	case "06" : $miesiac = '10'; break;
  }
  return $miesiac;	
}

//Funkcja - Bieżąca data
function dt()
{
  $data = date("Y-m-d");
  return $data;
}

//Funkcja - Data
function data()
{
  return $data = date("d.m.y");
}

//Funkcja - Godzina
function godz()
{
 return date("G:i");
}

//Funkcja - Godz
function nrLekcji()
{
  $h = date("G");
  $m = date("i");

  if(($h == 7 && $m >= 10) || ($h == 7 && $m <= 55))
  {
	$lk = "Lekcja 0.";
  }elseif(($h == 8 && $m >= 00) || ($h == 8 && $m <= 45))
  {
	$lk = "Lekcja 1.";
  }elseif(($h == 8 && $m >= 55) || ($h == 9 && $m <= 40))
  {
	$lk = "Lekcja 2.";
  }elseif(($h == 9 && $m >= 50) || ($h == 10 && $m <= 35))
  {
	$lk = "Lekcja 3.";
  }elseif(($h == 10 && $m >= 45) || ($h == 11 && $m <= 30))
  {
	$lk = "Lekcja 4.";  
  }elseif(($h == 11 && $m >= 40) || ($h == 12 && $m <= 25))
  {
	$lk = "Lekcja 5.";
  }elseif(($h == 12 && $m >= 40) || ($h == 13 && $m <= 25))
  {
	$lk = "Lekcja 6.";	  
  }elseif(($h == 13 && $m >= 35) || ($h == 14 && $m <= 20))
  {
	$lk = "Lekcja 7."; 
  }elseif(($h == 14 && $m >= 25) || ($h == 15 && $m <= 10))
  {
	$lk = "Lekcja 8.";
  }elseif(($h == 15 && $m >= 15) || ($h == 16 && $m == 0))
  {
	$lk = "Lekcja 9.";
  } else {
	$lk = "";
  }
  return $lk;
}

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
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie,' ',$nazwisko,' - '. iden($kto); ?></p>
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
  <li><a href="#poz" title="obecnosc" class="zaj aktywna">Obecność</a></li>
  <li><a href="#poz" title="temat" class="zaj">Temat</a></li> 
  </ul>
    <div id="obecnosc" class="zawartosc">
    <h3 id="nagRamka1">OBECNOŚĆ - KLASA <?php echo $klasa. ' '. $sb;?><div id="time"><?php echo $bazaDzien->dzien().', '.data().' roku. Godz.: '.godz().'. '. nrLekcji(); ?></div></h3>
    <form action="obecnosc_dod.php?dt=<?php echo dt().'&id_kl='.$id_kl; ?>" method="post" name="form" id="form">
    <input type="hidden" name="klasa" id="klasa" value="<?php echo $id_kl ;?>">
    <p class="center-4">Wybierz inną datę: <input type="text" id="wybData" size="10" class="pole-center" name="wybData" value="<?php echo $dt; ?> "></p>
     <p class="center-4">Lekcja:
       <select class="min-7" name="lek">
         <?php tabGodz($mysqli,$lek); ?>
       </select>
     </p>
      <table id="plan-ob">
      <tr>
      <th id="lp">LP</th>
      <th id="dane">Nazwisko i imie</th>
        <th><a class="tooltip" href="#poz" id="ob" title="Obecność - zaznacz całą klasę">Ob.</a></th>
        <th><a class="tooltip" href="#poz" id="nb" title="Nieobecność - zaznacz całą klasę">Nb.</a></th>
        <th><a class="tooltip" href="#poz" id="sp" title="Spóźnienie - zaznacz całą klasę">Sp.</a></th>
        <th>Stan</th>
      </tr>
        <?php lista($id_kl,$mysqli,$dt,$lek); ?>
      <tr>
        <th class="opis"></th>
        <th class="opis"></th>
        <th class="opis"></th>
        <th class="opis"></th>
        <th class="opis"></th>
        <th class="opis"></th>
      </tr>       
      </table>
      <p class="center-3"><input type="button" value="Zapisz obecność" class="button" id="zapis-ob"></p>
    </form>
    </div>
    <div id="temat" class="zawartosc">
    <h3 id="nagRamka1">TEMAT - KLASA <?php echo $klasa. ' '. $sb ?></h3>
    <p class="center-4"><?php echo $bazaDzien->dzien() .', '. data(); ?> roku. Godz.: <?php echo godz().'. '. nrLekcji(); ?></p>
    <form action="tematy_dod.php?dt=<?php echo $dt; ?>" method="post" name="tem_zaj" id="tem_zaj">
      <table id="center-tabela-pod-3">
      <tr><td class="dane-3" colspan="2">Godzina lekcyjna:*</td></tr>
      <tr><td class="dane-3" colspan="2">
        <select class="min-7a" name="godz">
          <?php tabGodz($mysqli,$lek); ?>
        </select>
      </td></tr>
      <tr><td class="dane-3" colspan="2">Nauczany przedmiot:*</td></tr>
      <tr><td class="dane-3" colspan="2">
      <div class="adres" id="<?php echo '&id_kl='.$id_kl.'&id='.$id.'&msc='.msc(); ?>"></div>
        <select class="min-8" name="id_przed">
          <?php inNazPrzed($id,$id_kl,$mysqli); ?>
        </select>
      </td></tr>
      <tr><td class="dane-3" colspan="2"><div id="view">Temat zajęć:*</div></td></tr>
      <tr><td class="dane-3" colspan="2">
      <div id="zestaw"></div>
      </td></tr>
      <tr>
        <td colspan="2" class="center-3"><input type="button" value="Zapisz temat" class="button" id="zapis-tem"></td>
      </tr>
      </table>
    </form>
    <div id="user"></div>
    </div><br/><br/>
    <!-- Informacje dla użytkownika -->
    <div class="left-2">
      <h2 class="frek">ZADANIE FORMULARZA:</h2>
      <p class="frek">Formularz zezwala nauczycielowi na wprowadzenie tematu zajęć oraz sprawdzenie obecności.</p>
      <h2 class="frek">UDOGODNIENIA:</h2>
      <p class="frek">Znaczenie symboli:</p>
      <ul class="frek">
      <li>Ob. - zaznacza cała klasę jako obecną,</li>
      <li>Nb. - zaznacza całą klasę jako nieobecną,</li>
      <li>Sp. - zaznacza całą klasę jako spóźnioną.</li>
      </ul>
      <br><br>
    </div>
  </div>
  
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>