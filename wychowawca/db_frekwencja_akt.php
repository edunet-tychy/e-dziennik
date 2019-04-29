<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript">
$(document).ready(function()
{
  //Zazanaczenie obecności
  $(".ob").click(function()
  {
	$(this).select();
  });
  
  //Aktywne pole
  //$(".ob:first").focus();
  
  //Reakcja na błąd
  $(".ob").change(function()
  {
	$(this).select();
	
	var pole = $(this).val();
	
	switch (pole) {
		case 'O': $(this).val('o'); pole = $(this).val(); break;
		case 'U': $(this).val('u'); pole = $(this).val(); break;
		case 'N': $(this).val('n'); pole = $(this).val(); break;
		case 'S': $(this).val('s'); pole = $(this).val(); break;
	}
	
	if(pole != 'o' && pole != 'u' && pole != 'n' && pole != 's')
	{
		$(this).css({"background": "red", "color": "#FFF"});
	} else {
		$(this).css({"background": "#B0DEFF", "color": "#000"});
	}

  });
  
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

//Zmienne
$id_kl = $_SESSION['id_kl'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$klasa = $_SESSION['klasa'];
$sb = $_SESSION['sb'];
$nast = 0;
//Miesiac
$msc= date("m");
//Data
$dzis = date("Y-m-d");

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
	  $dzien;
	  
	  $frek_ucz[] = $dzien.'; '.$id_ucz.'; '.$godzina.'; '.$stan;
	}
  }
  if(isset($frek_ucz))
  {
	  sort($frek_ucz);
  }
  if(isset($frek_ucz))return $frek_ucz;
}

//Funkcja - Przełącznik dla funkcji Daty
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
		 $ef[] = $rok.'-'.$miesiac.'-'.$ileDniMiesiaca; 
	  }
	  
	}
  }
 
 if(isset($ef))
 {
  sort($ef);
  return $ef;
 }
}

//Funkcja - miesiące słownie
function msc($msc)
{
  switch($msc)
  {
	case '1': $miesiac = 'Styczeń';
	  break;
	case '2': $miesiac = 'Luty';
	  break;
	case '3': $miesiac = 'Marzec';
	  break;
	case '4': $miesiac = 'Kwiecień';
	  break;
	case '5': $miesiac = 'Maj';
	  break;
	case '6': $miesiac = 'Czerwiec';
	  break;
	case '9': $miesiac = 'Wrzesień';
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

//Funkcja - miesiac podany słownie na dwa znaki
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

//Funkcja - Uczen i jego frekwencja
function uczn_fr($id_kl,$dzis)
{
  global $mysqli;
  
  if(!isset($kiedy))
  {  
	$kiedy = daty($dzis);
	
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
function inter_frek($id_kl,$dzis)
{
  $frek = uczn_fr($id_kl,$dzis);

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

//Funkcja - prezentacja obecności w tabeli
function dane($id_kl)
{ 
  global $dzis;
  global $nast;
  $frek = uczn_fr($id_kl,$dzis);
  
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
		
		// Polskie znaki - zmiana
		$search = array('Szz','Lzz','Nzz');
		$replace = array('Ś','Ł','Ź');
		$uczen[0] = str_replace($search, $replace, $uczen[0]);		
		
		$nr++;
		$ile=0;
		
		echo'<tr>';
		
		if ($nr == 5 || $nr == 10  || $nr == 15 ||  $nr == 20 ||  $nr == 25 ||  $nr == 30 || $nr == $user)
		{
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

//Funkcja - aktualny tydzień
function br($dn)
{
  $dzienTygodnia = date("w");
  $dzien = date("j");
  $miesiac = date("n");
  $dniwMiesiacu =  date("t");
  
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
  
  if($dzien <= $dniwMiesiacu && $dzien > 0)
  {
	 if($dzien < 10) {$dzien = przelacznik($dzien);};
   $data = $nazwa.'  '.$dzien.'/'.kal($miesiac);
   return $data;
  }
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

echo'<h3 id="nagRamka4">AKTUALNY TYDZIEŃ</h3>';
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
echo'<input type="hidden" name="data" value="'.$dzis.'">';
echo'<input type="hidden" name="ile" value="'.$nast.'" id="il">';
echo'</table>';
?>
<!-- Informacje dla użytkownika -->
<div class="left-2">
  <h2 class="frek">ZADANIE FORMULARZA:</h2>
  <p class="frek">Formularz zezwala wychowawcy na wprowadzenie zmian w zakresie usprawiedliwiania nieobecności lub zmianę kwalifikacji spóźnień.</p>
  <h2 class="frek">WPISY OBOWIĄZUJACE W DZIENNIKU:</h2>
  <p class="frek">Znaczenie symboli:</p>
  <ul class="frek">
  <li>o - obecny (nie jest widoczny w arkuszu)</li>
  <li>u - nieobecny usprawiedliwiony</li>
  <li>n - nieobecny nieusprawiedliwiony</li>
  <li>s - spóźniony</li>
  </ul>
  <br><br>
</div>
</body>
</html>