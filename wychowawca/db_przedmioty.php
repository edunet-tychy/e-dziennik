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
  var url = 'db_przedmiot_pok.php';
  $("#pokazPrzedmioty").load(url);
});
</script>
</head>
<body onload="window.scrollTo(0, 200)">
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

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

function przedmioty($mysqli)
{
  if($result = $mysqli->query("SELECT * FROM przedmioty ORDER BY nazwa"))
  {	  
	if($result->num_rows > 0)
	{
		while($row=$result->fetch_object())
		{
		  echo '<option value="'.$row->id_przed.'">'. $row->nazwa .'</option>';
		}
	}
  }	
}

function nauczyciele($mysqli)
{
  if($result = $mysqli->query("SELECT id, nazwisko, imie FROM users WHERE id_st <> 1 AND id_st <> 2 AND id_st < 5 ORDER BY nazwisko"))
  {	  
	if($result->num_rows > 0)
	{
		while($row=$result->fetch_object())
		{
		  echo '<option value="'.$row->id.'">'. $row->nazwisko .' '. $row->imie .'</option>';
		}
	}
  }	
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
  <div class="left" id="formularz">
  <h3 id="naglPrzedmiot">NAZWA PRZEDMIOTU</h3>
  <form action="db_przedmiot_dod.php" method="post" name="formPrzedmiot" id="formPrzedmiot">
    <table id="przedmioty">
    <tr><td class="dane">Przedmiot:*</td><td>
      <select name="przedmiot" id="przedmiot">
        <option value="x">...</option>
        <?php przedmioty($mysqli);?>
      </select>
    </td></tr>
    <tr><td class="dane">Nauczyciel 1:*</td><td>
      <select name="nauczyciel1" id="nauczyciel1">
        <option value="x">...</option>
        <?php nauczyciele($mysqli);?>
      </select>
    </td></tr>
    <tr>
    <td class="dane">Nauczyciel 2:&nbsp;</td><td>
      <select name="nauczyciel2"  id="nauczyciel2">
      <option value="x">...</option>
        <?php nauczyciele($mysqli);?>
      </select>      
    </td></tr>
    <tr>
      <td></td><td><input type="button" value="Dodaj przedmiot" class="przycisk" id="dodajPrzedmiot"></td>
    </tr>
    </table>
  </form>
    <div id="informacje">
    <p>* - w tym polu dane są obowiązkowe</p>
    </div>
  </div>
  <div class="right">
  <h3>LISTA PRZEDMIOTÓW I NAUCZYCIELI KLASY <?php echo $klasa .' '.$sb ?></h3>
  <div id="pokazPrzedmioty">
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