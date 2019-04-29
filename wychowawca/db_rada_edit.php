<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function()
{
	var url = 'db_rada_pok.php';
	$("#pokazRada").load(url);

//Poprawa danych samorządu
	$("#poprawRada").click(function()
	{
		var dane = $("form").serialize();
		var url = $("form").attr("action");
		var adr = 'db_rada_pok.php';
		$.post(url, dane, function()
		{  
			 $("#pokazRada").load(adr);
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

$id_rd=$_GET['id_rd'];

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

//Zapytanie o rodzica z Rady
$query = "SELECT id_rodz, plec FROM rada WHERE id_rd='$id_rd'";
$tb = zapytanie($query);
$id_rodz = $tb[0];
$plec = $tb[1];

if($plec == 'k')
{
  $query = "SELECT nazwisko, imieM FROM rodzic WHERE id_rodz='$id_rodz'";
  $tb = zapytanie($query);
  $nazwisko = $tb[0];
  $imie = $tb[1];
} else {
  $query = "SELECT nazwisko, imieO FROM rodzic WHERE id_rodz='$id_rodz'";
  $tb = zapytanie($query);
  $nazwisko = $tb[0];
  $imie = $tb[1];
}

//Funkcja Zapytanie
function zapytanie($query)
{
  global $mysqli;
  if(!$result = $mysqli->query($query))
  {
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
  }
	return $tab = $result->fetch_row();	
}

//Funkcja - Uczeń
function uczen($id_kl)
{
  global $mysqli;
  if($result = $mysqli->query("SELECT id_ucz FROM uczen WHERE id_kl = '$id_kl'"))
  {	  
	if($result->num_rows > 0)
	{
		while($row=$result->fetch_object())
		{
		  $tab[] = $row->id_ucz;
		}
	}
  }
  return $tab;	
}

//Funkcja - Rodzice
function rodzice($id_kl)
{
	global $mysqli;
	
	$tab = uczen($id_kl);
	$ile = count($tab);
	
	for($i=0; $i < $ile; $i++)
	{
	  $result = $mysqli->query("SELECT id_rodz FROM rodzice WHERE id_ucz='$tab[$i]'");
	  
	  if($result->num_rows > 0)
	  {
		while($row=$result->fetch_object())
		{
		  $rodzic[] = $row->id_rodz;		
		}
	  }
	}
  return  $rodzic;
}

//Funkcja - Dane
function dane($id_kl,$plec)
{
	 $tab = rodzice($id_kl);
	 $ile = count($tab);
	
	for($i=0; $i < $ile; $i++)
	{
	  $query = "SELECT nazwisko, imieM FROM rodzic WHERE id_rodz='$tab[$i]'";
	  $tb = zapytanie($query);
	  $nazwisko = $tb[0];
	  $imie = $tb[1];
	  
	  echo '<option value="'.$tab[$i].'; k">'. $imie.' '. $nazwisko .'</option>';
	  
	  $query = "SELECT nazwisko, imieO FROM rodzic WHERE id_rodz='$tab[$i]'";
	  $tb = zapytanie($query);
	  $nazwisko = $tb[0];
	  $imie = $tb[1];
	  
	  echo '<option value="'.$tab[$i].'; m">'. $imie.' '. $nazwisko .'</option>';
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
  <div class="left" id="formularz">
  <h3 id="naglPrzedmiot">EDYCJA - RADA RODZICÓW</h3>
  <form action="db_rada_upd.php" method="post" name="form" id="form">
  <input type="hidden" name="id_rd" id="id_rd" value="<?php echo $id_rd ?>">
    <table id="przedmioty">
    <tr><td class="dane">Rodzic:*</td><td>
      <select name="rodzic">
        <option value="<?php echo $id_rodz ?>"><?php echo $imie . ' ' .$nazwisko ?></option>
        <option value="0">...</option>
        <?php dane($id_kl);?>
      </select>
    </td></tr>
    <tr>
      <td></td><td><input type="button" value="Popraw dane" class="przycisk" id="poprawRada"></td>
    </tr>
    </table>
  </form>
  </div>
  <div class="right">
  <h3>RADA KLASY <?php echo $klasa .' '.$sb ?></h3>
  <div id="pokazRada">
  </div>
      <br><br>
  </div>

  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>