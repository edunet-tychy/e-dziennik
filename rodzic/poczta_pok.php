<?php
include_once('status.php');

//Nawiązanie połączenia serwerem MySQL
include_once('db_connect.php');

//Klasy
include_once('../class/poczta_user.class.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienna
$id = $_SESSION['id_db'];

//Zapytanie
$query = "SELECT * FROM poczta WHERE odb = '$id' ORDER BY id_pocz DESC";

if(!$result = $mysqli->query($query))
{
 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
 $mysqli->close();
}

$bazaUs = new users;
$bazaSt = new statusy;

if($result->num_rows > 0)
{
  $nr=0;
  
  echo'<table id="center-tabela-poczta">';
  echo'<tr>';
  echo'<th>NR</th>';
  echo'<th>DATA</th>';
  echo'<th>NADAWCA</th>';
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
	echo'<td><span class="poczta">'. $bazaUs->user($row->nad) .' - '. $bazaSt->status($row->nad) .'</span></td>';
	echo'<td><span class="poczta">'. $row->tytul .'</span></td>';
	
	echo'<td><a href="poczta_list.php?id_pocz='. $row->id_pocz .'"><img src="image/edytuj.png" alt="POKAŻ"></a></td>';
	} else {
	  echo'<td>'. $nr .'</td>';
	  echo'<td>'. $row->data .'</td>';
	  echo'<td>'. $bazaUs->user($row->nad) .' - '. $bazaSt->status($row->nad) .'</td>';
	  echo'<td>'. $row->tytul .'</td>';
	  
	  echo'<td><a href="poczta_list.php?id_pocz='. $row->id_pocz .'"><img src="image/edytuj.png" alt="POKAŻ"></a></td>';
	}
	echo'</tr>';
  }
  echo'</table>';
  
} else {
  echo '<img src="image/pytanie.png" alt="Brak rekordów">';
  echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
}

?>