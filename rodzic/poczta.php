<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_03.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.scrollTo(0, 200)">
<?php
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');
 
//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Klasy
include_once('../class/poczta_terminy.class.php');
include_once('../class/poczta_dzien.class.php');
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Zmienne
$kto=$_SESSION['zalogowany'];
$id = $_SESSION['id_db'];
$nazwisko = $_SESSION['nazwisko_db'];
$imie = $_SESSION['imie_db'];
$rola = $_SESSION['rola_db'];
$nr=0;

//Klasa  - Tablica godzin
class widokGodziny
{
  private $zestaw;
  private $nr;
  private $dane;

  public function tabGodz()
  {
	$this->zestaw = $bazaGodziny->godziny();
	$this->nr = 0;
	
	foreach($this->zestaw as $this->dane)
	{
	  $this->dane = explode(';', $this->dane);
	  $this->nr++;
	  
	  echo'<option value="'.$this->dane[0].'">'.$this->dane[0].' | '.$this->dane[1].' - '.$this->dane[2].'</option>';	 
	}
  }
}

//Obiekty
$wiadomosc = new news;
$bazaGodziny= new terminy;
$bazaDzien = new dzien;
$daneGodziny = new widokGodziny;

?>
<div id="kontener">
	<div id="logo">
	 <img src="../image/logo_user.png" alt="Logo">
     <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie,' ',$nazwisko,' - ', $_SESSION['kto'] ?></p>
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
    <ul class="nawigacja_new">
    <li><a href="#" title="sk_od" class="zaj aktywna">Skrzynka odbiorcza</a></li>
    <li><a href="#" title="sk_nad" class="zaj">Skrzynka nadawcza</a></li>
    </ul>
      <!-- SKRZYNKA NADAWCZA -->
      <div id="sk_nad" class="zawartosc">
      <h3 id="nagRamka1">NAPISZ LIST</h3>
      <p class="center-4">Dzisiaj jest <?php echo $bazaDzien->dzw().', '. $bazaGodziny->data(); ?> roku. Godz.: <?php echo $bazaGodziny->godz(); ?>.</p>
      <form action="poczta_dod.php?dt=<?php echo $bazaGodziny->dt(); ?>" method="post" name="form" id="form">
      <table id="center-tabela-pod-3">
      <tr><td class="dane-3">Do:*</td></tr>
      <tr><td class="dane-3">
        <select class="min-7" name="users">
          <option value="x">---</option>
          <option value="2">Dyrektor</option>
          <option value="3">Wychowawcy</option>
          <option value="4">Nauczyciele</option>
        </select>
      </td></tr>
      <tr><td class="dane-3" colspan="2"><div id="view">Nazwisko i imię:*</div></td></tr>
      <tr><td class="dane-3" colspan="2"><div id="zestaw"></div></td></tr>
      <tr><td class="dane-3">Temat:*</td></tr>
      <tr><td class="dane-3"><input class="dane-4" type="text" name="tytul" id="tytul"></td></tr>
      <tr><td class="dane-3">Treść:*</td></tr>
      <tr><td class="dane-3">
      <textarea name="tresc" id="tresc" cols="100" rows="4"></textarea>
      </td></tr>
      <tr><td class="dane-3"><input type="button" value="Wyślij list" class="button" id="zapisz-list"></td></tr>
      </form>
      </table>
      <div id="user1"></div>
      <div id="user"></div>
      </div>
      <!-- SKRZYNKA ODBIORCZA -->
      <div id="sk_od" class="zawartosc">
        <h3 id="nagRamka1">OTRZYMANE LISTY</h3>
        <p class="center-4">Dzisiaj jest <?php echo $bazaDzien->dzw() .', '. $bazaGodziny->data(); ?> roku. Godz.: <?php echo $bazaGodziny->godz(); ?>.</p>
        <div id="user2"></div>
      </div><br><br>
    </div>
	<div id="stopka">
	<p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
	</div>
</div>
</body>
</html>