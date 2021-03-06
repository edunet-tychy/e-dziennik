<?php
include_once('status.php');

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
$nast = 0;

//Data
$dzis = date("Y-m-d");

//Miesiac
$msc= date("m");

$wybor=$_GET['data'];

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

//Funkcja - Klasa
function klasa($id_kl)
{
  global $mysqli;
  
  $kl = "SELECT klasa, sb FROM vklasy WHERE id_kl='$id_kl'";
  
  if(!$zapytanie = $mysqli->query($kl)){
	echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	$mysqli->close();
  }

  $wynik = $zapytanie->fetch_row();
  $klasa = $wynik[0];	
  $sb = $wynik[1];
  
  $tab = $klasa .' '. $sb;
  
  return $tab;
}

//Funkcja - miesiąc
function msc($msc)
{
  switch($msc)
  {
	case '01': $miesiac = 'Styczeń';
	  break;
	case '02': $miesiac = 'Luty';
	  break;
	case '03': $miesiac = 'Marzec';
	  break;
	case '04': $miesiac = 'Kwiecień';
	  break;
	case '05': $miesiac = 'Maj';
	  break;
	case '06': $miesiac = 'Czerwiec';
	  break;
	case '07': $miesiac = 'Lipiec';
	  break;
	case '08': $miesiac = 'Sierpień';
	  break;
	case '09': $miesiac = 'Wrzesień';
	  break;
	case '10': $miesiac = 'Październik';
	  break;
	case '11': $miesiac = 'Listopad';
	  break;
	case '12': $miesiac = 'Grudzień';
	  break;					
  }
  return $miesiac;
}

//Funkcja - kalendarz
function kal($msc)
{
  $mn = msc($msc);	
   switch($mn)
  {
	case 'Styczeń': $miesiac = '01';
	  break;
	case 'Luty': $miesiac = '02';
	  break;
	case 'Marzec': $miesiac = '03';
	  break;
	case 'Kwiecień': $miesiac = '04';
	  break;
	case 'Maj': $miesiac = '05';
	  break;
	case 'Czerwiec': $miesiac = '06';
	  break;
	case 'Lipiec': $miesiac = '07';
	  break;
	case 'Sierpień': $miesiac = '08';
	  break;
	case 'Wrzesień': $miesiac = '09';
	  break;
	case 'Październik': $miesiac = '10';
	  break;
	case 'Listopad': $miesiac = '11';
	  break;
	case 'Grudzień': $miesiac = '12';
	  break;					
  }
  return $miesiac;
}

//Funkcja - Uczniowie
function uczniowie($id_kl)
{
  global $mysqli;
  
  if($result = $mysqli->query("SELECT id_user FROM uczen WHERE id_kl='$id_kl'"))
  {
	if($result->num_rows > 0)
	{
	  $nr=0;
	  while($row=$result->fetch_object())
	  {
		$id_user = $row->id_user;
		  
		if($result2 = $mysqli->query("SELECT nazwisko, imie FROM users WHERE id='$id_user'"))
		{
		  if($result2->num_rows > 0)
		  {
			while($row2=$result2->fetch_object())
			{
			  $nazwisko = $row2->nazwisko;
			  
			  // Polskie znaki - zmiana
			  $search = array('Ś','Ł','Ź');
			  $replace = array('Szz','Lzz','Nzz');
			  $nazwisko = str_replace($search, $replace,$nazwisko);			  
			  
			  $imie = $row2->imie;
			  
			  $dane[] = $nazwisko.' '.$imie.'; '.$id_user;
			}
		  }
		}
	  }
	}
  }
  
  if(isset($dane))
  {
	sort($dane);
	return $dane;	  
  }
}

