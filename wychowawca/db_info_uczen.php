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
<link href="styl/print.css" rel="stylesheet" type="text/css" media="print">
<script type="text/javascript">
function drukuj(){
 // sprawdź możliwości przeglądarki
   if (!window.print){
      alert("Twoja przeglądarka nie drukuje!")
   return 0;
   }
 alert("Ustawienie wydruku: poziomo")
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

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

//Zmienne
$id_kl = $_SESSION['id_kl'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$klasa = $_SESSION['klasa'];
$sb = $_SESSION['sb'];

//Klasa wybiera identyfikatory użytkowników
class idUser
{
  public function uczniowie($mysqli,$id_kl)
  {
	$query = "SELECT id_user FROM uczen WHERE id_kl = '$id_kl'";
	
	if(!$result = $mysqli->query($query))
	{
	 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	 $mysqli->close();
	}
	
	if($result->num_rows > 0)
	{
	  while($row=$result->fetch_object())
	  {
		 $tab[]=$row->id_user;
	  }		
	}
	if(isset($tab)){return $tab;}
  }
}

//klasa wybiera loginy użytkowników
class users
{
  public function loginy($mysqli,$id_kl)
  {
	$baza = new idUser;
	$idUsers = $baza->uczniowie($mysqli,$id_kl);
	
	$bazaZapyt = new zapytanie;
	
	if(isset($idUsers))
	{
	  foreach($idUsers as $id)
	  {		
		$query = "SELECT nazwisko,imie,login,haslo FROM users WHERE id = '$id'";
		$bazaZapyt->pytanie($query);
		
		// Polskie znaki - zmiana
		$search = array('Ś','Ł','Ź');
		$replace = array('Szz','Lzz','Nzz');
		$bazaZapyt->tab[0] = str_replace($search, $replace,$bazaZapyt->tab[0]);		
		
		$info[] = $bazaZapyt->tab[0].'; '.$bazaZapyt->tab[1].'; '.$bazaZapyt->tab[2].'; '.$bazaZapyt->tab[3].'; '.$id;
	  }
	  if(isset($info)){ return $info;}
	}
	  
  }
}

//Klasa przedstawia dane w formie tabeli
class widok
{
  private $nr;
  public function tabela($mysqli,$id_kl)
  {
	$bazaUser = new users;
	$tab = $bazaUser->loginy($mysqli,$id_kl);
	
	if(isset($tab))
	{
	  sort($tab);
	  foreach($tab as $dane)
	  {
		$this->nr++;
		$dane = explode('; ', $dane);
		
		// Polskie znaki - zmiana
		$search = array('Szz','Lzz','Nzz');
		$replace = array('Ś','Ł','Ź');
		$dane[0] = str_replace($search, $replace, $dane[0]);
		
		echo'<tr>
		<td class="nr">'.$this->nr.'</td>
		<td class="daneUser">'.$dane[0].'</td>
		<td class="daneUser">'.$dane[1].'</td>
		<td class="loginUser">'.$dane[2].'</td>
		<td class="loginUser">'.$dane[3].'</td>
		<td class="loginUser" id="edycja""><a href="db_user_edit.php?id='.$dane[4].'&zw=u"><img src="image/edytuj2.png"></a></td>
		</tr>';
	  }	
	}
  }
}
//Obiekt
$bazaWidok = new widok;
?>

<div id="kontener">
  <div id="logo">
    <img src="../image/logo_user.png" alt="Logo">
    <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $_SESSION['imie_db'],' ',$_SESSION['nazwisko_db'],' - ', $_SESSION['kto'],' klasy: ',$_SESSION['klasa'],' ',$_SESSION['sb']; ?></p>
  </div>
  <div id="opis"><div id="nowosc"><?php $wiadomosc->wiadomosc(); ?></div><p class="info"><a class="linki" href="../logout.php">Wylogowanie</a></p></div>
  <div id="spis"><?php include_once('menu.php');?></div>
  <div id="czescGlowna">
  <h3 id="nagRamka">ZESTAWIENIE LOGINÓW <?php echo $klasa . ' ' . $sb?> - UCZNIOWIE</h3>
  <div id="time-2"><a href="javascript:drukuj()"><img src="image/printer.png" alt="Drukarka" title="Drukuj"></a></div>
    <table id="zestawienie-3">
    <tr><th>LP</th><th>Nazwisko</th><th>Imię</th><th>Login</th><th>Hasło</th><th id="edycja">Edytuj</th></tr>
    <?php $bazaWidok->tabela($mysqli,$id_kl); ?>
    </table><br><br>
  </div>
  <div id="stopka"><p class="stopka">&copy; G.Szymkowiak 2014/2015</p></div>
</div>
</body>
</html>