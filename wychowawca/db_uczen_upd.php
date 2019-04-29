<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
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

$zalog=$_SESSION['zalogowany'];
$id_kl = $_SESSION['id_kl'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$klasa = $_SESSION['klasa'];
$sb = $_SESSION['sb'];

//Tabela USERS - konto ucznia
$id = htmlentities($_POST['id'], ENT_QUOTES, 'UTF-8');
$nazwisko = $_POST['nazwisko'];
$imie = $_POST['imie'];
$email = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
$login = htmlentities($_POST['login'], ENT_QUOTES, 'UTF-8');
$passwd = htmlentities($_POST['passwd'], ENT_QUOTES, 'UTF-8');

//sprawdzenie, czy w bazie istnieje podany login
if($result = $mysqli->query("SELECT * FROM users WHERE login='$login'"))
{
//taki login nie istnieje
  if($result->num_rows == 0)
  {
	 if($passwd == '')
	 {
		//Brak zmiany hasła. Sprawdzenie, czy pozostałe pola są wypełnione
		if($nazwisko == '' || $imie == '' || $email == '' || $login == '')
		 {
			$error = 'Wypełnij wszystkie pola!';
		 } else {
			if($stmt = $mysqli->prepare("UPDATE users  SET nazwisko = ?, imie = ?, login = ?, email = ? WHERE id = ?"))
			{
			 $stmt->bind_param("ssssi",$nazwisko,$imie,$login,$email,$id);
			 $stmt->execute();
			 $stmt->close(); 
			} else {
			 echo "Błąd zapytania";
			} 
		 }	 
	 } else {
		//Zmiana hasła. Sprawdzenie, czy pozostałe pole są wypełnione
		
		//Szyfrowanie hasła
		//$haslo = crypt($passwd);
		//Testowo - brak szyfrowania
		$haslo = $passwd;
		
		if($nazwisko == '' || $imie == '' || $email == '' || $login == ''  || $haslo == '')
		 {
			$error = 'Wypełnij wszystkie pola!';
		 } else {
			if($stmt = $mysqli->prepare("UPDATE users  SET nazwisko = ?, imie = ?, login = ?, haslo = ?, email = ? WHERE id = ?"))
			{
			 $stmt->bind_param("sssssi",$nazwisko,$imie,$login,$haslo,$email,$id);
			 $stmt->execute();
			 $stmt->close(); 
			} else {
			 echo "Błąd zapytania";
			} 
		 }
	 }
//taki login istnieje
  } elseif($result->num_rows == 1)
  {
	 if($passwd == '')
	 {
		//Brak zmiany hasła. Sprawdzenie, czy pozostałe pola są wypełnione
		if($nazwisko == '' || $imie == '' || $email == '')
		 {
			$error = 'Wypełnij wszystkie pola!';
		 } else {
			if($stmt = $mysqli->prepare("UPDATE users SET nazwisko = ?, imie = ?, email = ? WHERE id = ?"))
			{
			 $stmt->bind_param("sssi",$nazwisko,$imie,$email,$id);
			 $stmt->execute();
			 $stmt->close(); 
			} else {
			 echo "Błąd zapytania";
			} 
		 }	 
	 } else {
		//Zmiana hasła. Sprawdzenie, czy pozostałe pole są wypełnione
		
		//Szyfrowanie hasła
		//$haslo = crypt($passwd);
		//Testowo - brak szyfrowania
		$haslo = $passwd;
		
		if($nazwisko == '' || $imie == '' || $email == '' || $haslo == '')
		 {
			$error = 'Wypełnij wszystkie pola!';
		 } else {
			if($stmt = $mysqli->prepare("UPDATE users SET nazwisko = ?, imie = ?, haslo = ?, email = ? WHERE id = ?"))
			{
			 $stmt->bind_param("ssssi",$nazwisko,$imie,$haslo,$email,$id);
			 $stmt->execute();
			 $stmt->close(); 
			} else {
			 echo "Błąd zapytania";
			} 
		 }
	 }	  
  }
} else {
  echo 'Błąd: ' . $mysqli->error;
}

//Tabela UCZEN
$id_ucz = htmlentities($_POST['id_ucz'], ENT_QUOTES, 'UTF-8');
$nr_ewid = htmlentities($_POST['nrEwiden'], ENT_QUOTES, 'UTF-8');
$pesel = htmlentities($_POST['pesel'], ENT_QUOTES, 'UTF-8');
$data_ur = htmlentities($_POST['dataUrodz'], ENT_QUOTES, 'UTF-8');
$miejsce_ur = $_POST['miejsceUrodz'];
$plec = htmlentities($_POST['plec'], ENT_QUOTES, 'UTF-8');

//sprawdzenie, czy w bazie istnieje podany uczen
if($result = $mysqli->query("SELECT * FROM uczen WHERE id_ucz='$id_ucz'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {
	 if($nr_ewid == '' || $data_ur == '' || $miejsce_ur == '' || $plec == '')
	 {
		  echo $error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE uczen  SET nr_ewid = ?, pesel = ?, data_ur = ? , miejsce_ur = ? , plec = ? WHERE id_ucz = ?"))
		{
			 $stmt->bind_param("sssssi",$nr_ewid,$pesel,$data_ur,$miejsce_ur,$plec,$id_ucz);
			 $stmt->execute();
			 $stmt->close(); 
		} else {
			 echo "Błąd zapytania";
		}
	 }  
  }
} else {
	echo 'Błąd: ' . $mysqli->error;
}

//Tabela RODZIC
$id_rodz = htmlentities($_POST['id_rodz'], ENT_QUOTES, 'UTF-8');
$imieM = $_POST['imieM'];
$imieO = $_POST['imieO'];
$nazwiskoR = $_POST['nazwiskoR'];

//sprawdzenie, czy w bazie istnieje podany rodzic
if($result = $mysqli->query("SELECT * FROM rodzic WHERE id_rodz='$id_rodz'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {
	 if($imieM == '' || $imieO == '' || $nazwiskoR == '')
	 {
		  echo $error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE rodzic  SET imieM = ?, imieO = ?, nazwisko = ? WHERE id_rodz = ?"))
		{
			 $stmt->bind_param("sssi",$imieM,$imieO,$nazwiskoR,$id_rodz);
			 $stmt->execute();
			 $stmt->close(); 
		} else {
			 echo "Błąd zapytania";
		}
	 }  
  }
} else {
	echo 'Błąd: ' . $mysqli->error;
}

//Tabela ADRESY
$id_ad = htmlentities($_POST['id_ad'], ENT_QUOTES, 'UTF-8');
$ulica = htmlentities($_POST['ulica'], ENT_QUOTES, 'UTF-8');
$miasto = $_POST['miasto'];
$lokal = htmlentities($_POST['lokal'], ENT_QUOTES, 'UTF-8');
$woj = $_POST['woj'];
$kod = htmlentities($_POST['kod'], ENT_QUOTES, 'UTF-8');

//sprawdzenie, czy w bazie istnieje podany adres
if($result = $mysqli->query("SELECT * FROM adresy WHERE id_ad='$id_ad'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {
	 if($ulica == '' || $miasto == '' || $lokal == '' || $woj == '' || $kod == '')
	 {
		  echo $error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE adresy  SET ulica = ?, miasto = ?, lokal = ?, woj = ?, kod = ? WHERE id_ad = ?"))
		{
			 $stmt->bind_param("sssssi",$ulica,$miasto,$lokal,$woj,$kod,$id_ad);
			 $stmt->execute();
			 $stmt->close(); 
		} else {
			 echo "Błąd zapytania";
		}
	 }  
  }
} else {
	echo 'Błąd: ' . $mysqli->error;
}

//Tabela TELEFONY
$id_tel = htmlentities($_POST['id_tel'], ENT_QUOTES, 'UTF-8');
$numer = htmlentities($_POST['telefon'], ENT_QUOTES, 'UTF-8');

//sprawdzenie, czy w bazie istnieje podany numer telefonu
if($result = $mysqli->query("SELECT * FROM telefony WHERE id_tel='$id_tel'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {
	 if($numer == '')
	 {
		  echo $error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE telefony SET numer = ? WHERE id_tel = ?"))
		{
			 $stmt->bind_param("si",$numer,$id_tel);
			 $stmt->execute();
			 $stmt->close(); 
		} else {
			 echo "Błąd zapytania";
		}
	 }  
  }
} else {
	echo 'Błąd: ' . $mysqli->error;
}

//Tabela USERS
$id_user = htmlentities($_POST['id_user'], ENT_QUOTES, 'UTF-8');
$imieR = $imieM.', '.$imieO;
$nazwiskoR = $_POST['nazwiskoR'];
$emailRodzic = htmlentities($_POST['emailRodzic'], ENT_QUOTES, 'UTF-8');

//sprawdzenie, czy w bazie istnieje podany użytkownik
if($result = $mysqli->query("SELECT * FROM users WHERE id='$id_user'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {
	 if($nazwiskoR == '' && $imieR != '')
	 {
		  echo $error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE users SET nazwisko = ?, imie = ? WHERE id = ?"))
		{
			 $stmt->bind_param("ssi",$nazwiskoR,$imieR,$id_user);
			 $stmt->execute();
			 $stmt->close(); 
		} else {
			 echo "Błąd zapytania";
		}
	 }  
  }
} else {
	echo 'Błąd: ' . $mysqli->error;
}

?>
</body>
</html>