//Funkcja - prezentacja obecności w tabeli
function dane($id_kl)
{ 
  global $wybor;
  global $nast;
  $frek = uczn_fr($id_kl,$wybor);
  
  if(isset($frek))
  foreach($frek as $kiedy)
  {
	foreach($kiedy as $zaj)
	{
	  $zaj = explode('; ', $zaj);
	  $dt = date("w",strtotime($zaj[0]));
	  $user = $zaj[1];
	  $godz = $zaj[2];
	  $stan = $zaj[3];
	  
	  $poz[] = $stan.'; '.$user.'-'.$dt.'-'.$godz;
	}
  }

  $dane = uczniowie($id_kl);
  $nr = 0;
  $wynik = '';

  if(isset($dane))
  {
	$user = count($dane);
	
	foreach ($dane as $uczen)
	{
		$uczen = explode('; ', $uczen);
		
		$nr++;
		$ile=0;
		
		echo'<tr>';

		if ($nr == 5 || $nr == 10  || $nr == 15 ||  $nr == 20 ||  $nr == 25 ||  $nr == 30 || $nr == $user)
		{		
		  
		  // Polskie znaki - zmiana
		  $search = array('Szz','Lzz','Nzz');
		  $replace = array('Ś','Ł','Ź');
		  $uczen[0] = str_replace($search, $replace, $uczen[0]);
	  
		  echo'<td id="gr-5">'.$nr.'</td><td class="opis-2" id="gr-2">'.$uczen[0].'</td>';
	
		  $n = 0;
		  $u = 0;
		  $s = 0;
	
		  //dni 1=pn; 2=wt, 3=sr, 4=cz, 5=pt
		  for($i = 1; $i <= 5; $i++)
		  {
			for($j = 0; $j <= 9; $j++)//lekcja od 0 do 9
			{
			  //Pozycja frekwencji w tabeli
			  $kol = $uczen[1].'-'.$i.'-'.$j;
			  
			  if(isset($poz))
			  foreach($poz as $pz)
			  {
				$pz = explode('; ', $pz);
				
				if($kol == $pz[1])
				{
				 $nast++;
				 $wynik = $pz[0];
				 
				 if($pz[0] == 'n')
				 {
					 $n++;
				 } elseif ($pz[0] == 'u')
				 {
					 $u++;
				 } elseif ($pz[0] == 's')
				 {
					 $s++;
				 }
				 
				 echo'<input type="hidden" name="dane'.$nast.'" value="'.$pz[1].'">';
				 
				 break;
				} else {
				 $wynik = '';
				}
				
			  }

				if($j==9)
				{
				  if($wynik == '')
				  {
					  echo'<td id="gr-3"><input class="ob-p" type="text" name="'.$kol.'" size="1" value="'.$wynik.'" maxlength="0"></td>'; 
				  } else {
					  echo'<td id="gr-3"><input class="ob" type="text" name="'.$kol.'" size="1" value="'.$wynik.'" maxlength="1"></td>'; 
				  }  
				} else {
				  if($wynik == '')
				  {
					 echo'<td id="gr-2"><input class="ob-p" type="text" name="'.$kol.'" size="1" value="'.$wynik.'" maxlength="0"></td>';
				  } else {
					 echo'<td id="gr-2"><input class="ob" type="text" name="'.$kol.'" size="1" value="'.$wynik.'" maxlength="1"></td>';
				  }
				}
			}
		  }
		  
		  echo'<td class="gr-2m">'.$n.'</td>';
		  echo'<td class="gr-2m">'.$u.' </td>';
		  echo'<td class="gr-3m">'.$s.'</td>';
		  echo'</tr>';
		  
		} else {

		  // Polskie znaki - zmiana
		  $search = array('Szz','Lzz','Nzz');
		  $replace = array('Ś','Ł','Ź');
		  $uczen[0] = str_replace($search, $replace, $uczen[0]);

		  echo'<td id="gr-4">'.$nr.'</td><td class="opis-2">'.$uczen[0].'</td>';
	
		  $n = 0;
		  $u = 0;
		  $s = 0;
	
		  //dni 1=pn; 2=wt, 3=sr, 4=cz, 5=pt
		  for($i = 1; $i <= 5; $i++)
		  {
			for($j = 0; $j <= 9; $j++)//lekcja od 0 do 9
			{
			  //Pozycja frekwencji w tabeli
			  $kol = $uczen[1].'-'.$i.'-'.$j;
			  
			  if(isset($poz))
			  foreach($poz as $pz)
			  {
				$pz = explode('; ', $pz);
				
				if($kol == $pz[1])
				{
				 $nast++;
				 $wynik = $pz[0];
				 
				 if($pz[0] == 'n')
				 {
					 $n++;
				 } elseif ($pz[0] == 'u')
				 {
					 $u++;
				 } elseif ($pz[0] == 's')
				 {
					 $s++;
				 }
				 
				 echo'<input type="hidden" name="dane'.$nast.'" value="'.$pz[1].'">';
				 
				 break;
				} else {
				 $wynik = '';
				}
				
			  }

				if($j==9)
				{
				  if($wynik == '')
				  {
					echo'<td id="gr"><input class="ob-p" type="text" name="'.$kol.'" size="1" value="'.$wynik.'" maxlength="0"></td>';
				  } else {
					echo'<td id="gr"><input class="ob" type="text" name="'.$kol.'" size="1" value="'.$wynik.'" maxlength="1"></td>';
				  }   
				} else {
				  if($wynik == '')
				  {
					echo'<td><input class="ob-p" type="text" name="'.$kol.'" size="1" value="'.$wynik.'" maxlength="0"></td>';  
				  } else {
					echo'<td><input class="ob" type="text" name="'.$kol.'" size="1" value="'.$wynik.'" maxlength="1"></td>';  
				  }
				}
			  
			}
		  }
		  
		  echo'<td class="suma">'.$n.'</td>';
		  echo'<td class="suma">'.$u.' </td>';
		  echo'<td class="suma-2">'.$s.'</td>';
		  echo'</tr>';

		}
	}	  
  }


}

