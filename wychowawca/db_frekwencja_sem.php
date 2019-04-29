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
<script type="text/javascript" src="javascript/script_06.js"></script>
<link href="styl/styl_uczen.css" rel="stylesheet" type="text/css">
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<link href="styl/print_poz.css" rel="stylesheet" type="text/css" media="print">
<link href="styl/tooltipster.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function drukuj(){
 // sprawdź możliwości przeglądarki
   if (!window.print){
      alert("Twoja przeglądarka nie drukuje!")
   return 0;
   }
 alert("Orientacja druku: poziomo")
 window.print(); // jeśli wszystko ok drukuj
}
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

//Zapytanie - ilość przedmiotów
$query = "SELECT count(id_przed) FROM klasy_przedmioty WHERE id_kl='$id_kl'";
$tab = zapytanie($query);
$nr = $tab[0];

//Funkcja - zapytanie
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

//Funkcja - przedmioty klasy
function przedmioty($id_kl)
{
  global $mysqli;
  global $nr;

  if($result = $mysqli->query("SELECT id_przed FROM klasy_przedmioty WHERE id_kl='$id_kl'"))
  {
	if($result->num_rows > 0)
	{
	  while($row=$result->fetch_object())
	  {
		$id_przed = $row->id_przed;
		
		$nr++;
		$query = "SELECT nazwa, skrot FROM przedmioty WHERE id_przed='$id_przed'";
		$tab = zapytanie($query);
		$nazwa = $tab[0];
		$skrot = $tab[1];
		
		if($nazwa != 'Godzina wychowawcza')
		{
		  $przed[] = $id_przed;
		  echo'<th class="ng" title="'.$nazwa.'">'.$skrot.'</th>';
		}
	  }
	}
  }
  return $przed;
}

//Funkcja - uczniowie klasy
function uczen($id_kl)
{
  global $mysqli;
  
  $lp = 0;

  if($result = $mysqli->query("SELECT id_user FROM uczen WHERE id_kl='$id_kl'"))
  {
	  while($row=$result->fetch_object())
	  {
		$id_user = $row->id_user;
		
		$query = "SELECT nazwisko, imie FROM users WHERE id='$id_user'";
		$tab = zapytanie($query);
		$nazwisko = $tab[0];
		
		// Polskie znaki - zmiana
		$search = array('Ś','Ł','Ź');
		$replace = array('Szz','Lzz','Nzz');
		$nazwisko = str_replace($search, $replace,$nazwisko);		
		
		$imie = $tab[1];
		
		$dane[] = $nazwisko.'; '.$imie.'; '.$id_user;
	  }
  }
  
  if(isset($dane)) sort($dane);
  
  if(isset($dane))
  {
	foreach($dane as $uczen)
	{
	
	 $lp++;
	 $uczen = explode('; ',$uczen);
	 
	 // Polskie znaki - zmiana
	 $search = array('Szz','Lzz','Nzz');
	 $replace = array('Ś','Ł','Ź');
	 $uczen[0] = str_replace($search, $replace, $uczen[0]);
	 
	 echo'<tr>';
	 echo'<td class="tooltip" title="'.$uczen[0].' '.$uczen[1].'" id="uczen">'.$lp.'</td>';
	 
	 $id_ucz = $uczen[2];
	 
	 //Miesiące
	 frek_msc($id_ucz,'09');
	 frek_msc($id_ucz,'10');
	 frek_msc($id_ucz,'11');
	 frek_msc($id_ucz,'12');
	 frek_msc($id_ucz,'01');
	 
	 //Semestr
	 frek_sem($id_ucz);

	}
  }
}

//Funkcja - frekwencja miesiąca
function frek_msc($id_ucz,$m)
{
  global $mysqli;
 
  $u = 0;
  $n = 0;
  $s = 0;
  
  if($result = $mysqli->query("SELECT data,stan FROM frekwencja WHERE id_ucz='$id_ucz'"))
  {
	while($row=$result->fetch_object())
	{
	   $data = $row->data;
	   $termin = date("m",strtotime($data));
	   
	   if($termin == $m)
	   {
		 $stan = $row->stan;
		 switch($stan)
		 {
		   case 'u': $u++; break;
		   case 'n': $n++; break;
		   case 's': $s++; break;
		 }
	   }
	}
	
	if($u == 0) $u = '';
	if($n == 0) $n = '';
	if($s == 0) $s = '';
	
	echo'<td>'.$u.'</td>';
	echo'<td>'.$n.'</td>';
	echo'<td id="prawy">'.$s.'</td>';
  }
   
   $u = 0;
   $n = 0;
   $s = 0;	
}

//Funkcja - frekwencja semestralna
function frek_sem($id_ucz)
{
  global $mysqli;
 
  $u = 0;
  $n = 0;
  $s = 0;
  
  if($result = $mysqli->query("SELECT data,stan FROM frekwencja WHERE id_ucz='$id_ucz'"))
  {
	while($row=$result->fetch_object())
	{
	   $stan = $row->stan;
	   
	   $data = $row->data;
	   $termin = date("m",strtotime($data));
	   
	   if($termin == '09' || $termin == '10' || $termin == '11' || $termin == '12' || $termin == '01')
	   {	   	   
		 switch($stan)
		 {
		   case 'u': $u++; break;
		   case 'n': $n++; break;
		   case 's': $s++; break;
		 }
	   }
	}
	
	echo'<td>'.$u.'</td>';
	echo'<td>'.$n.'</td>';
	echo'<td id="prawy">'.$s.'</td>';
  }
   
   $u = 0;
   $n = 0;
   $s = 0;	
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
    <div id="lista" class="zawartosc">
      <h3 id="nagRamka">ZESTAWIENIE FREKWENCJI ZA I SEMESTR - KLASA <?php echo $klasa . ' ' . $sb?></h3>
      <div id="time-2"><a href="javascript:drukuj()"><img src="image/printer.png" alt="Drukarka" title="Drukuj"></a></div>        
      <table id="zestawienie-2">
      <tr>
        <th rowspan="3" id="numer">Nr</th>
        <th colspan="3">Wrzesień</th>
        <th colspan="3">Październik</th>
        <th colspan="3">Listopad</th>
        <th colspan="3">Grudzień</th>
        <th colspan="3">Styczeń</th>
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
      <?php uczen($id_kl) ;?>
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