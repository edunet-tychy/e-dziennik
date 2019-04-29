<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/jquery.tooltipster.min.js"></script>
<script type="text/javascript" src="javascript/script_05.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<link href="styl/styl_frek.css" rel="stylesheet" type="text/css">
<link href="styl/tooltipster.css" rel="stylesheet" type="text/css">
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
include_once('../class/zapytanie.class.php');
include_once('../class/frekwencja_rok.class.php');
include_once('../class/frekwencja_miesiac.class.php');
include_once('../class/news.class.php');

//Zmienne
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$id_kl = $_GET['id_kl'];

//Obiekty
$wiadomosc = new news;
$baza = new zapytanie;
$bazaFrekUczniow = new frekwencjaUczniow;

//Zapytanie - Uwagi
$query = "SELECT klasa,sb FROM vklasy WHERE id_kl = '$id_kl'";
$baza->pytanie($query);
$klasa = $baza->tab[0];
$sb = $baza->tab[1];

//Zapytanie - ilość przedmiotów
$query = "SELECT count(id_przed) FROM klasy_przedmioty WHERE id_kl='$id_kl'";
$baza->pytanie($query);
$nr = $baza->tab[0];


//Klasa View
class frekwencjaUczniow
{
  private $result;
  private $row;
  private $query;
  private $mysqli;
  private $id_kl;
  private $lp = 0;
  private $id_user;
  private $nazwisko;
  private $imie;
  private $dane;
  private $uczen;
  private $id_ucz;
  
  //Funkcja - View: Frekwencja uczniów
  function uczen($id_kl,$mysqli)
  {
	$baza = new zapytanie;
	$bazaFrekRok = new frekwencjaRok;
	$bazaFrekMsc = new frekwencjaMiesiaca;
	
	$this->mysqli = $mysqli;
	$this->id_kl = $id_kl;
  
	if($this->result = $this->mysqli->query("SELECT id_user FROM uczen WHERE id_kl='$this->id_kl'"))
	{
		while($this->row=$this->result->fetch_object())
		{
		  $this->id_user = $this->row->id_user;
		  
		  $this->query = "SELECT nazwisko, imie FROM users WHERE id='$this->id_user'";
		  $baza->pytanie($this->query);
		  $this->nazwisko = $baza->tab[0];
		  $this->imie = $baza->tab[1];
		  
		  $this->dane[] = $this->nazwisko.'; '.$this->imie.'; '.$this->id_user;
		}
	}
	
	if(isset($this->dane)) sort($this->dane);
	
	if(isset($this->dane))
	{
	  foreach($this->dane as $this->uczen)
	  {
	  
	   $this->lp++;
	   $this->uczen = explode('; ',$this->uczen);
	   
	   echo'<tr>';
	   echo'<td class="tooltip" title="'.$this->uczen[0].' '.$this->uczen[1].'" id="uczen">'.$this->lp.'</td>';
	   
	   $this->id_ucz = $this->uczen[2];
	   
	   //Miesiące
	   $bazaFrekMsc->frek_msc($this->id_ucz,'02',$mysqli);
	   $bazaFrekMsc->frek_msc($this->id_ucz,'03',$mysqli);
	   $bazaFrekMsc->frek_msc($this->id_ucz,'04',$mysqli);
	   $bazaFrekMsc->frek_msc($this->id_ucz,'05',$mysqli);
	   $bazaFrekMsc->frek_msc($this->id_ucz,'06',$mysqli);
	   
	   //Semestr
	   $bazaFrekRok->frek_sem($this->id_ucz,$mysqli);
  
	  }
	}
  }	
}
?>
<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie_db,' ',$nazwisko_db,' - ', $kto; ?></p>
  </div>
  <div id="opis"><div id="nowosc"><?php $wiadomosc->wiadomosc(); ?></div>
   <p class="info" id="<?php echo $id_kl ;?>">
   <a class="linki" href="../logout.php">Wylogowanie</a>
   </p>
  </div>
  <div id="spis">
  <?php include_once('menu.php');?>
  </div>   
  <div id="czescGlowna">
    <div id="lista" class="zawartosc">
    <ul class="nawigacja_sem2">
      <li><a href="frekwencja.php?id_kl=<?php echo $id_kl ;?>" title="Semestr I" class="sem" id="pod_1">SEMESTR I</a></li>
      <li><a href="frekwencja_rok.php?id_kl=<?php echo $id_kl ;?>" title="Semestr II" class="sem aktywna" id="pod_2">SEMESTR II</a></li>
    </ul>
    <table id="zestawienie-2">
    <tr><th colspan="19">ZESTAWIENIE FREKWENCJI ZA II SEMESTR  - KLASA <?php echo $klasa . ' ' . $sb?></th></tr>
    <tr>
    <th rowspan="3">Nr</th>
    <th colspan="3">Luty</th>
    <th colspan="3">Marzec</th>
    <th colspan="3">Kwiecień</th>
    <th colspan="3">Maj</th>
    <th colspan="3">Czerwiec</th>
    <th rowspan="2" colspan="3">Razem</th>
  </tr>
  <tr>
    <th colspan="15">liczba opuszczonych lekcji</th>
  </tr>
  <tr>
    <th class="ng">uspr.</th>
    <th class="ng">nieuspr.</th>
    <th class="ng">spóźn.</th>
    <th class="ng">uspr.</th>
    <th class="ng">nieuspr.</th>
    <th class="ng">spóźn.</th>
    <th class="ng">uspr.</th>
    <th class="ng">nieuspr.</th>
    <th class="ng">spóźn.</th>
    <th class="ng">uspr.</th>
    <th class="ng">nieuspr.</th>
    <th class="ng">spóźn.</th>
    <th class="ng">uspr.</th>
    <th class="ng">nieuspr.</th>
    <th class="ng">spóźn.</th>
    <th class="ng">uspr.</th>
    <th class="ng">nieuspr.</th>
    <th class="ng">spóźn.</th>
  </tr>
  <?php $bazaFrekUczniow->uczen($id_kl,$mysqli) ;?>
  </table>
      <div id="user"></div><br><br>
    </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>