//Funkcja - Uczen i jego frekwencja
function uczn_fr($id_kl,$wybor)
{
  global $mysqli;
  
  if(!isset($kiedy))
  {
	$kiedy = daty($wybor);
	
	if($result = $mysqli->query("SELECT id_user FROM uczen WHERE id_kl='$id_kl'"))
	{
	  if($result->num_rows > 0)
	  {
		$nr=0;
		
		while($row=$result->fetch_object())
		{
		  $id_user = $row->id_user;
		  
		  foreach($kiedy as $dzien)
		  { 
			$pom = frek($id_user, $dzien);
			if(isset($pom)) $dane[] = $pom;
		  }
		}
	  }
	}
  }
  
  if(isset($dane))sort($dane);
  if(isset($dane))return $dane;
}

//Funkcja - Interfejs obecnosc
function inter_frek($id_kl,$wybor)
{
  $frek = uczn_fr($id_kl,$wybor);

  foreach($frek as $kiedy)
  {
	foreach($kiedy as $zaj)
	{
	  $zaj = explode('; ', $zaj);
	  $dt = date("w",strtotime($zaj[0]));
	  $user = $zaj[1];
	  $godz = $zaj[2];
	  $stan = $zaj[3];
	}
  }
}

//Funkcja - Daty
function daty($wybor)
{

//Zmienne
  $rok = substr($wybor,0,4);
  $miesiac =  substr($wybor,5,2);
  $dzien = substr($wybor,8,2);
	
  $dzienTygodnia = date("w",strtotime($wybor));

  $aktualnyMiesiac = date("n");
  $roznica = $miesiac - $aktualnyMiesiac;
  $ileDniMiesiaca = date('t', strtotime($roznica.' month'));
  
  $wstecz = $dzien;
  $wprzod = $dzien;
  
  for($i=1; $i <= 5; $i++)
  {
	if($i < $dzienTygodnia)
	{
	  $wstecz = $wstecz - 1;
	  if($wstecz > 0)
	  {
		$wstecz = przelacznik($wstecz);
		$ef[] = $rok.'-'.$miesiac.'-'.$wstecz;
	  }
	} elseif($i == $dzienTygodnia){
	  $ef[] = $rok.'-'.$miesiac.'-'.$dzien;
	}elseif($i > $dzienTygodnia) {
	  $pom = $i - $dzienTygodnia;
	  $wprzod = $wprzod + 1;
	  $wprzod =  przelacznik($wprzod);
	  
	  if($wprzod <= $ileDniMiesiaca)
	  {
		$ef[] = $rok.'-'.$miesiac.'-'.$wprzod;
	  } else {
		 $ef[] = $rok.'-'.$miesiac.'-'.$wprzod; 
	  }
	}
  }
 
 if(isset($ef))
 {
  sort($ef);
  return $ef;
 }
}

