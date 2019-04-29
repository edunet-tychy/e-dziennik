<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienna
$id = $_SESSION['id_db'];
		
$query = "SELECT * FROM poczta WHERE nad = '$id' ORDER BY id_pocz DESC";

if(!$result = $mysqli->query($query))
{
 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
 $mysqli->close();
}
	
if($result->num_rows > 0)
{
  $nr=0;
  echo' <h3 id="nagRamka1">LISTY NAPISANE</h3>';
  echo'<table id="center-tabela-poczta-2">';
  echo'<tr>';
  echo'<th>NR</th>';
  echo'<th>DATA</th>';
  echo'<th>TEMAT</th>';
  echo'<th>POKAŻ</th>';
  echo'</tr>';	

  while($row=$result->fetch_object())
  {
	$nr++;
	
	if($row->odczyt == 1)
	{
	echo'<td><span class="poczta">'. $nr .'</span></td>';
	echo'<td><span class="poczta">'. $row->data .'</span></td>';
	echo'<td><span class="poczta">'. $row->tytul .'</span></td>';
	
	echo'<td><a href="poczta_list_nap.php?id_pocz='. $row->id_pocz .'"><img src="image/edytuj.png" alt="POKAŻ"></a></td>';
	} else {
	  echo'<td>'. $nr .'</td>';
	  echo'<td>'. $row->data .'</td>';
	  echo'<td>'. $row->tytul .'</td>';
	  
	  echo'<td><a href="poczta_list_nap.php?id_pocz='. $row->id_pocz .'"><img src="image/edytuj.png" alt="POKAŻ"></a></td>';
	}
	echo'</tr>';
  }
  echo'</table>';
  
} else {
  echo' <h3 id="nagRamka1">LISTY NAPISANE</h3>';
  echo '<img src="image/pytanie.png" alt="Brak rekordów">';
  echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
}
?>