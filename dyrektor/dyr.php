<?php
include_once('status.php');
include_once('../class/sem.class.php');
$sem = new semestr;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/jquery.tooltipster.min.js"></script>
<script type="text/javascript" src="javascript/script_n.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<link href="styl/tooltipster.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function()
{
  $('.tooltip').tooltipster();
  var ocena = "<?php echo $sem->getSem(); ?>?id_kl=";
  ocena += $(".aktywna").attr("id").valueOf();
  $(".ocena").attr("href",ocena);

  var frekwencja = "<?php echo $sem->getFrekSem(); ?>?id_kl=";
  frekwencja += $(".aktywna").attr("id").valueOf();
  $(".frekwencja").attr("href",frekwencja);

  var uwaga = "uwagi.php?id_kl=";
  uwaga += $(".aktywna").attr("id").valueOf();
  $(".uwaga").attr("href",uwaga);	

  var temat = "tematy.php?id_kl=";
  temat += $(".aktywna").attr("id").valueOf();
  $(".temat").attr("href",temat);

  var podrecznik = "podreczniki.php?id_kl=";
  podrecznik += $(".aktywna").attr("id").valueOf();
  $(".podrecznik").attr("href",podrecznik);

  var program = "programy.php?id_kl=";
  program += $(".aktywna").attr("id").valueOf();
  $(".program").attr("href",program);

  var klasa = "id_kl=";
  klasa += $(".aktywna").attr("id").valueOf();
  var url = "dyr_klasy.php";
  $.post(url, klasa, function(result)
  {
	  $("#klasa").html(result);
  });

//Zakładki
$("a.zakladki").click(function()
{
	$(".aktywna").removeClass("aktywna");
	$(this).addClass("aktywna");

	var ocena = "<?php echo $sem->getSem(); ?>?id_kl=";
	ocena += $(this).attr("id").valueOf();
	$(".ocena").attr("href",ocena);

	var frekwencja = "<?php echo $sem->getFrekSem(); ?>?id_kl=";
	frekwencja += $(".aktywna").attr("id").valueOf();
	$(".frekwencja").attr("href",frekwencja);

	var uwaga = "uwagi.php?id_kl=";
	uwaga += $(this).attr("id").valueOf();
	$(".uwaga").attr("href",uwaga);

	var temat = "tematy.php?id_kl=";
	temat += $(this).attr("id").valueOf();
	$(".temat").attr("href",temat);	

	var podrecznik = "podreczniki.php?id_kl=";
	podrecznik += $(this).attr("id").valueOf();
	$(".podrecznik").attr("href",podrecznik);

	var program = "programy.php?id_kl=";
	program += $(this).attr("id").valueOf();
	$(".program").attr("href",program);

	var klasa = "id_kl=";
	klasa += $(this).attr("id").valueOf();
	var url = "dyr_klasy.php";
	$.post(url, klasa, function(result)
	{
		$("#klasa").html(result);
	});
	
});

});
</script>
</head>
<body>
<?php
//Nawiązanie połączenia serwerem z MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia serwerem z MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/panel_klasy_dyr.class.php');
include_once('../class/poczta_new.class.php');
include_once('../class/news.class.php');

//Zmienna i zapytanie
$kto=$_SESSION['zalogowany'];

//Obiekty
$wiadomosc = new news;
$bazaPanel = new klasyPanel;
$bazaPoczta = new nowaPoczta;

$baza = new zapytanie;
$query = "SELECT id, nazwisko, imie, id_st FROM users WHERE login='$kto'";
$baza->pytanie($query);

$id_db = $baza->tab[0];
$nazwisko_db = $baza->tab[1];
$imie_db = $baza->tab[2];
$rola_db = $baza->tab[3];

//Zmienne sesyne
$_SESSION['id_db'] = $id_db;
$_SESSION['nazwisko_db'] = $nazwisko_db;
$_SESSION['imie_db'] = $imie_db;
$_SESSION['rola_db'] = $rola_db;

$id = $_SESSION['id_db'];