//Funkcja - Frekwencja pobrana z bazy
function frek($id_ucz, $dzien)
{
  global $mysqli;
  if($result = $mysqli->query("SELECT godzina,stan FROM frekwencja WHERE id_ucz='$id_ucz' AND data='$dzien' AND stan !='o'"))
  {
	while($row=$result->fetch_object())
	{
	  
	  $godzina = $row->godzina;
	  $stan = $row->stan;
	  
	  $frek_ucz[] = $dzien.'; '.$id_ucz.'; '.$godzina.'; '.$stan;
	}
  }
  if(isset($frek_ucz))
  {
	  sort($frek_ucz);
  }
  if(isset($frek_ucz))return $frek_ucz;
}

//Funkcja - aktualny tydzień
function br($dn)
{
  global $wybor;
  
  $dzienTygodnia = date("w",strtotime($wybor));
  $dzien = substr($wybor,8,2);
  $miesiac =  substr($wybor,5,2);
  
  $aktualnyMiesiac = date("n");
  $roznica = $miesiac - $aktualnyMiesiac;
  $ileDniMiesiaca = date('t', strtotime($roznica.' month'));
  
  switch($dn){
    case 1 : $nazwa = "Poniedziałek";break;
    case 2 : $nazwa = "Wtorek";break;
    case 3 : $nazwa = "Środa";break;
    case 4 : $nazwa = "Czwartek";break;
    case 5 : $nazwa = "Piątek";break;
	case 6 : $nazwa = "Sobota";break;
	case 7 : $nazwa = "Niedziela";break;
  }
  
  if($dzienTygodnia < $dn)
  {
	  $pom = $dn - $dzienTygodnia;
	  $dzien = $dzien + $pom;
  } elseif ($dzienTygodnia > $dn) {
	  $pom = $dzienTygodnia - $dn;
	  $dzien = $dzien - $pom;
  }

  $dzien = przelacznik($dzien);

  if($dzien <= $ileDniMiesiaca)
  {
   $data = $nazwa.'  '.$dzien.'/'.kal($miesiac);
  } else {
	 $data = '';
  }
  
  if ($dzien < 1)
  {
	$data = ' ';
  }
  
 return $data;
}

//Funkcja - Przełącznik
function przelacznik($li)
{	
  switch($li){
    case 1 : $nazwa = "01";break;
    case 2 : $nazwa = "02";break;
    case 3 : $nazwa = "03";break;
    case 4 : $nazwa = "04";break;
    case 5 : $nazwa = "05";break;
    case 6 : $nazwa = "06";break;
	case 7 : $nazwa = "07";break;
	case 8 : $nazwa = "08";break;
	case 9 : $nazwa = "09";break;
	default: $nazwa = $li;
  }	
  return $nazwa;
}

//Funkcja - Dni Tygodnia
function dniTygodnia($dn)
{
  switch($dn){
    case 1 : $nazwa = "poniedziałek";break;
    case 2 : $nazwa = "wtorek";break;
    case 3 : $nazwa = "Środa";break;
    case 4 : $nazwa = "Czwartek";break;
    case 5 : $nazwa = "Piątek";break;
	case 6 : $nazwa = "Sobota";break;
	case 7 : $nazwa = "Niedziela";break;
  }
  
  if(isset($nazwa))
  return $nazwa;
}


