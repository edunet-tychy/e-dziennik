﻿<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/jquery.tooltipster.min.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
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
 
//Sprawdzenie nawiązania połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');
include_once('../class/poczta_new.class.php');

//Obiekty
$wiadomosc = new news;
$bazaPoczta = new nowaPoczta;

$kto=$_SESSION['zalogowany'];
$query = "SELECT id, nazwisko, imie, id_st FROM users WHERE login='$kto'";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}

$row = $result->fetch_row();

$id_db = $row[0];
$nazwisko_db = $row[1];
$imie_db = $row[2];
$rola_db = $row[3];

$_SESSION['id_db'] = $id_db;
$_SESSION['nazwisko_db'] = $nazwisko_db;
$_SESSION['imie_db'] = $imie_db;
$_SESSION['rola_db'] = $rola_db;

$query = "SELECT id_sz, id_kl, klasa, sb FROM vwychowawca WHERE id='$id_db'";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
   header('Location: ../logout.php');
}

$row = $result->fetch_row();
$id_sz = $row[0];
$id_kl = $row[1];
$klasa = $row[2];
$sb  = $row[3];

$_SESSION['id_sz'] = $id_sz;
$_SESSION['id_kl'] = $id_kl;
$_SESSION['klasa'] = $klasa;
$_SESSION['sb'] = $sb;

$identyfikator = $_SESSION['kto'].' klasy: '.$_SESSION['klasa'].' '.$_SESSION['sb'];
$_SESSION['idenfyfikator'] = $identyfikator;

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
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $_SESSION['imie_db'],' ',$_SESSION['nazwisko_db'],' - '. iden($kto); ?></p>
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
  <p class="panel">Witaj! <a href="../nauczyciel/poczta.php"><?php $bazaPoczta->poczta($id_db); ?></a><div id="klasa"></div></p>
  <div class="linia"></div>
  <div id="panel">

    <div class="linka">
    <div class="icona"><a href="db_frekwencja.php"><img class="tooltip" src="image/icony/calendar_2.png" alt="Usprawiedliwienia" title="Usprawiedliwienia godzin nieobecnych"></a></div>
    <div class="info"><a href="db_frekwencja.php">FREKWENCJA</a></div>
    </div>

    <div class="linka">
    <div class="icona"><a href="db_oceny_uczen.php"><img class="tooltip" src="image/icony/calendar.png" alt="Oceny klasy" title="Sprawdź oceny klasy"></a></div>
    <div class="info"><a href="db_oceny_uczen.php">OCENY KLASY</a></div>
    </div>

    <div class="linka">
    <div class="icona"><a href="db_podreczniki_pok.php"><img class="tooltip" src="image/icony/document_edit.png" alt="Podręczniki" title="Sprawdź listę podręczników klasy"></a></div>
    <div class="info"><a href="db_podreczniki_pok.php">PODRĘCZNIKI</a></div>
    </div>

    <div class="linka">
    <div class="icona"><a href="db_programy_pok.php"><img class="tooltip" src="image/icony/document_edit.png" alt="Programy nauczania" title="Sprawdź listę programów klasy"></a></div>
    <div class="info"><a href="db_programy_pok.php">PROGRAMY</a></div>
    </div>

    <div class="odstep"></div>

    <div class="linka">
    <div class="icona"><a href="db_uwagi_dane.php"><img class="tooltip" src="image/icony/message.png" alt="Uwagi o uczniu" title="Napisz uwagę o uczniu. Wystaw ocenę z zachowania"></a></div>
    <div class="info"><a href="db_uwagi_dane.php">UWAGI O UCZNIU</a></div>
    </div>

    <div class="linka">
    <div class="icona"><a href="db_kontakt_dane.php"><img class="tooltip" src="image/icony/file_edit.png" alt="Kontakt z rodzicem" title="Dopisz informację o kontaktach z rodzicami"></a></div>
    <div class="info"><a href="db_kontakt_dane.php">KONTAKT Z RODZICEM</a></div>
    </div>
          
    <div class="linka">
    <div class="icona"><a href="db_plan.php"><img class="tooltip" src="image/icony/clock.png" alt="Plan zajęć" title="Utwórz plan zajęć"></a></div>
    <div class="info"><a href="db_plan.php">PLAN ZAJĘĆ KLASY</a></div>
    </div>
    
    <div class="linka">
    <div class="icona"><a href="db_wydarzenia_dane.php"><img class="tooltip" src="image/icony/file.png" alt="Wydarzenia klasowe"  title="Dopisz wydarzenie klasowe"></a></div>
    <div class="info"><a href="db_wydarzenia_dane.php">WYDARZENIA</a></div>
    </div>
    
    <div class="odstep"></div>
    
  </div>
  <p class="panel">Panel konfiguracyjny klasy</p>
  <div class="linia"></div>
  <div id="panel">    
    <div class="odstep"></div>
    
    <div class="linka">
    <div class="icona"><a href="db_uczen.php"><img class="tooltip" src="image/icony/user_add.png" alt="Uczniowie" title="Dodaj, modyfikuj dane ucznia"></a></div>
    <div class="info"><a href="db_uczen.php">UCZNIOWIE</a></div>
    </div>
    
    <div class="linka">
    <div class="icona"><a href="db_przedmioty.php"><img class="tooltip" src="image/icony/file_add.png" alt="Przedmioty" title="Dodaj przedmioty oraz nauczycieli"></a></div>
    <div class="info"><a href="db_przedmioty.php">PRZEDMIOTY</a></div>
    </div>

    <div class="linka">
    <div class="icona"><a href="db_samorzad.php"><img class="tooltip" src="image/icony/nauczyciel.png" alt="Samorząd" title="Zapisz samorząd klasowy"></a></div>
    <div class="info"><a href="db_samorzad.php">SAMORZĄD KLASY</a></div>
    </div>
    
    <div class="linka">
    <div class="icona"><a href="db_rada.php"><img class="tooltip" src="image/icony/user_manage.png" alt="Rada rodziców" title="Zapisz radę rodziców klasy"></a></div>
    <div class="info"><a href="db_rada.php">RADA RODZICÓW</a></div>
    </div>
  </div>
  </div>
  
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>