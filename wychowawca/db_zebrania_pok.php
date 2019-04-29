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

$nazwisko='';
$id_kl = $_SESSION['id_kl'];

$query = "SELECT * FROM rodz_zebrania WHERE id_kl = '$id_kl' ORDER BY data, id_zeb DESC";

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
 return $tab;
}

//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0		
if($result->num_rows > 0)
{
  $nr=0;
  
  echo'<table id="center-tabela-pod-4">';
  echo'<tr>';
  echo'<th>NR</th>';
  echo'<th>DATA</th>';
  echo'<th>INFORMACJA O ZEBRANIU</th>';
  echo'<th>OBECNI RODZICE</th>';
  echo'<th>EDYTUJ</th>';
  echo'<th>USUŃ</th>';
  echo'</tr>';	
  			
  //Generujemy wiersze
  while($row=$result->fetch_object())
  {
	  $nr++;
	  $id_zeb = $row->id_zeb;
  
	  echo'<tr>';
	  echo'<td>'. $nr . '</td>';
	  echo'<td>'. $row->data. '</td>';
	  echo'<td>'. $row->tresc .'</td>';
	  echo'<td class="tresc-2">';
	  
		$tab = explode(', ',$row->ob);
		for($i=0; $i<count($tab); $i++)
		{
		  $query = "SELECT nazwisko FROM users WHERE id = '$tab[$i]'";
		  $tb = zapytanie($query);
		  if($i == count($tab) - 1)
		  {
			echo $tb[0];
		  } else {
			echo $tb[0].', ';
		  }
		}
	  
	  echo'</td>';
	  echo'<td><a href="db_zebrania_edit.php?id_zeb='. $row->id_zeb .'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
	  echo'<td><a href="db_zebrania_del.php?id_zeb='. $row->id_zeb .'"><img src="image/del.png" alt="Kosz"></a></td>';
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