//Funkcja - Wybór daty
function wybData($wybor)
{

//Zmienne
$rok = substr($wybor,0,4);
$miesiac =  substr($wybor,5,2);
$dzien = substr($wybor,8,2);

$dzienTygodnia = date("w",strtotime($wybor));

$aktualnyMiesiac = date("n");
$roznica = $miesiac - $aktualnyMiesiac;
$ileDniMiesiaca = date('t', strtotime($roznica.' month'));

$wstecz = $dzien;
$wprzod = $dzien;

  for($i=1; $i <= 5; $i++)
  {
	if($i < $dzienTygodnia)
	{
	  $wstecz = $wstecz - 1;
	  if($wstecz > 0)
	  {
		$wstecz = przelacznik($wstecz);
		$ef[] = $rok.'-'.$miesiac.'-'.$wstecz;
	  }
	} elseif($i == $dzienTygodnia){
	  $ef[] = $rok.'-'.$miesiac.'-'.$dzien;
	}elseif($i > $dzienTygodnia) {
	  $pom = $i - $dzienTygodnia;
	  $wprzod = $wprzod + 1;
	  $wprzod =  przelacznik($wprzod);
	  
	  if($wprzod <= $ileDniMiesiaca)
	  $ef[] = $rok.'-'.$miesiac.'-'.$wprzod;
	}
  }
  sort($ef);
  return $ef;
}

$info = msc(substr($wybor,5,2));
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_02.js"></script>
<script type="text/javascript" src="javascript/jquery-1.js"></script>
<script type="text/javascript" src="javascript/jquery-ui-1.js"></script>
<link href="styl/jquery-ui-1.css" rel="stylesheet" type="text/css">
<link href="styl/styl.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.scrollTo(0, 200)">
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
  <h3 id="nagRamka">STAN OBECNOŚCI KLASY</h3>
  
<?php

  echo '<div class="lewy-2">';
  echo '<p class="termin" id="'.$_GET['data'].'">Wybierz datę: ';
  echo '<input type="text" id="data" size="15" class="pole-center" name="data" value="'.$_GET['data'].'">';
  echo '</div>';
  echo '<form action="db_frekwencja_upd.php" method="post" name="formFrek" id="formFrek">';
  echo '<div class="prawy-2"><div id="zapis"></div>';
  echo '<input type="button" value="Zapisz stan obecności" class="button" id="zapiszFrek">';
  echo '</div>';
  echo '<div id="frek-2">';
  if($_GET['data'] == $dzis)
  {
	echo'<h3 id="nagRamka4">AKTUALNY TYDZIEŃ</h3>';
  } else {
	echo'<h3 id="nagRamka4">'.mb_strtoupper($info,"UTF-8").' '.substr($wybor,0,4).'</h3>'; 
  }
  
  echo'<table class="obecnosc">';
  echo'<tr><th rowspan="3" class="nr">Lp</td><th rowspan="3" class="opis">Nazwisko i imię</td></tr>';
  echo'<tr>';

  echo'<th colspan="10">'.br(1).'</td>';
  echo'<th colspan="10">'.br(2).'</td>';
  echo'<th colspan="10">'.br(3).'</td>';
  echo'<th colspan="10">'.br(4).'</td>';
  echo'<th colspan="10">'.br(5).'</td>';
  echo'<th colspan="3">Suma</td>';

  echo'</tr>';
  echo'<tr>';

  for($i=0; $i<5; $i++)
  {
    for($j=0; $j<10; $j++)
    {
      echo'<th>'.$j.'</th>';
    }
  }

  echo'<th class="nr">N</th>';
  echo'<th class="nr">U</th>';
  echo'<th class="nr">S</th>';
  echo'</tr>';
  dane($id_kl);
  echo'</table>';
  echo'<input type="hidden" name="id_kl" value="'.$id_kl.'">';
  echo'<input type="hidden" name="data" value="'.$_GET['data'].'">';
  echo'<input type="hidden" name="ile" value="'.$nast.'" id="il">';
  echo '</form>';
  echo '</div>';
?>
  <!-- Informacje dla użytkownika -->
  <div class="left-2">
  <h2 class="frek">ZADANIE FORMULARZA:</h2>
  <p class="frek">Formularz zezwala wychowawcy na wprowadzenie zmian w zakresie usprawiedliwiania nieobecności lub zmianę kwalifikacji spóźnień.</p>
    <h2 class="frek">WPISY OBOWIĄZUJACE W DZIENNIKU:</h2>
    <p class="frek">Znaczenie symboli:</p>
    <ul class="frek">
    <li>o - obecny</li>
    <li>u - nieobecny usprawiedliwiony</li>
    <li>n - nieobecny nieusprawiedliwiony</li>
    <li>s - spóźniony</li>
    </ul>
    <br><br>
  </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>