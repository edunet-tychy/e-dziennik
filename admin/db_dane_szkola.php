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
//Nawiązanie połączenia serwerem MySQL
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

//Zmienne
$id_db = $_SESSION['id_db'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];

//Funkcja - Dane szkoły
function szkola($mysqli)
{

  if($result = $mysqli->query("SELECT * FROM dane_szkoly"))
  {
	//Sprawdzenie, czy rekordów jest więcej niż 0
	if($result->num_rows > 0)
	{
		echo'<table id="center-tabela-szkola">';		  
		//Generujemy wiersz
		while($row=$result->fetch_object())
		{
			echo'<tr><td class="prawy">NAZWA SZKOŁY:</td><td class="lewy">'. $row->opis .'</td></tr>';
			echo'<tr><td class="prawy">ADRES:</td><td class="lewy">'. $row->ulica .', '. $row->kod .' '. $row->miasto .'</td></tr>';
			echo'<tr><td class="prawy">TELEFON:</td><td class="lewy">'. $row->telefon .'</td></tr>';
			echo'<tr><td class="prawy">POCZTA:</td><td class="lewy">'. $row->email .'</td></tr>';		
			echo'<tr><td class="prawy">NIP:</td><td class="lewy">'. $row->nip .'</td></tr>';
			echo'<tr><td class="prawy">REGON:</td><td class="lewy">'. $row->regon .'</td></tr>';
			echo'<tr><td class="edycja" colspan="2"><a class="edycja_link" href="db_dane_szkola_edit.php?id='. $row->id .'">EDYTUJ DANE SZKOŁY</a></td></tr>';
		}
		
		echo'</table>';
		
	} else {
		echo '<img src="image/pytanie.png" alt="Brak rekordów">';
		echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
		echo '<h3 id="nagSzkola">DANE ZESPOŁU SZKÓŁ</h3>';
		echo '<p class="info-2"><a class="linki" href="db_dane.php">Dodaj dane</a></p>';
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
  <h3 id="nagSzkola">DANE PLACÓWKI</h3>
  <?php szkola($mysqli); ?>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>