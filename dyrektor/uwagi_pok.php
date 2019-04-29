<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerm MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Klasy
include_once('../class/zapytanie.class.php');

//Zmienna identyfikująca klasę
$id_kl = $_GET['id_kl'];

//Obiekty
$baza = new zapytanie;

//Zapytanie - Uwagi
$query = "SELECT * FROM uwagi WHERE id_kl = '$id_kl' ORDER BY data DESC";

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
  echo'<th>NAZWISKO I IMIĘ</th>';
  echo'<th>DATA</th>';
  echo'<th>TREŚĆ</th>';
  echo'<th>NAUCZYCIEL</th>';
  echo'<th>EDYTUJ</th>';
  echo'<th>USUŃ</th>';
  echo'</tr>';	

  while($row=$result->fetch_object())
  {
	$nr++;
	$id_uw = $row->id_uw;
	$id_ucz = $row->id_ucz;
	$id_naucz = $row->id_naucz;

	echo'<tr>';
	echo'<td>'. $nr . '</td>';
	
	$query = "SELECT imie, nazwisko FROM users WHERE id = '$id_ucz'";
	$baza->pytanie($query);
	$imie = $baza->tab[0];
	$nazwisko =  $baza->tab[1];	  
	
	echo'<td>' . $imie . ' ' . $nazwisko . '</td>';
	echo'<td>'. $row->data. '</td>';
	echo'<td class="tresc">'. $row->tresc .'</td>';

	$query = "SELECT imie, nazwisko FROM users WHERE id = '$id_naucz'";
	$baza->pytanie($query);
	$imie = $baza->tab[0];
	$nazwisko =  $baza->tab[1];
	
	echo'<td>' . $imie . ' ' . $nazwisko . '</td>'; 
	echo'<td><img src="image/oko.png" alt="Brak uprawnień"></td>'; 
	echo'<td><img src="image/oko.png" alt="Brak uprawnień"></td>';
	echo'</tr>';
  }
  echo'</table>';
  
} else {
  echo '<img src="image/pytanie.png" alt="Brak rekordów">';
  echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
}
?>