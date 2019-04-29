<?php
  include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="../javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_szkola.js"></script>
<link href="styl/styl_szkola.css" rel="stylesheet" type="text/css">

</head>
<body onload="window.scrollTo(0, 200)">

<?php
//Nawiązanie połączenia serwerem MySQL.
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
 echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
 echo $mysqli->connect_error;
}

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;
$baza = new zapytanie;

//Zmienne
$id_db = $_SESSION['id_db'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$ucz = $_GET['id_ucz'];

//Wyszukanie ID klasy
$query = "SELECT id_kl FROM uczen WHERE id_user='$ucz'";
$baza->pytanie($query);
$id_kl = $baza->tab[0];

$query = "SELECT nazwisko, imie, klasa, sb FROM vwychowawca WHERE id_kl='$id_kl'";
$baza->pytanie($query);
$nazwisko = $baza->tab[0];
$imie = $baza->tab[1];
$klasa= $baza->tab[2];
$sb = $baza->tab[3];

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
  <h3 id="nagDzwonki">NAUCZYCIELE</h3>
  <form action="db_org_roku_upd.php" method="post" name="formUp" id="formUp">
  
    <table id="nauczyciele-2">
    <tr><th>WYCHOWAWCA KLASY <?php echo $klasa.' '.$sb.' - '.mb_strtoupper($nazwisko,"UTF-8").' '.mb_strtoupper($imie,"UTF-8"); ?></th></tr>
    </table>
    
    <table id="nauczyciele-2">
    <tr><th>NR</th><th>PRZEDMIOT</th><th>NAZWISKO I IMIĘ NAUCZYCIELA</th></tr>
  
    <?php
	$query = "SELECT id_kp, id_przed FROM klasy_przedmioty WHERE id_kl='$id_kl'";
	
	if($odp = $mysqli->query($query))
    {
	  $ile=0;
	  
	  if($odp->num_rows > 0)
	  {
		while($wiersz=$odp->fetch_object())
		{
		  
		  $id_kp = $wiersz->id_kp;
		  $id_przed = $wiersz->id_przed;
		  
		  $query = "SELECT id_naucz FROM klasy_nauczyciele WHERE id_kp='$id_kp'";
		  $baza->pytanie($query);
		  $id = $baza->tab[0];
		  
		  $query = "SELECT nazwisko, imie FROM users WHERE id='$id'";
		  $baza->pytanie($query);
		  $nazwisko = $baza->tab[0];
		  $imie = $baza->tab[1];
		  
		  $query = "SELECT nazwa FROM przedmioty WHERE id_przed='$id_przed'";
		  $baza->pytanie($query);
		  $nazwa = $baza->tab[0];
		  
		  if($nazwa != 'Godzina wychowawcza')
		  {
		    $ile++;
			echo '<td class="nr">'.$ile.'</td>';
			echo '<td class="lewy">'.$nazwa.'</td>';	
			echo '<td class="lewy-2">'.$nazwisko.' '.$imie.'</td>';
		  }
		  echo '</tr>';
		}
		
	  }
	}
	
    ?>
    </table>
  </form>
  <br><br>
  </div>
  <div id="stopka">
    <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>