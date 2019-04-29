<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_01.js"></script>
<link href="styl/styl_uczen.css" rel="stylesheet" type="text/css">
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<link href="styl/print_oc.css" rel="stylesheet" type="text/css" media="print">
<script type="text/javascript">
function drukuj(){
 // sprawdź możliwości przeglądarki
   if (!window.print){
      alert("Twoja przeglądarka nie drukuje!")
   return 0;
   }
 alert("Ustaw wydruk pionowy");
 window.print(); // jeśli wszystko ok drukuj
}
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

//Zmienne
$id_kl = $_SESSION['id_kl'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$klasa = $_SESSION['klasa'];
$sb = $_SESSION['sb'];
$id = $_GET['id_ucz'];

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

//Funkcja - Zapytania
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

//Imię i nazwisko ucznia
$query = "SELECT imie, nazwisko FROM users WHERE id='$id'";
$tab = zapytanie($query);
$imieU = $tab[0];
$nazwiskoU = $tab[1];

//Funkcja - ID Przedmioty klasy
function id_przedmiot($id_kl)
{
  global $mysqli;
  
  if($result = $mysqli->query("SELECT * FROM klasy_przedmioty WHERE id_kl='$id_kl'"))
  {
	while($row=$result->fetch_object())
	{
	  $id_przed[] = $row->id_przed;		
	}
  }
  return $id_przed;
}

//Funkcja - Nazwa przedmiotu
function naz_przedmiot($id_kl)
{
  global $mysqli;
  $id_przed = id_przedmiot($id_kl);
  
  foreach($id_przed as $id)
  {
	  $query = "SELECT nazwa FROM przedmioty WHERE id_przed='$id'";
	  $tab = zapytanie($query);
	  $nazwa = $tab[0];
	  $przedmiot[] = $nazwa.'; '.$id;
  }
  sort($przedmiot);
  return $przedmiot;
}

//Funkcja - Oceny cząstkowe
function oceny($id,$id_przed,$id_kl)
{
  global $mysqli;
  
  if($result = $mysqli->query("SELECT * FROM oceny_cz_2 WHERE id_user='$id' AND id_przed='$id_przed' AND id_kl='$id_kl' ORDER BY poz"))
  {
	while($row=$result->fetch_object())
	{
	  $oc[] = $row->poz.'; '.$row->oc.'; '.$row->data;	
	}
  }
  if(isset($oc))
  {
	return $oc; 	  
  }
}

//Funkcja - Opis oceny cząstkowej
function opis_oc($id_przed,$id_kl)
{
  global $mysqli;
  
  if($result = $mysqli->query("SELECT poz,opis FROM oceny_op_k WHERE id_przed='$id_przed' AND id_kl='$id_kl' ORDER BY poz"))
  {
	while($row=$result->fetch_object())
	{
	  $opis[] = $row->poz.'; '.$row->opis;	
	}
  }
  if(isset($opis))
  {
	return $opis;  
  }
}

//Funkcja - Propozycja oceny semestralnej
function prop_sem($id,$id_przed,$id_kl)
{
  global $mysqli;
  
  $query = "SELECT prop, data FROM ocen_prop_rok WHERE id_user='$id' AND id_kl='$id_kl' AND id_przed='$id_przed'";
  $tab = zapytanie($query);
  $prop = $tab[0];
  $data = $tab[1];
  
  $pr = $prop.'; '.$data;
  return $pr;
}

//Funkcja - Ocena semestralna
function sem($id,$id_przed,$id_kl)
{
  global $mysqli;
  
  $query = "SELECT sem, data FROM ocen_rok WHERE id_user='$id' AND id_kl='$id_kl' AND id_przed='$id_przed'";
  $tab = zapytanie($query);
  $sm = $tab[0];
  $data = $tab[1];
  
  $sem = $sm.'; '.$data;
  return $sem;
}

//Funkcja - Interfejs Przedmioty i oceny
function int_przed($id_kl,$id)
{
  global $mysqli;
  $przedmioty = naz_przedmiot($id_kl);
  $nr = 0;

  //Przedmioty  
  foreach($przedmioty as $dane)
  {
	$dane = explode('; ', $dane);
	$nr++;
	echo'<tr>';
	echo'<td class="nr">'. $nr .'</td>';
	echo'<td>'. $dane[0] .'</td>';

	//Oceny	cząstkowe
	$oceny = oceny($id,$dane[1],$id_kl);
	$opisy = opis_oc($dane[1],$id_kl);
	
	echo'<td class="oceny">';
if(isset($oceny))
	{
	  foreach($oceny as $ocena)
	  {
		$info='Brak opisu';
		$oc = explode('; ', $ocena);
		
		if (isset($opisy)) {
		  foreach($opisy as $opis)
		  {
			$wynik = explode('; ', $opis);
			$poz = $id.'-'.$wynik[0];
			
			if ($oc[0] == $poz) {
			  $info = $wynik[1];
			}
		  }			
		}
		
		echo'<a class="linki-3" href="#" title="Data wpisu: '.$oc[2].'&#10;Opis oceny: '.$info.'">'.$oc[1].'</a> ';
	  }		
	} else {
		echo '---';
	}
	echo'</td>';

	//Propozycja oceny semestralnej		
	echo'<td class="sem">';
	$prop = prop_sem($id,$dane[1],$id_kl);
	if(isset($prop))
	{
	  $pr = explode('; ', $prop);
	  echo '<a class="linki-3" href="#" title="Data wpisu: '.$pr[1].'">'.$pr[0].'</a>';
	} else {
	  echo'---';
	}
	echo'</td>';

	//Ocena semestralna	
	echo'<td class="sem">';
	$sem = sem($id,$dane[1],$id_kl);
	if(isset($prop))
	{
	  $sm = explode('; ', $sem);
	  echo '<a class="linki-3" href="#" title="Data wpisu: '.$sm[1].'">'.$sm[0].'</a>';
	} else {
	  echo'---';
	}
	echo'</td>';
	echo'</tr>';

  }
}

//Funkcja - frekwencja ucznia
function uczen($id_ucz,$mysqli)
{
	 //Miesiące
	 frek_msc($id_ucz,'02',$mysqli);
	 frek_msc($id_ucz,'03',$mysqli);
	 frek_msc($id_ucz,'04',$mysqli);
	 frek_msc($id_ucz,'05',$mysqli);
	 frek_msc($id_ucz,'06',$mysqli);
	 
	 //Semestr
	 frek_sem($id_ucz,$mysqli);
}

//Funkcja - frekwencja miesiąca
function frek_msc($id_ucz,$m,$mysqli)
{
 
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
	echo'<td>'.$s.'</td>';
  }
   
   $u = 0;
   $n = 0;
   $s = 0;	
}

