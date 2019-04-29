<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_04.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
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

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

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

//Funkcja - uczniowie klasy
function uczniowie($id_kl)
{
  global $mysqli;
  $lp=0;
  
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
	 echo'<td>'.$lp.'</td>';
	 echo'<td>'.$uczen[0].' '.$uczen[1].'</td>';
	 echo'<td>';
	 echo'<input type="hidden" name="ucz'.$lp.'" value="'.$uczen[2].'">';
	 echo'<select class="min-4" name="zach'.$lp.'">';

	 $query = "SELECT zach FROM zach_sem WHERE id_user='$uczen[2]'";
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
	 
	 if($zach > 0)
	 {
	  echo'<option value="'.$zach.'">'.$stan.'</option>';
	  echo'<option value="0">Usuń ocenę z zachowania</option>';
	  echo'<option value="x">---</option>'; 
	 } else {
	  echo'<option value="x">Brak oceny</option>';
	  echo'<option value="xx">---</option>'; 
	 }
	  
	 zachowanie();
	 echo'</select>';
	 echo'</td>';
	 echo'</tr>';
	 
	}
  }
  
  if(isset($dane)) return count($dane);
}

//Funkcja - wybór zachowania
function zachowanie()
{
  echo'<option value="6">Wzorowe</option>';
  echo'<option value="5">Bardzo dobre</option>';
  echo'<option value="4">Dobre</option>';
  echo'<option value="3">Poprawne</option>';
  echo'<option value="2">Nieodpowiednie</option>';
  echo'<option value="1">Naganne</option>';
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
    <ul class="nawigacja">
      <li><a href="db_uwagi_dane.php" title="lista" class="zakladki" id="z_01">POKAŻ INFORMACJE</a></li>
      <li><a href="db_uwagi_form.php" title="dodaj" class="zakladki" id="z_02">DODAJ INFORMACJĘ</a></li>
      <li><a href="db_zachowanie_sem.php" title="zachowanie" class="zakladki aktywna" id="z_03">ZACHOWANIE - SEM I</a></li>
      <li><a href="db_zachowanie_kon.php" title="zachowanie" class="zakladki" id="z_03">ZACHOWANIE - SEM II</a></li>
    </ul>
    <div id="lista" class="zawartosc">
      <h3 id="nagRamka2">LISTA UCZNIÓW KLASY <?php echo $klasa . ' ' . $sb?></h3>
    </div>
      <form action="db_zachowanie1.php" method="post" name="form" id="form">
      <div id="zapis-2"></div>
      <div class="prawy-3">
      <input type="button" value="Zapisz oceny z zachowania" class="button" id="zapiszZachowanie1">
      </div>
      <div id="czesc">
        <table id="center-tabela">
        <th>Nr</td>
        <th>Nazwisko i imię</th>
        <th>Zachowanie</th>
        <?php $ile = uczniowie($id_kl); echo'<input type="hidden" name="ile" value="'.$ile.'">';?>
        </table><br><br>
        </form>
      </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>