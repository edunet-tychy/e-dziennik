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
include_once('../class/zapytanie.class.php');

//Zmienne
$id = $_SESSION['id_db'];

//Obiekty
$baza = new zapytanie;

//Zapytanie
$query = "SELECT * FROM uwagi WHERE id_ucz = '$id' ORDER BY data DESC";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}

if($result->num_rows > 0)
{
  $nr=0;
  
  echo'<table id="center-tabela-pod-4">';
  echo'<tr>';
  echo'<th>NR</th>';
  echo'<th>DATA</th>';
  echo'<th>TREŚĆ</th>';
  echo'<th>NAUCZYCIEL</th>';
  echo'</tr>';	
 
  while($row=$result->fetch_object())
  {
	  $nr++;
	  $id_uw = $row->id_uw;
	  $id_ucz = $row->id_ucz;
	  $id_naucz = $row->id_naucz;
  
	  echo'<tr>';
	  echo'<td>'. $nr . '</td>';
	  
	  echo'<td>'. $row->data. '</td>';
	  echo'<td class="tresc">'. $row->tresc .'</td>';

	  $query = "SELECT imie, nazwisko FROM users WHERE id = '$id_naucz'";
	  $baza->pytanie($query);
	  $imie = $baza->tab[0];
	  $nazwisko =  $baza->tab[1];
	  
	  echo'<td>' . $imie . ' ' . $nazwisko . '</td>';
	  echo'</tr>';
  }
  echo'</table>';
  
} else {
        echo '<img src="image/pytanie.png" alt="Brak rekordów">';
        echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
}
?>