//Funkcja - frekwencja semestralna
function frek_sem($id_ucz,$mysqli)
{
 
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
	   
	   if($termin == '02' || $termin == '03' || $termin == '04' || $termin == '05' || $termin == '06')
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
	echo'<td>'.$s.'</td>';
  }
   
   $u = 0;
   $n = 0;
   $s = 0;	
}

//Funkcja  - zachowanie
function zach($id,$mysqli)
{
	$query = "SELECT zach FROM zach_rok WHERE id_user='$id'";
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
	 }
	 if(isset($stan)){return "Zachowanie - ".$stan;}
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
  <div id="nawig_druk">
  <ul class="nawigacja_new">
  <li><a href="db_oceny_uczen.php" title="lista" class="zakladki" id="z_01">LISTA UCZNIÓW</a></li> 
  <li><a href="db_oceny.php?id_ucz=<?php echo $id ;?>" title="Oceny semestr I" class="zaj">Semestr I</a></li>
  <li><a href="db_oceny_k.php?id_ucz=<?php echo $id ;?>" title="Oceny semestr II" class="zaj aktywna">Semestr II</a></li>
  </ul>
  </div>
  <h3 id="nagRamka1">OCENY - SEMESTR II<div id="time"><a href="javascript:drukuj()"><img src="image/printer.png" alt="Drukarka" title="Drukuj"></a></div></h3>
  <?php
  echo'<ul class="nawigacja_new-2">';
  echo'<li><a href="#" title="uczen" class="ucz aktywna">'.$imieU.' '.$nazwiskoU.'</a></li>';
  echo'</ul>';
  echo'<table id="zachowanie">';
  echo'<tr><td>'.zach($id,$mysqli).'</td></tr>';
  echo'</table>';
  if($result = $mysqli->query("SELECT * FROM klasy_przedmioty WHERE id_kl='$id_kl'"))
  {
  //zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
    if($result->num_rows > 0)
    {
      $nr=0;
      
      echo'<table id="center-tabela-pod-2">';
      echo'<tr>';
      echo'<th>NR</th>';
      echo'<th>PRZEDMIOT</th>';
      echo'<th>OCENY</th>';
      echo'<th>Prop.</th>';
      echo'<th>Sem.</th>';
      echo'</tr>';
      int_przed($id_kl,$id);
      echo'</table><br><br>';
    }else {
      echo '<img src="image/pytanie.png" alt="Brak rekordów">';
      echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
    }
  }else {
  echo 'Błąd: ' . $mysqli->error;
  }
  ?>
  <div id="drukFrek">
  <h3 id="nagRamka6">ZESTAWIENIE FREKWENCJI ZA II SEMESTR</h3>
  <table id="zestawienie-2">
  <tr>
    <th colspan="3">Luty</th>
    <th colspan="3">Marzec</th>
    <th colspan="3">Kwiecień</th>
    <th colspan="3">Maj</th>
    <th colspan="3">Czerwiec</th>
    <th rowspan="2" colspan="3">Razem</th>
  </tr>
  <tr>
    <th colspan="15">Liczba opuszczonych lekcji</th>
  </tr>
  <tr>
    <th class="ng">u</th>
    <th class="ng">n</th>
    <th class="ng">s</th>
    <th class="ng">u</th>
    <th class="ng">n</th>
    <th class="ng">s</th>
    <th class="ng">u</th>
    <th class="ng">n</th>
    <th class="ng">s</th>
    <th class="ng">u</th>
    <th class="ng">n</th>
    <th class="ng">s</th>
    <th class="ng">u</th>
    <th class="ng">n</th>
    <th class="ng">s</th>
    <th class="ng">uspr.</th>
    <th class="ng">nieusp.</th>
    <th class="ng">spóźn.</th>
  </tr>
  <?php uczen($id,$mysqli) ;?>
  </table>
  </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>