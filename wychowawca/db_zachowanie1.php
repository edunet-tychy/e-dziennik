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
$stan = 0;

//Przyjęcie zmiennych
$ile = $_POST['ile'];

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

for($i=1 ; $i<=$ile ; $i++)
{
    $id_user = $_POST['ucz'.$i];
    $zach = $_POST['zach'.$i];

	if($zach == 'x')
	{
	  $zach = 0;
	}

	$query = "SELECT id_zach,zach FROM zach_sem WHERE id_user='$id_user' AND id_kl='$id_kl'";
	$tab = zapytanie($query);
	$id_zach = $tab[0];
	$zach_tab = $tab[1];
	
	//Wywoływanie funkcji
	if($id_zach == '' && $zach_tab == '' &&  $zach != '0')
	{
	  zach_dod($zach,$id_user,$id_kl);		
	} elseif ($id_zach != '' && $zach_tab != '' &&  $zach != '0')
	{
	  zach_pop($zach,$id_user,$id_kl);	
	} elseif($id_zach != '' &&  $zach == '0')
	{
	  zach_del($id_zach);	
	}
}

//Funkcja - dopisanie zachowania
function zach_dod($zach,$id_user,$id_kl)
{
  global $mysqli;
  
   if($zach != '' && $id_user != '' && $id_kl != '')
   {
	  if($stmt = $mysqli->prepare("INSERT zach_sem (zach,id_user,id_kl) VALUES (?,?,?)"))
	  {
		$stmt->bind_param("iii",$zach,$id_user,$id_kl);
		$stmt->execute();
		$stmt->close();
	  }
   }
}

//Funkcja - poprawa zachowania
function zach_pop($zach,$id_user,$id_kl)
{
  global $mysqli;
      
   if($zach == '' || $id_user == '' || $id_kl == '')
   {
	  $error = 'Wypełnij wszystkie pola!';
   } else {
	  if($stmt = $mysqli->prepare("UPDATE zach_sem SET zach = ? WHERE id_user = ? AND id_kl = ?"))
	  {
		 $stmt->bind_param("iii",$zach,$id_user,$id_kl);
		 $stmt->execute();
		 $stmt->close();
	  } else {
		 echo "Błąd zapytania";
	  }
   }
}

//funkcja - usunięcie zachowania
function zach_del($id_zach)
{
  global $mysqli;
  if($stmt=$mysqli->prepare("DELETE FROM zach_sem WHERE id_zach = ? LIMIT 1"))
  {
	  $stmt->bind_param("i",$id_zach);
	  $stmt->execute();
	  $stmt->close();
  } else {
	  echo 'Błąd zapytania';
  }	
}

?>