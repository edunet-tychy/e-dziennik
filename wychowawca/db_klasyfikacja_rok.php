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

//Zmienne wykorzystywane do obliczeń statystycznych
$n1=0; //ilość uczniów z 1 ndst
$n2=0; //ilość uczniów z 2 ndst
$n3=0; //ilość uczniów z 3 i więcej ndst
$nk=0; //nieklasyfikowanych

//Zmiennw wykorzystywane do obliczeń - zachowanie
$wz=0; //ilość wzorowych
$bd=0; //ilość bardzo dobrych
$db=0; //ilość dobrych
$pop=0; //ilość poprawnych
$np=0; //ilość nieodpowiednich
$ng=0; //ilość nagannych

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
 
//Przeszukanie tabeli z ocenami semestralnymi 
if($result = $mysqli->query("SELECT sem,id_user FROM ocen_rok WHERE id_kl='$id_kl'"))
{
  while($row=$result->fetch_object())
  {
	 $sem = $row->sem;
	 $id_user = $row->id_user;
				 
	 switch($sem)
	 {
	   case '1': $ndst[] = $id_user; break;
	   case 'N': $nkl[] = $id_user; break;
	 }
  }	
}

//Ilość ocen ndst
if(isset($ndst))
{
  $ilosc = array_count_values($ndst);
  sort($ilosc);
   
  foreach($ilosc as $ile)
  {
	if($ile == 1)
	{
	  $n1++;
	} elseif($ile == 2) {
	  $n2++;
	} elseif($ile > 2) {
	  $n3++;
	}
  }	 
}

//ilość uczniów z ocenami ndst
$suma = $n1 + $n2 + $n3;

//ilość uczniów
$query = "SELECT count(id_ucz) FROM uczen WHERE id_kl='$id_kl'";
$tab = zapytanie($query);
$kl = $tab[0];

//Ilość nkl
if(isset($nkl))
{
  $nk = count(array_unique($nkl));
}

//Ilość uczniów bez ndst
$roznica = $kl - $suma - $nk;

//Klasyfikowanych
$klasyfik = $kl - $nk;

//Przeszukanie tabeli z zachowaniem semestralnymi 
if($result = $mysqli->query("SELECT zach FROM zach_rok WHERE id_kl='$id_kl'"))
{
  while($row=$result->fetch_object())
  {
	 $zach = $row->zach;
				 
	 switch($zach)
	 {
	   case '6': $wz++; break;
	   case '5': $bd++; break;
	   case '4': $db++; break;
	   case '3': $pop++; break;
	   case '2': $np++; break;
	   case '1': $ng++; break;
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
      <h3 id="nagRamka">KLASYFIKACJA SEMESTR II - KLASA <?php echo $klasa . ' ' . $sb?></h3>
      <div id="time-2"><a href="javascript:drukuj()"><img src="image/printer.png" alt="Drukarka" title="Drukuj"></a></div>
      <table id="zestawienie-2">
      <tr>
        <th colspan="6">LICZBA UCZNIÓW</th>
      </tr>
      <tr>
        <th class="podtyp">bez ocen NDST</th>
        <th class="podtyp">z 1 oceną NDST</th>
        <th class="podtyp">z 2 ocenami NDST</th>
        <th class="podtyp">z 3 i więcej oc. NDST</th>
        <th class="podtyp">nieklasyfikowanych</th>
        <th class="podtyp">klasyfikowanych</th>
      </tr>
      <tr>
      <?php
        echo'<td>'.$roznica.'</td>';
        echo'<td>'.$n1.'</td>';
        echo'<td>'.$n2.'</td>';
        echo'<td>'.$n3.'</td>';
        echo'<td>'.$nk.'</td>';
        echo'<td>'.$klasyfik.'</td>';
       ?>
      </tr>
      </table>
      <table id="zestawienie-2">
      <tr>
        <th colspan="6">ZACHOWANIE</th>
      </tr>
      <tr>
        <th class="podtyp">wzorowych</th>
        <th class="podtyp">bardzo dobrych</th>
        <th class="podtyp">dobrych</th>
        <th class="podtyp">poprawnych</th>
        <th class="podtyp">nieodpowiednich</th>
        <th class="podtyp">nagannych</th>
      </tr>
      <tr>
      <?php
        echo'<td>'.$wz.'</td>';
        echo'<td>'.$bd.'</td>';
        echo'<td>'.$db.'</td>';
        echo'<td>'.$pop.'</td>';
        echo'<td>'.$np.'</td>';
        echo'<td>'.$ng.'</td>';
       ?>
      </tr>
      </table>
      <div id="user"></div>
    </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>