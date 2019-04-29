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
	var url = 'db_samorzad_pok.php';
	$("#pokazSamorzad").load(url);

//Poprawa danych samorządu
	$("#poprawSam").click(function()
	{
		var dane = $("form").serialize();
		var url = $("form").attr("action");
		var adr = 'db_samorzad_pok.php';
		$.post(url, dane, function()
		{  
			 $("#pokazSamorzad").load(adr);
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

$id_sm=$_GET['id_sm'];

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

$query = "SELECT id_user, rola FROM samorzad WHERE id_sm='$id_sm'";
$tb = zapytanie($query);
$id_user = $tb[0];
$funkcja = $tb[1];

  switch($funkcja){
  case 'p' :
	$rw = 'Przewodniczący';
  break;
  case 'z' :
	$rw = 'Zastępca';
  break;
  case 's' :
	$rw = 'Skarbnik';
  break;
  }

$query = "SELECT nazwisko, imie FROM users WHERE id='$id_user'";
$tb = zapytanie($query);
$nazwisko = $tb[0];
$imie = $tb[1];

function uczen($id_kl)
{
  global $mysqli;
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

function dane($id_kl)
{
	$tab = uczen($id_kl);
	$ile = count($tab);
	
	for($i=0; $i < $ile; $i++)
	{
	  $query = "SELECT nazwisko, imie FROM users WHERE id='$tab[$i]'";
	  $tb = zapytanie($query);
	  $nazwisko = $tb[0];
	  $imie = $tb[1];
	  
	  echo '<option value="'.$tab[$i].'">'. $imie.' '. $nazwisko .'</option>';
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
  <h3 id="naglPrzedmiot">EDYCJA - SAMORZĄD KLASOWY</h3>
  <form action="db_samorzad_upd.php" method="post" name="form" id="form">
  <input type="hidden" name="id_sm" id="id_sm" value="<?php echo $id_sm ?>">
    <table id="przedmioty">
    <tr><td class="dane">Funkcja:*</td><td>
      <select name="rola">
        <option value="<?php echo $funkcja ?>"><?php echo $rw ?></option>
        <option value="0">...</option>
        <option value="p">Przewodniczący</option>
        <option value="z">Zastępca</option>
        <option value="s">Skarbnik</option>
      </select>
    </td></tr>
    <tr><td class="dane">Uczeń:*</td><td>
      <select name="uczen">
        <option value="<?php echo $id_user ?>"><?php echo $imie . ' ' .$nazwisko ?></option>
        <option value="0">---</option>
        <?php dane($id_kl);?>
      </select>
    </td></tr>
    <tr>
      <td></td><td><input type="button" value="Popraw dane" class="przycisk" id="poprawSam"></td>
    </tr>
    </table>
  </form>
  </div>
  <div class="right">
  <h3>SAMORZĄD KLASY <?php echo $klasa .' '.$sb ?></h3>
  <div id="pokazSamorzad">
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