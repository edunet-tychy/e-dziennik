<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/jquery-1.js"></script>
<script type="text/javascript" src="javascript/jquery-ui-1.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<link href="styl/jquery-ui-1.css" rel="stylesheet" type="text/css">
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function($)
{
  $(".pole-center").datepicker({dateFormat: 'yy-mm-dd', firstDay: 1, dayNamesMin: ['Nd', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So'], monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień']});

//Dodanie wydarzenia	
  $("#dodajZebranie").click(function()
  {
	  var dane = $("form").serialize();
	  var url = $("form").attr("action");
	  var adr = 'db_kontakt_dane.php';
	  $.post(url, dane, function()
	  {
		$(location).attr('href',adr);
	  });

  });
});
</script>
</head>
<body>
<?php
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');
 
//Sprawdzenie nawiązania połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$id_kl = $_SESSION['id_kl'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$klasa = $_SESSION['klasa'];
$sb = $_SESSION['sb'];
$tab;
$ile;

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

function zapytanie($id_kl)
{
  global $mysqli;
  global $tab;
  if($result = $mysqli->query("SELECT id_user FROM uczen WHERE id_kl = '$id_kl'"))
  {	  
	if($result->num_rows > 0)
	{
		while($row=$result->fetch_object())
		{
		 $tab[] = $row->id_user;
		}
	}
  }
  return $tab;
}

function uczen($query)
{
 global $mysqli;
	if(!$result = $mysqli->query($query))
	{
	  echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	  $mysqli->close();
	}
	$row = $result->fetch_row();
	$tb[] = $row[0];
	$tb[] = $row[1];
 return $tb;
}
$ile=ile($id_kl);
function uczniowie($id_kl)
{
  global $ile;	
  $nr=0;  
  $kl = zapytanie($id_kl);

  for($i=0; $i<$ile; $i++)
  {
	$query = "SELECT imie, nazwisko FROM users WHERE id = '$kl[$i]'";
	$tb = uczen($query);
	$imie = $tb[0];
	$nazwisko =  $tb[1];
	$nr++;
	echo '<tr><td class="dane-4">'.$nr.'. '. $nazwisko .' '. $imie .'</td><td><select class="min-2" name="ob_'.$i.'"><option value="'.$kl[$i].'">Ob</option><option value="0">Nb</option></select></td></tr>';
  }
}

function ile($id_kl)
{
  $kl = zapytanie($id_kl);
  $ile = count($kl);
  return $ile;
}
?>

<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie_db,' ',$nazwisko_db,' - ', $kto,' klasy: ', $klasa,' ', $sb; ?></p>
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
    <ul class="nawigacja">
      <li><a href="db_kontakt_dane.php" title="lista" class="zakladki" id="z_01">KONTAKTY Z RODZICAMI</a></li>
      <li><a href="db_zebrania_form.php" title="dodaj" class="zakladki aktywna" id="z_02">DODAJ ZEBRANIE</a></li>
    </ul>
    <div id="lista" class="zawartosc">
      <h3 id="nagRamka1">DODAJ NOWE ZEBRANIE - KLASA <?php echo $klasa .' '. $sb; ?></h3>
      <form action="db_zebrania_dod.php" method="post" name="form" id="form">
      <input type="hidden" name="ile" id="ile" value="<?php echo $ile ?>">
        <table id="center-tabela-pod-3">
        <tr><td class="dane-3" colspan="2">Data:*</td></tr>
        <tr><td class="dane-3" colspan="2"><input type="text" id="data-left" size="30" class="pole-center" name="data"></td></tr>
        <tr><td class="dane-3" colspan="2">Treść spotkania:*</td></tr>
        <tr><td class="dane-3" colspan="2"><textarea name="tresc" rows="2" cols="60"></textarea></td></tr>
        <tr><td class="dane-3" colspan="2">Rodzice/Opiekunowie uczniów:*</td></tr>
        <tr><td class="dane-3" colspan="2"></td></tr>
        <?php uczniowie($id_kl);?>
        <tr>
          <td colspan="3" class="center-3"><input type="button" value="Dodaj informację" class="button" id="dodajZebranie"></td>
        </tr>
        </table>
      </form>
    </div><br><br>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>