if(isset($_GET['kl'])) {$kl=$_GET['kl'];}
?>
<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $_SESSION['imie_db'],' ',$_SESSION['nazwisko_db'],' - ', $_SESSION['kto'] ?></p>
  </div>
  <div id="opis"><div id="nowosc"><?php $wiadomosc->wiadomosc(); ?></div><p class="info"><a class="linki" href="../logout.php">Wylogowanie</a></p></div>
  <div id="spis"><?php include_once('menu.php');?></div>   
  <div id="czescGlowna">
    <p class="panel">Witaj! <a href="poczta.php"><?php $bazaPoczta->poczta($id); ?></a><div id="klasa"></div></p>
    <div class="linia"></div>
    <ul class="nawigacja"><?php $bazaPanel->klasy_panel(); ?></ul>
      <div id="panel">
  
        <div class="linka">
        <div class="icona"><a class="ocena" href=""><img class="tooltip" src="image/icony/calendar.png" alt="Oceny klasy" title="Sprawdź oceny aktywnej klasy"></a></div>
        <div class="info"><a class="ocena" href="">OCENY KLASY</a></div>
        </div>
  
        <div class="linka">
        <div class="icona"><a class="frekwencja" href=""><img class="tooltip" src="image/icony/calendar_2.png" alt="Frekwencja" title="Sprawdź frekwencję aktywnej klasy"></a></div>
        <div class="info"><a class="frekwencja" href="">FREKWENCJA</a></div>
        </div>
  
        <div class="linka">
        <div class="icona"><a class="uwaga" href=""><img class="tooltip" src="image/icony/message.png" alt="Uwagi o uczniu" title="Sprawdź uwagi o uczniach aktywnej klasy"></a></div>
        <div class="info"><a class="uwaga" href="">UWAGI O UCZNIU</a></div>
        </div>

        <div class="linka">
        <div class="icona"><a class="podrecznik" href=""><img class="tooltip" src="image/icony/document_add.png" alt="Podręcznik" title="Sprawdź listę podręczników aktywnej klasy"></a></div>
        <div class="info"><a class="podrecznik" href="">PODRĘCZNIKI</a></div>
        </div>
  
        <div class="linka">
        <div class="icona"><a class="program" href=""><img class="tooltip" src="image/icony/document_edit.png" alt="Program nauczania" title="Sprawdź listę programów aktywnej klasy"></a></div>
        <div class="info"><a class="program" href="">PROGRAMY</a></div>
        </div>

        <div class="odstep"></div>
    </div>
    <div class="linia"></div>
    <div id="stat">Dane statystyczne</div>
       <div id="panel">
  
        <div class="linka">
        <div class="icona"><a href="stat_oceny.php"><img class="tooltip" src="image/icony/wykres_2.png" alt="Oceny klasy" title="Wykres średnich ocen wszystkich klas szkoły"></a></div>
        <div class="info"><a href="stat_oceny.php">ŚREDNIA OCEN</a></div>
        </div>
  
        <div class="linka">
        <div class="icona"><a href="stat_frek.php"><img class="tooltip" src="image/icony/wykres.png" alt="Frekwencja" title="Wykres frekwencji wszystkich klas szkoły"></a></div>
        <div class="info"><a href="stat_frek.php">ŚR. FREKWENCJA</a></div>
        </div>
  
        <div class="linka">
        <div class="icona"><a href="stat_max.php"><img class="tooltip" src="image/icony/user_manage.png" alt="Najlepsi uczniowie" title="Lista uczniów ze średnią powyżej 4.5"></a></div>
        <div class="info"><a href="stat_max.php">NAJLEPSI UCZ.</a></div>
        </div>

        <div class="linka">
        <div class="icona"><a href="stat_min.php"><img class="tooltip" src="image/icony/user_manage.png" alt="Podręcznik" title="Lista uczniów ze średnią poniżej 2.0"></a></div>
        <div class="info"><a href="stat_min.php">NAJSŁABSI UCZ.</a></div>
        </div>
  
        <div class="linka">
        <div class="icona"><a href="stat_nkl.php"><img class="tooltip" src="image/icony/user_manage.png" alt="Program nauczania" title="Lista uczniów nieklasyfikowanych"></a></div>
        <div class="info"><a href="stat_nkl.php">NIEKLASYFIKOWANI</a></div>
        </div>
  
        <div class="odstep"></div>
    </div>   
    <div class="linia"></div>
    <div id="osob">Panel danych osobistych</div>
      <div id="panel-n">
  
        <div class="linka">
        <div class="icona"><a href="poczta.php"><img class="tooltip" src="image/icony/mail_write.png" alt="Poczta" title="Napisz list. Odczytaj pocztę"></a></div>
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
  <div id="stopka"><p class="stopka">&copy; G.Szymkowiak 2014/2015</p></div>
</div>
</body>
</html>