<?php
include_once('status.php');
include_once('../class/sem.class.php');
$sem = new semestr;
$_SESSION['wstecz'] = 0;
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

  var temat = "tematy.php?id_kl=";
  temat += $(".aktywna").attr("id").valueOf();
  $(".temat").attr("href",temat);

  var uwaga = "uwagi.php?id_kl=";
  uwaga += $(".aktywna").attr("id").valueOf();
  $(".uwaga").attr("href",uwaga);	

  var rozklad = "rozklad_dane.php?id_kl=";
  rozklad += $(".aktywna").attr("id").valueOf();
  $(".rozklad").attr("href",rozklad);

  var podrecznik = "podrecznik.php?id_kl=";
  podrecznik += $(".aktywna").attr("id").valueOf();
  $(".podrecznik").attr("href",podrecznik);

  var program = "program.php?id_kl=";
  program += $(".aktywna").attr("id").valueOf();
  $(".program").attr("href",program);

  var klasa = "id_kl=";
  klasa += $(".aktywna").attr("id").valueOf();
  var url = "naucz_klasy.php";
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

	var temat = "tematy.php?id_kl=";
	temat += $(this).attr("id").valueOf();
	$(".temat").attr("href",temat);

	var uwaga = "uwagi.php?id_kl=";
	uwaga += $(this).attr("id").valueOf();
	$(".uwaga").attr("href",uwaga);	

	var rozklad = "rozklad_dane.php?id_kl=";
	rozklad += $(this).attr("id").valueOf();
	$(".rozklad").attr("href",rozklad);	

	var podrecznik = "podrecznik.php?id_kl=";
	podrecznik += $(this).attr("id").valueOf();
	$(".podrecznik").attr("href",podrecznik);

	var program = "program.php?id_kl=";
	program += $(this).attr("id").valueOf();
	$(".program").attr("href",program);
	
	var klasa = "id_kl=";
	klasa += $(this).attr("id").valueOf();
	var url = "naucz_klasy.php";
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
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/panel_klasy.class.php');
include_once('../class/poczta_new.class.php');
include_once('../class/news.class.php');

//Obiekty
$bazaPanel = new klasyPanel;
$bazaPoczta = new nowaPoczta;
$wiadomosc = new news;

$baza = new zapytanie;

$kto=$_SESSION['zalogowany'];
$query = "SELECT id, nazwisko, imie, id_st FROM users WHERE login='$kto'";
$baza->pytanie($query);

$id_db = $baza->tab[0];
$nazwisko_db = $baza->tab[1];
$imie_db = $baza->tab[2];
$rola_db = $baza->tab[3];

//Zmienne sesyjne
$_SESSION['id_db'] = $id_db;
$_SESSION['nazwisko_db'] = $nazwisko_db;
$_SESSION['imie_db'] = $imie_db;
$_SESSION['rola_db'] = $rola_db;

$id = $_SESSION['id_db'];

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
     <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $_SESSION['imie_db'],' ',$_SESSION['nazwisko_db'],' - ', iden($kto) ?></p>
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
      <p class="panel">Witaj! <a href="poczta.php"><?php $bazaPoczta->poczta($id); ?></a><div id="klasa"></div></p>
      <div class="linia"></div>
      <ul class="nawigacja">
      <?php $bazaPanel->klasy_panel(); ?>
      </ul>
        <div id="panel">
    
          <div class="linka">
          <div class="icona"><a class="ocena" href=""><img class="tooltip" src="image/icony/calendar.png" alt="Oceny klasy" title="Dodaj ocenę uczniom aktywnej klasy"></a></div>
          <div class="info"><a class="ocena" href="">OCENY KLASY</a></div>
          </div>
    
          <div class="linka">
          <div class="icona"><a class="temat" href=""><img class="tooltip" src="image/icony/file_edit.png" alt="Tematy zajęć" title="Sprawdź obecność oraz zapisz temat zajęć"></a></div>
          <div class="info"><a class="temat" href="">TEMATY ZAJĘĆ</a></div>
          </div>
    
          <div class="linka">
          <div class="icona"><a class="uwaga" href=""><img class="tooltip" src="image/icony/message.png" alt="Uwagi o uczniu" title="Napisz uwagę"></a></div>
          <div class="info"><a class="uwaga" href="">UWAGI O UCZNIU</a></div>
          </div>
                
          <div class="odstep"></div>
    
          <div class="linka">
          <div class="icona"><a class="rozklad" href=""><img class="tooltip" src="image/icony/file_add.png" alt="Rozkład materiału" title="Utwórz, modyfikuj rozkład materiału"></a></div>
          <div class="info"><a class="rozklad" href="">ROZKŁAD MATERIAŁU</a></div>
          </div>
    
          <div class="linka">
          <div class="icona"><a class="podrecznik" href=""><img class="tooltip" src="image/icony/document_add.png" alt="Podręcznik" title="Dodaj obowiązujący podręcznik w klasie"></a></div>
          <div class="info"><a class="podrecznik" href="">PODRĘCZNIK</a></div>
          </div>
    
          <div class="linka">
          <div class="icona"><a class="program" href=""><img class="tooltip" src="image/icony/document_edit.png" alt="Program nauczania" title="Dodaj obowiązujący program nauczania w klasie"></a></div>
          <div class="info"><a class="program" href="">PROGRAM</a></div>
          </div>
    
          <div class="odstep"></div>
      </div>
      <div class="linia"></div>
      <div id="osob">Panel danych osobistych</div>
        <div id="panel-n">
    
          <div class="linka">
          <div class="icona"><a href="plan_zajec.php"><img class="tooltip" src="image/icony/clock.png" alt="Plan zajęć" title="Sprawdź swój plan zajęć"></a></div>
          <div class="info"><a href="plan_zajec.php">PLAN ZAJĘĆ</a></div>
          </div>
    
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
    
	<div id="stopka">
	<p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
	</div>
</div>
</body>
</html>