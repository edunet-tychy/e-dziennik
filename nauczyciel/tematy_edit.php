<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_edit_tem.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function()
{
 id_przed = $(".min-9").val();
 if(id_przed != "x")
 {
   var adr = "tematy_wyb.php?id_przed=";
   adr += id_przed;
   adr += $(".adres").attr("id").valueOf();

   var url = "tematy_pok.php?";
   url += $(".adres").attr("id").valueOf() + "&id_przed=" + id_przed;
   
	$.get(adr,function(data)
	{
	  $("#view").show();
	  $("#zestaw").html(data);
	});
 }
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
include_once('../class/tematy_edycja.class.php');
include_once('../class/news.class.php');

//Zmienne
$kto=$_SESSION['zalogowany'];
$id = $_SESSION['id_db'];
$nazwisko = $_SESSION['nazwisko_db'];
$imie = $_SESSION['imie_db'];
$rola = $_SESSION['rola_db'];
$klasa = $_SESSION['klasa'];
$sb = $_SESSION['sb'];

$id_kl = $_GET['id_kl'];
$id_przed = $_GET['id_przed'];
$id_tem = $_GET['id_tem'];
$godz = $_GET['godz']; 

$nr=0;

//Obiekty
$wiadomosc = new news;
$bazaDzien = new tematyDzien;
$bazaTemat = new tematEdycja;

//Funkcja - View: Godziny
function tabGodz($godz,$mysqli)
{
  $bazaGodziny = new tematyGodziny;
  $zestaw = $bazaGodziny->godziny($mysqli);
  $nr = 0;
  
  foreach($zestaw as $dane)
  {
	$dane = explode(';', $dane);
	$nr++;
	if($godz == $dane[0])
	{
	  echo'<option value="'.$dane[0].'" selected>'.$dane[0].' | '.$dane[1].' - '.$dane[2].'</option>';
	}
  }
}

//Funkcja - View: Nazwa przedmiotu
function inNazPrzed($id,$id_kl,$id_przed,$mysqli)
{
  $bazaTematyNazwaPrzed = new tematyNazwaPrzedmiotu;
  $przedmiot = $bazaTematyNazwaPrzed->nazwaPrzed($id,$id_kl,$mysqli);
  
  foreach($przedmiot as $dane)
  {
	$dane = explode(';', $dane);
	if($id_przed == $dane[0])
	{
	  echo'<option value="'.$dane[0].'" selected>'.$dane[1].'</option>';
	}
  }
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

?>
<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie,' ',$nazwisko,' - ', $_SESSION['kto'] ?></p>
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
  <li><a href="tematy.php?id_kl=<?php echo $id_kl.'&id_przed='.$id_przed; ?>" title="obecnosc" class="zaj">Obecność</a></li>
  <li><a href="" title="temat" class="zaj aktywna">Edycja tematu</a></li>
  </ul>
    <div id="obecnosc" class="zawartosc">
    <h3 id="nagRamka1">EDYCJA TEMATU - KLASA <?php echo $klasa. ' '. $sb ?></h3>
    <p class="center-4">Dzisiaj jest <?php echo $bazaDzien->dzien() .', '. data(); ?> roku. Godz.: <?php echo godz(); ?>.</p>
    <form action="tematy_upd.php?id_tem=<?php echo $id_tem; ?>" method="post" name="tem_pop" id="tem_pop">
      <table id="center-tabela-pod-3">
      <tr><td class="dane-3" colspan="2">Godzina lekcyjna:*</td></tr>
      <tr><td class="dane-3" colspan="2">
        <select class="min-7" name="godz">
          <?php tabGodz($godz,$mysqli); ?>
        </select>
      </td></tr>
      <tr><td class="dane-3" colspan="2">Nauczany przedmiot:*</td></tr>
      <tr><td class="dane-3" colspan="2">
      <div class="adres" id="<?php echo '&id_kl='.$id_kl.'&id='.$id.'&msc='.msc().'&tem='.$bazaTemat->temat($id_tem,$mysqli);?>"></div>
        <select class="min-9" name="id_przed">
          <?php inNazPrzed($id,$id_kl,$id_przed,$mysqli); ?>
        </select>
      </td></tr>
      <tr><td class="dane-3" colspan="2"><div id="view">Temat zajęć:*</div></td></tr>
      <tr><td class="dane-3" colspan="2">
      <div id="zestaw"></div>
      </td></tr>
      <tr>
        <td colspan="2" class="center-3"><input type="button" value="Zmień temat" class="button" id="zmien-tem"></td>
      </tr>
      </table>
    </form>
    <div id="user"></div>
    </div><br><br>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>