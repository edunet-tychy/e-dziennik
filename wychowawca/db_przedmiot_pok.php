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

$id_kl = $_SESSION['id_kl'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$klasa = $_SESSION['klasa'];
$sb = $_SESSION['sb'];

if($result = $mysqli->query("SELECT * FROM klasy_przedmioty WHERE id_kl='$id_kl'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows > 0)
  {
	$nr=0;
	
	echo'<table id="user-tabela">';
	echo'<tr>';
	echo'<th>L.P.</th>';
	echo'<th>PRZEDMIOT</th>';
	echo'<th>NAUCZYCIEL 1</th>';
	echo'<th>NAUCZYCIEL 2</th>';
	echo'<th>EDYTUJ</th>';
	echo'<th>USUŃ</th>';
	echo'</tr>';

	  while($row=$result->fetch_object())
	  {
		$nr++;
		$id_kp = $row->id_kp;
		$id_przed = $row->id_przed;
		
		$przedmiot = "SELECT nazwa FROM przedmioty WHERE id_przed='$id_przed'";
		
		if(!$zapytanie1 = $mysqli->query($przedmiot))
		{
		 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
		 $mysqli->close();
		}
		
		$wynik = $zapytanie1->fetch_row();
		$nazwa = $wynik[0];
		
		echo'<tr>';
		echo'<td>'. $nr .'</td>';
		echo'<td>'. $nazwa .'</td>';
		
		$nauczyciele = "SELECT id_naucz FROM klasy_nauczyciele WHERE id_kp='$id_kp'";
		
		if(!$result2 = $mysqli->query($nauczyciele)){
		   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
		}
		
		if($result2->num_rows > 0)
		{
		  while($row2=$result2->fetch_object())
		  {
			$naucz[] = $row2->id_naucz;
		  }			
		} else {
		  echo 'Brak rekordów';
		}
		
		$naucz1 = "SELECT nazwisko, imie FROM users WHERE id='$naucz[0]'";

		if(!$zapytanie2 = $mysqli->query($naucz1)){
		   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
		   $mysqli->close();
		}
		
		$wynik2 = $zapytanie2->fetch_row();
		$nazwisko1 = $wynik2[0];	
		$imie1 = $wynik2[1];	

		echo'<td>'. $nazwisko1 .' '. $imie1 .'</td>';
		
		if(isset($naucz[1]))
		{
		  $naucz2 = "SELECT nazwisko, imie FROM users WHERE id='$naucz[1]'";
  
		  if(!$zapytanie3 = $mysqli->query($naucz2)){
			 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
			 $mysqli->close();
		  }
		  
		  $wynik3 = $zapytanie3->fetch_row();
		  $nazwisko2 = $wynik3[0];	
		  $imie2 = $wynik3[1];	
  
		  echo'<td>'. $nazwisko2 .' '. $imie2 .'</td>';			
		} else {
			echo'<td> </td>';
		}
		
		echo'<td><a href="db_przedmiot_edit.php?id_kp='. $id_kp .'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
		echo'<td><a href="db_przedmiot_del.php?id_kp='. $id_kp .'"><img src="image/del.png" alt="Kosz"></a></td>';
		echo'</tr>';
		unset($naucz);
		
	  }
	echo'</table>';
  }else {
	echo '<img src="image/pytanie.png" alt="Brak rekordów">';
	echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
  }
}else {
echo 'Błąd: ' . $mysqli->error;
}
?>
</body>
</html>