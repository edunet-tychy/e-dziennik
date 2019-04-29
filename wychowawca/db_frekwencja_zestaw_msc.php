<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<link href="styl/styl_uczen.css" rel="stylesheet" type="text/css">
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<link href="styl/print_poz.css" rel="stylesheet" type="text/css" media="print">
<script type="text/javascript">
function drukuj(){
 // sprawdź możliwości przeglądarki
   if (!window.print){
      alert("Twoja przeglądarka nie drukuje!")
   return 0;
   }
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
$mk = $_GET['mk'];

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

//Funkcja - frekwencja miesiąca klasy
function frek_msc($id_kl,$m)
{
  global $mysqli;
 
  $u = 0;
  $n = 0;
  $o = 0;
  $s = 0;
  $ilosc = 0;
  
  if($result = $mysqli->query("SELECT stan,id_ucz FROM frekwencja WHERE id_kl='$id_kl' AND MONTH(data)='$m'"))
  {
	while($row=$result->fetch_object())
	{
		 $stan = $row->stan;
		 $id_ucz = $row->id_ucz;
		 
		 $pom[] = $id_ucz;

		 switch($stan)
		 {
		   case 'u': $u++; break;
		   case 'n': $n++; break;
		   case 'o': $o++; break;
		   case 's': $s++; break;
		 }
	}
	
	 $result2 = $mysqli->query("SELECT data FROM frekwencja WHERE id_kl='1' AND (MONTH(data)='$m') GROUP BY data");
	 while($row2=$result2->fetch_object())
	 {
		$daty[] = $row2->data;
	 }
	 
	 if (!isset($daty)) {
	  $daty = 0;
	  $ile_dni = 0;
	 } else {
	  $ile_dni = count($daty);
	 }
	 

	if($u == 0) $u = '';
	if($n == 0) $n = '';
	if($o == 0) $o = '';
	if($s == 0) $s = '';

	$ob = $o + $s;
	$suma = $u+$n;
	
	$razem = $suma + $ob;
	
	if($razem > 0)
	{
	  $procent = ($ob * 100) / $razem;
	  $procent = number_format($procent, 2, '.', '');
	}

	switch($m)
	{
		case '09': $miesiac = 'Wrzesień'; break;
		case '10': $miesiac = 'Październik'; break;
		case '11': $miesiac = 'Listopad'; break;
		case '12': $miesiac = 'Grzudzień'; break;
		case '01': $miesiac = 'Styczeń'; break;
		case '02': $miesiac = 'Luty'; break;
		case '03': $miesiac = 'Marzec'; break;
		case '04': $miesiac = 'Kwiecień'; break;
		case '05': $miesiac = 'Maj'; break;
		case '06': $miesiac = 'Czerwiec'; break;
	}
	
	if(isset($pom))
	{
	  $pom = array_unique($pom);
	  $ilosc = count($pom);
	}

	echo'<tr>';
	  echo'<td class="miesiac">'.$miesiac.'</td>';

	  //Ilość uczniów
	  if( $ilosc > 0)
	  {
		 echo'<td class="frek">'.$ilosc.'</td>'; 
	  } else {
		 echo'<td class="frek"> </td>';
	  }

	  //Razem
	  if( $razem > 0)
	  {
		 echo'<td class="frek">'.$razem.'</td>'; 
	  } else {
		 echo'<td class="frek"> </td>';
	  }

	  //Obecność
	  if( $ob > 0)
	  {
		 echo'<td class="frek">'.$ob.'</td>'; 
	  } else {
		 echo'<td class="frek"> </td>';
	  }
	  
	  //Nieobecność
	  if( $suma > 0)
	  {
		 echo'<td class="frek">'.$suma.'</td>'; 
	  } else {
		 echo'<td class="frek"> </td>';
	  }

	  //Procent	  
	  if(isset($procent))
	  {
		 echo'<td class="frek">'.$procent.'</td>'; 
	  } else {
		 echo'<td class="frek"> </td>';
	  }

	  //Ilość dni
	  if(isset($ile_dni))
	  {
		 echo'<td class="frek">'.$ile_dni.'</td>'; 
	  } else {
		 echo'<td class="frek"> </td>';
	  }
	echo'</tr>';
  }
   
   $u = 0;
   $n = 0;
   $o = 0;
   $s = 0;
   $suma = 0;
   $razem = 0;
   $procent = 0;
   $ilosc = 0;
   $pom='';
}

//Funkcja - frekwencja semestralna
function frek_sem($id_kl,$m1,$m2,$m3,$m4,$m5,$sk)
{
  global $mysqli;
 
  $u = 0;
  $n = 0;
  $o = 0;
  $s = 0;
  $ilosc = 0;
  
  if($result = $mysqli->query("SELECT data,stan,id_ucz FROM frekwencja WHERE id_kl='$id_kl' AND (MONTH(data)='$m1' OR MONTH(data)='$m2' OR MONTH(data)='$m3' OR MONTH(data)='$m4' OR MONTH(data)='$m5')"))
  {
	while($row=$result->fetch_object())
	{
		 $stan = $row->stan;
		 $id_ucz = $row->id_ucz;
		 
		 $pom[] = $id_ucz;

		 switch($stan)
		 {
		   case 'u': $u++; break;
		   case 'n': $n++; break;
		   case 'o': $o++; break;
		   case 's': $s++; break;
		 }
	}

	 $result2 = $mysqli->query("SELECT data FROM frekwencja WHERE id_kl='1' AND (MONTH(data)='$m1' OR MONTH(data)='$m2' OR MONTH(data)='$m3' OR MONTH(data)='$m4' OR MONTH(data)='$m5') GROUP BY data");
	 while($row2=$result2->fetch_object())
	 {
		$daty[] = $row2->data;
	 }
	 
	 if (!isset($daty)) {
	  $daty = 0;
	  $ile_dni = 0;
	 } else {
	  $ile_dni = count($daty);
	 }

	if($u == 0) $u = '';
	if($n == 0) $n = '';
	if($o == 0) $o = '';
	if($s == 0) $s = '';
	
	$suma = $u+$n;
	$ob = $o+$s;
	
	$razem = $suma + $ob;
	
	if($razem > 0)
	{
	  $procent = ($ob * 100) / $razem;
	  $procent = number_format($procent, 2, '.', '');
	}
	
	if(isset($pom))
	{
	  $pom = array_unique($pom);
	  $ilosc = count($pom);
	}

	echo'<tr>';
	  echo'<td class="frek">RAZEM - '.$sk.'</td>';

	  //Ilość uczniów
	  if( $ilosc > 0)
	  {
		 echo'<td class="frek">'.$ilosc.'</td>'; 
	  } else {
		 echo'<td class="frek"> </td>';
	  }

	  //Razem
	  if( $razem > 0)
	  {
		 echo'<td class="frek">'.$razem.'</td class="frek">'; 
	  } else {
		 echo'<td class="frek"> </td>';
	  }

	  //Obecność
	  if( $ob > 0)
	  {
		 echo'<td class="frek">'.$ob.'</td>'; 
	  } else {
		 echo'<td class="frek"> </td>';
	  }
	  
	  //Nieobecność
	  if( $suma > 0)
	  {
		 echo'<td class="frek">'.$suma.'</td>'; 
	  } else {
		 echo'<td class="frek"> </td>';
	  }

	  //Procent	  
	  if(isset($procent))
	  {
		 echo'<td class="frek">'.$procent.'</td>'; 
	  } else {
		 echo'<td class="frek"> </td>';
	  }

	  //Ilość dni
	  if(isset($ile_dni))
	  {
		 echo'<td class="frek">'.$ile_dni.'</td>'; 
	  } else {
		 echo'<td class="frek"> </td>';
	  }
	echo'</tr>';
  }
   
   $u = 0;
   $n = 0;
   $o = 0;
   $s = 0;
   $suma = 0;
   $razem = 0;
   $procent = 0;
   $ilosc = 0;
   $pom='';
}

?>
<div id="lista" class="zawartosc">
  <h3 id="nagRamka">ZESTAWIENIE FREKWENCJI - KLASA <?php echo $klasa . ' ' . $sb?></h3>
  <div id="time-2"><a href="javascript:drukuj()"><img src="image/printer.png" alt="Drukarka" title="Drukuj"></a></div>
  <table id="zestawienie-2">
  <tr>
    <th rowspan="3" class="msc">Miesiąc</th>
    <th rowspan="3">Liczba<br>uczniów<br>w klasie</th>
    <th colspan="4">Liczba godzin obowiązkowych zajęć lekcyjnych<br> w miesiącach</th>
    <th rowspan="3">Liczba dni, w których lekcje się odbyły</th>
  </tr>
  <tr>
    <th rowspan="2" class="raz">razem</th>
    <th colspan="2">w tym liczba godzin:</th>
    <th rowspan="2">% obecności</th>
  </tr>
  <tr>
    <th>obecność<br>uczniów</th>
    <th>nieobecność<br>uczniów</th>
  </tr>
  <tr>
  <?php 
	  if ($mk == 's') {
		frek_sem($id_kl,'09','10','11','12','01','SEM I');
	  } elseif ($mk == 'k') {
		frek_sem($id_kl,'02','03','04','05','06','SEM II');
	  } else {
		frek_msc($id_kl,$mk);  
	  }
   ?>
  </tr>
  </table>
</div>
</body>
</html>