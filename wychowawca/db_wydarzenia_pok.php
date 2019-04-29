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
		
$query = "SELECT * FROM wydarzenia WHERE id_kl = '$id_kl' ORDER BY data";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}
	
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0		
if($result->num_rows > 0)
{
  $nr=0;
  
  echo'<table id="center-tabela-pod-2">';
  echo'<tr>';
  echo'<th>NR kol.</th>';
  echo'<th>DATA</th>';
  echo'<th>INFORMACJA O PRZEBIEGU WYDARZENIA</th>';
  echo'<th>EDYTUJ</th>';
  echo'<th>USUŃ</th>';
  echo'</tr>';	
  			
  //Generujemy wiersze
  while($row=$result->fetch_object())
  {
	  $nr++;
	  $row->id_wyd;
	  
	  echo'<tr>';
	  echo'<td>'. $nr . '</td>';
	  echo'<td>'. $row->data. '</td>';
	  echo'<td>'. $row->informacje .'</td>';
	  echo'<td><a href="db_wydarzenia_edit.php?id_wyd='. $row->id_wyd .'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
	  echo'<td><a href="db_wydarzenia_del.php?id_wyd='. $row->id_wyd .'"><img src="image/del.png" alt="Kosz"></a></td>';
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