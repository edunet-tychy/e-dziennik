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
<script type="text/javascript" src="javascript/script_03.js"></script>
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
  if(isset($przed)) return $przed;
}

//Funkcja - uczniowie klasy
function uczen($id_kl,$nr,$przed)
{
  global $mysqli;
  
  $lp = 0;
  $oc6 = 0;
  $oc5 = 0;
  $oc4 = 0;
  $oc3 = 0;
  $oc2 = 0;
  $oc1 = 0;
  $ile_oc = 0;
  $iloraz = 0;
  $sr = 0;
  
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
	 echo'<td  class="tooltip" title="'.$uczen[0].' '.$uczen[1].'" id="lewy">'.$lp.'</td>';

	  $query = "SELECT zach FROM zach_rok WHERE id_user='$uczen[2]'";
	  $tab = zapytanie($query);
	  $zach = $tab[0];

	   switch($zach)
	   {
		 case 6: $stan='Wzorowe'; break;
		 case 5: $stan='Bardzo dobre'; break;
		 case 4: $stan='Dobre'; break;
		 case 3: $stan='Poprawne'; break;
		 case 2: $stan='Nieodpowiednie'; break;
		 case 1: $stan='Naganne'; break;
		 default: $stan='';break;
	   }

	 echo'<td class="zach-2">'.$stan.'</td>';

	 if(isset($przed))
	 {	 
	   foreach($przed as $prz)
	   {
		  $query = "SELECT sem FROM ocen_rok WHERE id_user='$uczen[2]' AND id_przed='$prz'";
		  $tab = zapytanie($query);
		  $ocena = $tab[0];
		  
		  echo'<td>'.$ocena.'</td>';
		  
		  switch($ocena)
		  {
			  case 6: $oc6++; break;
			  case 5: $oc5++; break;
			  case 4: $oc4++; break;
			  case 3: $oc3++; break;
			  case 2: $oc2++; break;
			  case 1: $oc1++; break;
		  }
		
	   }
	 }
	 
	 //Prezentacja ilości ocen
	 for($i=6; $i >= 1; $i--)
	 {
	  switch($i)
	  {
		  case 6: echo'<td id="l_str">'.$oc6.'</td>'; break;
		  case 5: echo'<td>'.$oc5.'</td>'; break;
		  case 4: echo'<td>'.$oc4.'</td>'; break;
		  case 3: echo'<td>'.$oc3.'</td>'; break;
		  case 2: echo'<td>'.$oc2.'</td>'; break;
		  case 1: echo'<td>'.$oc1.'</td>'; break;
	  }
	  
	  $ile_oc = $oc6 + $oc5 + $oc4 + $oc3 + $oc2 + $oc1;
	  $iloraz = $oc6*6 + $oc5*5 + $oc4*4 + $oc3*3 + $oc2*2 + $oc1;
	  if($iloraz > 0)
	  {
		  $sr = $iloraz/$ile_oc;
		  $sr = number_format($sr, 2, '.', '');
	  }
	 }
	
	//Resestowanie sumowania ocen
	  $oc6 = 0;
	  $oc5 = 0;
	  $oc4 = 0;
	  $oc3 = 0;
	  $oc2 = 0;
	  $oc1 = 0;
 
	  $query = "SELECT count(stan) FROM frekwencja WHERE stan='u' AND id_ucz='$uczen[2]' AND (MONTH(data) < 7 AND MONTH(data) > 1);";
	  $tab = zapytanie($query);
	  $usp = $tab[0];
	  
	  echo'<td id="l_str">'.$usp.'</td>';

	  $query = "SELECT count(stan) FROM frekwencja WHERE stan='n' AND id_ucz='$uczen[2]' AND (MONTH(data) < 7 AND MONTH(data) > 1)";
	  $tab = zapytanie($query);
	  $nusp = $tab[0];
	  
	  echo'<td>'.$nusp.'</td>';

	  $query = "SELECT count(stan) FROM frekwencja WHERE stan='s' AND id_ucz='$uczen[2]' AND (MONTH(data) < 7 AND MONTH(data) > 1)";
	  $tab = zapytanie($query);
	  $sp = $tab[0];
	  
	  echo'<td id="l_str">'.$sp.'</td>';
	  
	  echo'<td id="p_l_str">'.$sr.'</td>';
	 
	 echo'</tr>';
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
    <div id="lista" class="zawartosc">
      <h3 id="nagRamka">ZESTAWIENIE OCEN ROCZNYCH - KLASA <?php echo $klasa . ' ' . $sb?></h3>
      <div id="time-2"><a href="javascript:drukuj()"><img src="image/printer.png" alt="Drukarka" title="Drukuj"></a></div>
      <table id="zestawienie">
      <tr>
      <th rowspan="2" id="nr">Nr</th>
      <th rowspan="2" class="zach">Zachowanie</th>
      <th colspan="<?php echo $nr-1 ;?>">Nazwa przedmiotu</th>
      <th colspan="6">Liczba ocen</th>
      <th colspan="2">Liczba<br>opuszcz.<br>godz.</th>
      <th rowspan="2" title="Spóźnienia" class="ng">Sp.</th>
      <th rowspan="2" title="Średnia" class="ng">ŚR.</th>
      </tr>
      <tr>
        <?php $przed = przedmioty($id_kl); ?>
        <th class="ng" title="Celujących">6</th>
        <th class="ng" title="Bardzo dobrych">5</th>
        <th class="ng" title="Dobrych">4</th>
        <th class="ng" title="Dostatecznych">3</th>
        <th class="ng" title="Dopuszczających">2</th>
        <th class="ng" title="Niedostatecznych">1</th>
        <th class="ng" title="Usprawiedliwionych">U</th>
        <th class="ng" title="Nieusprawiedliwionych">N</th>
      </tr>
      <?php if(isset($przed)) uczen($id_kl,$nr,$przed); ?>
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