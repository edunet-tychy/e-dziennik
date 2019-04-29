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
		
$query = "SELECT * FROM wycieczki WHERE id_kl = '$id_kl' ORDER BY data";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}

function zapytanie($query)
{
 global $mysqli;
	if(!$result = $mysqli->query($query))
	{
	  echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	  $mysqli->close();
	}
	$row = $result->fetch_row();
	$tab[] = $row[0];
	$tab[] = $row[1];
 return $tab;
}

//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0		
if($result->num_rows > 0)
{
  $nr=0;
  
  echo'<table id="center-tabela-pod-2">';
  echo'<tr>';
  echo'<th>NR</th>';
  echo'<th>DATA</th>';
  echo'<th>CZAS TRWANIA</th>';
  echo'<th>L. UCZ.</th>';
  echo'<th>DOKĄD I W JAKIM CELU ODBYŁA SIĘ WYCIECZKA</th>';
  echo'<th>NAUCZYCIEL</th>';
  echo'<th>EDYTUJ</th>';
  echo'<th>USUŃ</th>';
  echo'</tr>';	
  			
  //Generujemy wiersze
  while($row=$result->fetch_object())
  {
	  $nr++;
	  
	  echo'<tr>';
	  echo'<td>'. $nr . '</td>';
	  echo'<td>'. $row->data. '</td>';
	  echo'<td>'. $row->czas .'</td>';
	  echo'<td>'. $row->ilu_uczniow .'</td>';
	  echo'<td>'. $row->dokad .'</td>';
	  
	  $query = "SELECT imie, nazwisko FROM users WHERE id = '$row->id_user'";
	  $tab = zapytanie($query);
	  $imie = $tab[0];
	  $nazwisko =  $tab[1];
	  
	  
	  echo'<td>' . $imie . ' ' . $nazwisko . '</td>';
	  echo'<td><a href="db_wycieczki_edit.php?id_wyk='. $row->id_wyk .'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
	  echo'<td><a href="db_wycieczki_del.php?id_wyk='. $row->id_wyk .'"><img src="image/del.png" alt="Kosz"></a></td>';
	  echo'</tr>';
  }
  echo'</table>';
  
} else {
        echo '<img src="image/pytanie.png" alt="Brak rekordów">';
        echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
}
?>
</body>
</html>