<?php
//---------------- FUNKCJA TESTUJE HASLO I LOGIN --------------------------------------//
function testUser($user, $pass)
{
  //Umożliwienie odwołań do zmiennych globalnych.
  global $host, $baza, $uzytkownik, $haslo, $id_db;
  
  //Sprawdzenie długości przekazanych ciągów dla kodowania utf-8
  $userNameLength = strlen(utf8_decode($user));
  $userPassLength = strlen(utf8_decode($pass));

  if($userNameLength < 2 || $userPassLength < 8){
    return 8;
  }
  
  //Nawiązanie połączenia serwerem MySQL.
  include('dba_connect.php');  
  
  if($db_obj->connect_errno){
    //echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
    echo $db_obj->connect_error;
    return 7;
  }

  //Zabezpieczenie znaków specjalnych w parametrach.
  $user = $db_obj->real_escape_string($user);
  $pass = $db_obj->real_escape_string($pass);
  
  //Wykonanie zapytania sprawdzającego poprawność danych.
  $query = "SELECT id, haslo, id_st FROM users WHERE Login='$user'";

  if(!$result = $db_obj->query($query)){
    //echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
    $db_obj->close();
    return 7;
  }

  if($result->num_rows <> 1) {
	// Sprawdzenie, czy użytkownik istnieje lub czy użytkowników
	// jest więcej niż jeden
    $result = 8;
  }
  else{
    $row = $result->fetch_row();
	$id_db = $row[0];
    $pass_db = $row[1];
	$rola_db = $row[2];
	
    //Wersja testowa bez kodowania haseł
    if($pass != $pass_db){
    //Wersja docelowa z kodowaniem haseł.
    //if(crypt($pass, $pass_db) != $pass_db){
      $result = 8;
    }
    else{
	switch ($rola_db) {
    case 1:
        $result = 1;
        break;
    case 2:
        $result = 2;
        break;
    case 3:
        $result = 3;
        break;
    case 4:
        $result = 4;
        break;
    case 5:
        $result = 5;
        break;
    case 6:
        $result = 6;
        break;
		}
    }
  }

  //Zamknięcie połączenia z bazą i zwrócenie wyniku.
  $db_obj->close();
  return $result;
}

//----------------- ZAPIS DO BAZY - LOGOWANIE UŻYTKOWNIKA

//Funkcja - Godzina
function godzina()
{
  $godzina = date("H:i");
  return $godz;
}

//Funkcja - Bieżąca data
function dt()
{
  $data = date("Y-m-d");
  return $data;
}

//Funkcja - Godzina
function godz()
{
 return date("G:i");
}

function logowanie($id)
{
  include('dba_connect.php');  
  
  if($db_obj->connect_errno){
    //echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
    echo $db_obj->connect_error;
  }
  
  $data = dt();
  $godz = godz();
  
  if($stmt = $db_obj->prepare("INSERT logowania (data,godz,id_user) VALUES (?,?,?)"))
  {
	$stmt->bind_param("ssi",$data,$godz,$id);
	$stmt->execute();
	$stmt->close();
  }else {
	echo 'Błąd: ' . $db_obj->error;
  }  
  
}

//----------------- SPRAWDZENIE, CZY UZYTKOWNIK JEST ZALOGOWANY

//Rozpoczęcie sesji i procedur logowania.
session_start();

//Użytkownik jest zalogowany.
if(isset($_SESSION['zalogowany']))
{
	 switch ($_SESSION['kto']) {
	  case 'Administrator':
		  //Zalogowany administrator
		  header("Location: admin/admin.php");
		  break;
	  case 'Dyrektor':
		  //Zalogowany dyrektor
		  header("Location: dyrektor/dyr.php");
		  break;
	  case 'Wychowawca':
	  	  //Zalogowany wychowawca
		  header("Location: wychowawca/wych.php");
		  break;
	  case 'Nauczyciel':
	  	  //Zalogowany nauczyciel
		  header("Location: nauczyciel/naucz.php");
		  break;
	  case 'Rodzic':
	  	  //Zalogowany rodzic
		  header("Location: rodzic/rodz.php");
		  break;
	  case 'Uczeń':
	  	  //Zalogowany uczeń
		  header("Location: uczen/ucz.php");
		  break;
		  }
}
//Użytkownik niezalogowany i brak parametru haslo lub user.
else if(!isset($_POST["haslo"]) || !isset($_POST["user"])){
  include('index.php');
}
//Użytkownik niezalogowany i ustawione parametry haslo i user.
else{
  $val = testUser($_POST["user"], $_POST["haslo"]);
	  switch ($val) {
	  case 1:
		  //Logowanie administratora.
		  $_SESSION['zalogowany'] = $_POST["user"];
		  $_SESSION['kto'] = "Administrator";
		  $_SESSION['id_db'] = $id_db;
		  logowanie($id_db);
		  header("Location: admin/admin.php");
		  break;
	  case 2:
		  //Logowanie dyrektora.
		  $_SESSION['zalogowany'] = $_POST["user"];
		  $_SESSION['kto'] = "Dyrektor";
		  $_SESSION['id_db'] = $id_db;
		  logowanie($id_db);
		  header("Location: dyrektor/dyr.php");
		  break;
	  case 3:
	  	  //Logowanie wychowawcy
		  $_SESSION['zalogowany'] = $_POST["user"];
		  $_SESSION['kto'] = "Wychowawca";
		  $_SESSION['id_db'] = $id_db;
		  logowanie($id_db);
		  header("Location: wychowawca/wych.php");
		  break;
	  case 4:
	  	  //Logowanie nauczyciela
		  $_SESSION['zalogowany'] = $_POST["user"];
		  $_SESSION['kto'] = "Nauczyciel";
		  $_SESSION['id_db'] = $id_db;
		  logowanie($id_db);
		  header("Location: nauczyciel/naucz.php");
		  break;
	  case 5:
	  	  //Logowanie rodzica
		  $_SESSION['zalogowany'] = $_POST["user"];
		  $_SESSION['kto'] = "Rodzic";
		  $_SESSION['id_db'] = $id_db;
		  logowanie($id_db);
		  header("Location: rodzic/rodz.php");
		  break;
	  case 6:
	  	  //Logowanie ucznia
		  $_SESSION['zalogowany'] = $_POST["user"];
		  $_SESSION['kto'] = "Uczeń";
		  $_SESSION['id_db'] = $id_db;
		  logowanie($id_db);
		  header("Location: uczen/ucz.php");
		  break;
	  case 7:
		  //Błąd serwera
		  include('index.php');
		  break;
	  case 8:
		  //Niepoprawne dane logowania.
		  include('error.php');
		  break;
	  default:
		  //Błąd systemu logowania, nieprawidłowa wartość zwrócona przez testuser.
		  include('index.php');
		  break;
		  }
}
?>
