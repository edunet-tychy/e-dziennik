<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Klasy
include_once('../class/tematy_pokaz_godz.class.php');
include_once('../class/tematy.class.php');

//Obiekt
$bazaTematyPokazGodz = new tematyPokazGodz;
$bazaTemat = new tematPokaz;

//Zmienne
$id_kl=$_GET['id_kl'];
$id_przed = $_GET['id_przed'];	
$id_user = 	$_GET['id'];
		
$query = "SELECT * FROM rozklad_realiz WHERE id_kl = '$id_kl' AND id_user = '$id_user' AND id_przed = '$id_przed' ORDER BY data";

if(!$result = $mysqli->query($query))
{
 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
 $mysqli->close();
}
	
if($result->num_rows > 0)
{
  $nr=0;
  
  echo'<table id="center-tabela-pod-4">';
  echo'<tr>';
  echo'<th>NR</th>';
  echo'<th>GODZ.</th>';
  echo'<th>LEK.</th>';
  echo'<th>DATA</th>';
  echo'<th>TEMAT</th>';
  echo'<th>EDYTUJ</th>';
  echo'<th>USUŃ</th>';
  echo'</tr>';	
  			
  while($row=$result->fetch_object())
  {
	$nr++;

	echo'<td>'. $nr .'</td>';
	echo'<td>'. $bazaTematyPokazGodz->godziny($row->godz,$mysqli) .'</td>';
	echo'<td>'. $row->godz .'</td>';
	echo'<td>'. $row->data .'</td>';
	echo'<td>'. $bazaTemat->temat($row->temat,$mysqli) .'</td>';
	
	echo'<td><a href="tematy_edit.php?id_tem='. $row->id_tem .'&id_kl='.$id_kl.'&id_przed='.$id_przed.'&godz='.$row->godz.'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
	echo'<td><a href="tematy_del.php?id_tem='. $row->id_tem .'&id_kl='.$id_kl.'&id_przed='.$id_przed.'"><img src="image/del.png" alt="Kosz"></a></td>';
	echo'</tr>';
  }
  echo'</table>';
  
} else {
  echo '<img src="image/pytanie.png" alt="Brak rekordów">';
  echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
}
?>