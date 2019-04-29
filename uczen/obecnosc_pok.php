<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Klasy
include_once('../class/konto.class.php');

//Zmienne
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$id = $_SESSION['id_db'];

//Miesiac
$msc= $_GET['msc'];

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

$query = "SELECT id_kl FROM uczen WHERE id_user='$id'";
$tab = zapytanie($query);
$id_kl = $tab[0];

$query = "SELECT klasa, sb FROM vklasy WHERE id_kl='$id_kl'";
$tab = zapytanie($query);
$klasa = $tab[0];
$sb = $tab[1];

//Funkcja - uzupełnia tablicę z obecnościami
function uzup_tab($tabs)
{
  for($i=0; $i<11; $i++)
  {
	if (!isset($tabs[$i]))
	{
	 $tabs[$i] = '';
	}
  }
  return $tabs;
}

//Funkcja - Pokaz frekwencji
function pokaz($tabs,$data,$u,$n,$s)
{
  $tb = uzup_tab($tabs);
  $suma = $u + $n;
  $day = date("l",strtotime($data));
  $dzien = dni_tyg($day);
  echo'<tr>';		  
  echo'<td title="'.$dzien.'" id="dzien"> '.$data.'</td>';
  for($j=0; $j<11; $j++)
  {
	  echo'<td>'.$tb[$j].'</td>';
  }
  echo'<td>'.$n.'</td>';
  echo'<td>'.$u.'</td>';
  echo'<td>'.$suma.'</td>';
  echo'<td>'.$s.'</td>';
  echo'</tr>';	
}

//Funkcja - Dzień tygodnia
function dni_tyg($day)
{
  switch($day)
  {
	case 'Monday': $dzien = 'Poniedziałek';
	  break;
	case 'Tuesday': $dzien = 'Wtorek';
	  break;
	case 'Wednesday': $dzien = 'Środa';
	  break;
	case 'Thursday': $dzien = 'Czwartek';
	  break;
	case 'Friday': $dzien = 'Piątek';
	  break;
	case 'Saturday': $dzien = 'Sobota';
	  break;
	case 'Sunday': $dzien = 'Niedziela';
	  break;					
  }
  return $dzien;
}

//Funkcja - miesiąc
function msc($msc)
{
  switch($msc)
  {
	case '0': $miesiac = 'Brak miesiąca';
	  break;
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

if($result = $mysqli->query("SELECT data,godzina,stan FROM frekwencja WHERE month(data)='$msc' AND id_kl='$id_kl' AND id_ucz='$id' AND stan != 'o' ORDER BY data DESC,godzina"))
{
  if($result->num_rows > 0)
  {
	$pom = '';
	$nr=0;
	$s=0;
	$n=0;
	$u=0;
	echo '<h3 id="nagRamka5">'.mb_strtoupper(msc($msc),"UTF-8").'</h3>';
	echo'<table id="plan-ob">';
	echo'<tr>';
	echo'<th rowspan="2">Data</th>';
	echo'<th colspan="11">Nr lekcji</th>';
	echo'<th colspan="3">Nieobecność</th>';
	echo'<th rowspan="2" class="opis">Sp.</th>';
	echo'</tr>';
	echo'<tr>';
	echo'<th class="nr-2">0</th>';
	echo'<th class="nr-2">1</th>';
	echo'<th class="nr-2">2</th>';
	echo'<th class="nr-2">3</th>';
	echo'<th class="nr-2">4</th>';
	echo'<th class="nr-2">5</th>';
	echo'<th class="nr-2">6</th>';
	echo'<th class="nr-2">7</th>';
	echo'<th class="nr-2">8</th>';
	echo'<th class="nr-2">9</th>';
	echo'<th class="nr-2">10</th>';
	echo'<th class="ucz" title="Nieobecność nieusprawiedliwiona">N</th>';
	echo'<th class="ucz"title="Nieobecność usprawiedliwiona">U</th>';
	echo'<th class="ucz">Suma</th>';
	echo'</tr>';
	
	while($row=$result->fetch_object())
	{
		$data = $row->data;
		$godz = $row->godzina;
		$stan = $row->stan;
		
		if($pom == '')
		{
		  $pom=$data;
		}
		
		if($pom == $data)
		{
		  $tabs[$godz] = $stan;
		  switch($stan)
		  {
			case 'u': $u++;
			  break;
			case 'n': $n++;
			  break;
			case 's': $s++;
			  break;					
		  }
		} else {
		  pokaz($tabs,$pom,$u,$n,$s);
		  unset($tabs);
		  $s=0;
		  $n=0;
		  $u=0;
		  $pom=$data;
		  $tabs[$godz] = $stan;
		  switch($stan)
		  {
			case 'u': $u++;
			  break;
			case 'n': $n++;
			  break;
			case 's': $s++;
			  break;					
		  }
		}
	}
  
	//Ostatnia data w bazie
	pokaz($tabs,$data,$u,$n,$s);
	echo'</table>';
  }else {
	echo '<h3 id="nagRamka5">'.mb_strtoupper(msc($msc),"UTF-8").'</h3>';
    echo '<p id="baza">Brak rekordów w bazie</p>';
  }
}else {
echo 'Błąd: ' . $mysqli->error;
}