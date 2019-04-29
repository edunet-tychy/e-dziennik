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
<script type="text/javascript" src="javascript/jquery.tooltipster.min.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<link href="styl/styl_szkola.css" rel="stylesheet" type="text/css">
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

//Nawiązanie połączenia serwerem MySQL.
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL.
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/poczta_new.class.php');
include_once('../class/news.class.php');

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

//Zmienne sesyjne
$_SESSION['id_db'] = $id_db;
$_SESSION['nazwisko_db'] = $nazwisko_db;
$_SESSION['imie_db'] = $imie_db;
$_SESSION['rola_db'] = $rola_db;


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
  <p class="panel">Witaj! <a href="poczta.php"><?php $bazaPoczta->poczta($id_db); ?></a></p>
  <div class="linia"></div>
  
    <div id="panel">
  
    <div class="linka">
    <div class="icona"><a href="db_dane_szkola.php"><img class="tooltip" src="image/icony/home.png" alt="Dane szkoły" title="Dodaj adres zespołu szkół"></a></div>
    <div class="info"><a href="db_dane_szkola.php">DANE PLACÓWKI</a></div>
    </div>

    <div class="linka">
    <div class="icona"><a href="db_zawod.php"><img class="tooltip" src="image/icony/document_add.png" alt="Lista szkół" title="Dodaj zawody kształcone w szkołach"></a></div>
    <div class="info"><a href="db_zawod.php">LISTA ZAWODÓW</a></div>
    </div>
    
    <div class="linka">
    <div class="icona"><a href="db_szkoly.php"><img class="tooltip" src="image/icony/file_add.png" alt="Lista szkół" title="Dodaj szkoły do zespołu szkół"></a></div>
    <div class="info"><a href="db_szkoly.php">LISTA SZKÓŁ</a></div>
    </div>

    <div class="linka">
    <div class="icona"><a href="db_przedmioty.php"><img class="tooltip" src="image/icony/application.png" alt="Przedmioty" title="Dodaj przedmioty nauczane w zespole szkół"></a></div>
    <div class="info"><a href="db_przedmioty.php">PRZEDMIOTY</a></div>
    </div>

    <div class="odstep"></div>

    <div class="linka">
    <div class="icona"><a href="db_user.php?st=1"><img class="tooltip" src="image/icony/user_manage.png" alt="Administrator" title="Dodaj administratora dziennika"></a></div>
    <div class="info"><a href="db_user.php?st=1">ADMINISTRATOR</a></div>
    </div>

    <div class="linka">
    <div class="icona"><a href="db_user.php?st=2"><img class="tooltip" src="image/icony/user_manage.png" alt="Dyrektor" title="Dodaj dyrektora oraz wicedyrektora"></a></div>
    <div class="info"><a href="db_user.php?st=2">DYREKTOR</a></div>
    </div>

    <div class="linka">
    <div class="icona"><a href="db_user.php?st=4"><img class="tooltip" src="image/icony/user_manage.png" alt="Nauczyciel" title="Dodaj nauczycieli uczących w zespole szkół"></a></div>
    <div class="info"><a href="db_user.php?st=4">NAUCZYCIEL</a></div>
    </div>

    <div class="linka">
    <div class="icona"><a href="db_news.php"><img class="tooltip" src="image/icony/news.png" alt="News" title="Dodaj ważne informacje dla szkolnej społeczności"></a></div>
    <div class="info"><a href="db_news.php">NEWS</a></div>
    </div>

    <div class="odstep"></div>

    <div class="linka">
    <div class="icona"><a href="backup/db_backup.php"><img class="tooltip" src="image/icony/diskette.png" alt="Komunikaty" title="Utwórz kopię bezpieczeństwa dziennika"></a></div>
    <div class="info"><a href="backup/db_backup.php">BACKUP BAZY</a></div>
    </div>
    
    <div class="linka">
    <div class="icona"><a href="db_org_roku.php"><img class="tooltip" src="image/icony/calendar_2.png" alt="Organizacja roku" title="Modyfikuj stałe elementy roku szkolnego"></a></div>
    <div class="info"><a href="db_org_roku.php">ORGANIZACJA ROKU</a></div>
    </div>

    <div class="linka">
    <div class="icona"><a href="db_kalendarz.php"><img class="tooltip" src="image/icony/calendar.png" alt="Kalendarz" title="Utwórz kalendarz szkolnych wydarzeń"></a></div>
    <div class="info"><a href="db_kalendarz.php">KALENDARZ</a></div>
    </div>
    
    <div class="linka">
    <div class="icona"><a href="db_dzwonki.php"><img class="tooltip" src="image/icony/clock.png" alt="Dzwonki" title="Modyfikuj plan szkolnych dzwoników lekcyjnych"></a></div>
    <div class="info"><a href="db_dzwonki.php">DZWONKI</a></div>
    </div>
                    
    <div class="odstep"></div>
    </div>
    
    <div class="linia-2"></div>
    <div id="osob">Panel danych osobistych</div>
    
    <div id="panel-dol">
    <div class="linka">
    <div class="icona"><a href="poczta.php"><img class="tooltip" src="image/icony/mail_write.png" alt="Komunikaty" title="Napisz list. Odczytaj pocztę"></a></div>
    <div class="info"><a href="poczta.php">POCZTA</a></div>
    </div>
    
    <div class="linka">
    <div class="icona"><a href="konto.php"><img class="tooltip" src="image/icony/user.png" alt="Moje konto" title="Sprawdź swoje ostatnie logowanie"></a></div>
    <div class="info"><a href="konto.php">MOJE KONTO</a></div>
    </div>

    <div class="linka">
    <div class="icona"><a href="usr_pass.php"><img class="tooltip" src="image/icony/security_lock.png" alt="Zmień hasło" title="Zmień swoje hasło"></a></div>
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