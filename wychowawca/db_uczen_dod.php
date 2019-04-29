<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
</head>
<?php
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');
 
//Sprawdzenie nawiązania połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

/*------------------------------------------------------------------
					Adres rodzica - tabela ADRES
--------------------------------------------------------------------*/
echo $ulica = $_POST['ulica'];
echo $miasto = $_POST['miasto'];
echo $lokal = htmlentities($_POST['lokal'], ENT_QUOTES, 'UTF-8');
echo $woj = $_POST['woj'];
echo $kod = htmlentities($_POST['kod'], ENT_QUOTES, 'UTF-8');

//Sprawdzamy, czy istnieje taki adres
if($result = $mysqli->query("SELECT * FROM adresy WHERE ulica='$ulica' AND miasto='$miasto' AND lokal='$lokal' AND woj='$woj' AND kod='$kod'"))
{
	//Jeżeli adres nie istnieje, to sprawdzamy, czy wszystkie pola zostały wypełnione
	if($result->num_rows == 0)
	{
	   if($ulica != '' && $miasto != '' && $lokal != '' && $woj != '' && $kod != '')
	   {
		if($stmt = $mysqli->prepare("INSERT adresy (ulica,miasto,lokal,woj,kod) VALUES (?,?,?,?,?)"))
		{
		  $stmt->bind_param("sssss",$ulica,$miasto,$lokal,$woj,$kod);
		  $stmt->execute();
		  $stmt->close();
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}

//Pobieramy id_ad dodanego adresu
$query = "SELECT id_ad FROM adresy WHERE ulica='$ulica' AND miasto='$miasto' AND lokal='$lokal' AND woj='$woj' AND kod='$kod'";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}
$row = $result->fetch_row();
$id_ad = $row[0];

/*------------------------------------------------------------------
					Telefon rodzica - tabela TELEFONY
--------------------------------------------------------------------*/
echo $numer = htmlentities($_POST['telefon'], ENT_QUOTES, 'UTF-8');

//Sprawdzamy, czy istnieje taki adres
if($result = $mysqli->query("SELECT * FROM telefony WHERE numer='$numer'"))
{
	//Jeżeli adres nie istnieje, to sprawdzamy, czy pole zostało wypełnione
	if($result->num_rows == 0)
	{
	   if($numer != '')
	   {
		if($stmt = $mysqli->prepare("INSERT telefony (numer) VALUES (?)"))
		{
		  $stmt->bind_param("s",$numer);
		  $stmt->execute();
		  $stmt->close();
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}

//Pobieramy id_tel dodanego numeru telefonu
$query = "SELECT id_tel FROM telefony WHERE numer='$numer'";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}
$row = $result->fetch_row();
$id_tel = $row[0];

/*------------------------------------------------------------------
					Konto rodzica - tabela USERS
--------------------------------------------------------------------*/
$nazwiskoR = $_POST['nazwiskoR'];
$imieM = $_POST['imieMatki'];
$imieO = $_POST['imieOjca'];
$emailR = htmlentities($_POST['emailRodzic'], ENT_QUOTES, 'UTF-8');

if(!isset($emialR)){$emailR = 'brak';}

$imieR=$imieM.', '.$imieO;

//Tworzenie loginu dla konta rodzica
  function generatorLoginu()
  {
	  $klucz='';
	  $zaczyn='1234567890';
		  for($i=0; $i<4; $i++)
		  {
			  $klucz.=$zaczyn{rand(0,strlen($zaczyn)-1)};
		  }
		  return $klucz;
  }

//$naz = iconv('utf-8','us-ascii//TRANSLIT//IGNORE', $naz);
$naz = str_replace(array('ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż', 'Ą', 'Ć', 'Ę', 'Ł', 'Ń', 'Ó', 'Ś', 'Ź', 'Ż'), array('a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z', 'A', 'C', 'E', 'L', 'N', 'O', 'S', 'Z', 'Z'), $nazwiskoR);
$naz=strtolower($naz);

$loginR = $naz.'@'.generatorLoginu();
//Tworzenie hasła dla konta rodzica
  function generatorHasla()
  {
	  $klucz='';
	  $zaczyn='1234567890qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM@';
		  for($i=0; $i<8; $i++)
		  {
			  $klucz.=$zaczyn{rand(0,strlen($zaczyn)-1)};
		  }
		  return $klucz;
  }
$passR=generatorHasla();
$id_stR = 5;

//Szyfrowanie hasła
//$haslo = crypt($pass);
//Testowo - brak szyfrowania
$hasloR = $passR;

//sprawdzenie, czy w bazie istnieje podany login
if($result = $mysqli->query("SELECT * FROM users WHERE login='$loginR' AND email='$emailR' AND nazwisko='$nazwiskoR' AND imie='$imieR'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
	if($result->num_rows == 0)
	{
	   if($nazwiskoR != '' && $imieR != '' && $loginR != '' && $hasloR != '' && $id_stR != '' && $emailR != '')
	   {
		   echo 'moduł działa';
		if($stmt = $mysqli->prepare("INSERT users (nazwisko,imie,login,haslo,id_st,email) VALUES (?,?,?,?,?,?)"))
		{
		  $stmt->bind_param("ssssis",$nazwiskoR,$imieR,$loginR,$hasloR,$id_stR,$emailR);
		  $stmt->execute();
		  $stmt->close();
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}

//Pobieramy id_user dodanego konta
$query = "SELECT id FROM users WHERE login='$loginR'";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}
$row = $result->fetch_row();
$id_userR =	$row[0];

/*------------------------------------------------------------------
					Konto RODZIC - tabela RODZIC
--------------------------------------------------------------------*/
$nazwisko = $_POST['nazwiskoR'];
$imieM = $_POST['imieMatki'];
$imieO = $_POST['imieOjca'];

//sprawdzenie, czy w bazie istnieje podany rodzic
if($result = $mysqli->query("SELECT * FROM rodzic WHERE nazwisko='$nazwisko' AND imieM='$imieM' AND imieO='$imieO' AND id_ad='$id_ad'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
	if($result->num_rows == 0)
	{
	   if($nazwisko != '' && $imieM != '' && $imieO != '' && $id_ad != '' && $id_tel != '' && $id_userR != '')
	   {
		if($stmt = $mysqli->prepare("INSERT rodzic (nazwisko,imieM,imieO,id_ad,id_tel,id_user) VALUES (?,?,?,?,?,?)"))
		{
		  $stmt->bind_param("sssiii",$nazwisko,$imieM,$imieO,$id_ad,$id_tel,$id_userR);
		  $stmt->execute();
		  $stmt->close();
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}

//Pobieramy id_rodz dodanego konta
$query = "SELECT id_rodz FROM rodzic WHERE imieM='$imieM' AND imieO='$imieO' AND nazwisko='$nazwisko' AND id_ad='$id_ad' AND id_tel='$id_tel'";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}
$row = $result->fetch_row();
$id_rodz =	$row[0];

/*------------------------------------------------------------------
					Konto ucznia - tabela USERS
--------------------------------------------------------------------*/
$nazwisko = $_POST['nazwisko'];
$imie = $_POST['imie'];
$email = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
$login = htmlentities($_POST['login'], ENT_QUOTES, 'UTF-8');
$pass = htmlentities($_POST['passwd'], ENT_QUOTES, 'UTF-8');
$id_st = 6;

//Szyfrowanie hasła
//$haslo = crypt($pass);
//Testowo - brak szyfrowania
$haslo = $pass;

//sprawdzenie, czy w bazie istnieje podany login
if($result = $mysqli->query("SELECT * FROM users WHERE login='$login'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
	if($result->num_rows == 0)
	{
	   if($nazwisko != '' && $imie != '' && $login != '' && $haslo != '' && $id_st != '')
	   {
		if($stmt = $mysqli->prepare("INSERT users (nazwisko,imie,login,haslo,id_st,email) VALUES (?,?,?,?,?,?)"))
		{
		  $stmt->bind_param("ssssis",$nazwisko,$imie,$login,$haslo,$id_st,$email);
		  $stmt->execute();
		  $stmt->close();
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}

//Pobieramy id_user dodanego konta
$query = "SELECT id FROM users WHERE login='$login'";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}
$row = $result->fetch_row();
$id_user =	$row[0];

/*------------------------------------------------------------------
					Konto ucznia - tabela UCZEN
--------------------------------------------------------------------*/
$nr_ewid = htmlentities($_POST['nrEwiden'], ENT_QUOTES, 'UTF-8');
$pesel = htmlentities($_POST['pesel'], ENT_QUOTES, 'UTF-8');
$data_ur = htmlentities($_POST['dataUrodz'], ENT_QUOTES, 'UTF-8');
$miejsce_ur = $_POST['miejsceUrodz'];
$plec = htmlentities($_POST['plec'], ENT_QUOTES, 'UTF-8');
$id_kl = $_SESSION['id_kl'];

//sprawdzenie, czy w bazie istnieje podany numer ewidencyjny nadany przez szkołę
if($result = $mysqli->query("SELECT * FROM uczen WHERE nr_ewid='$nr_ewid'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
	if($result->num_rows == 0)
	{
	   if($nr_ewid != '' && $data_ur != '' && $miejsce_ur != '')
	   {
		if($stmt = $mysqli->prepare("INSERT uczen (nr_ewid,pesel,data_ur,miejsce_ur,plec,id_user,id_kl) VALUES (?,?,?,?,?,?,?)"))
		{
		  $stmt->bind_param("sssssii",$nr_ewid,$pesel,$data_ur,$miejsce_ur,$plec,$id_user,$id_kl);
		  $stmt->execute();
		  $stmt->close();
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}

//Pobieramy id_user dodanego konta
$query = "SELECT * FROM uczen WHERE nr_ewid='$nr_ewid'";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}
$row = $result->fetch_row();
$id_ucz = $row[0];

/*------------------------------------------------------------------
					RODZIC-DZIECKO - TABELA RODZICE
--------------------------------------------------------------------*/

//sprawdzenie, czy w bazie istnieje podana para rodzic-uczen
if($result = $mysqli->query("SELECT * FROM rodzice WHERE id_rodz='$id_rodz' AND id_ucz='$id_ucz'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
	if($result->num_rows == 0)
	{
	   if($id_rodz != '' && $id_ucz != '')
	   {
		if($stmt = $mysqli->prepare("INSERT rodzice (id_ucz,id_rodz) VALUES (?,?)"))
		{
		  $stmt->bind_param("ii",$id_ucz,$id_rodz);
		  $stmt->execute();
		  $stmt->close();
		}
	   }
	}
} else {
	echo 'Błąd: ' . $mysqli->error;
}

?>
</body>
</html>