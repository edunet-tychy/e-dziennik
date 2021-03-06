<?php
include_once('status.php');
//Nawiązanie połączenia serwerem MySQL.
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   $mysqli->connect_error;
}

if($result = $mysqli->query("SELECT * FROM szkoly ORDER BY typ, opis"))
{

//Sprawdzenie, czy rekordów jest więcej niż 0
if($result->num_rows > 0)
{
  echo'<table id="user-tabela">';
  echo'<tr>';
  echo'<th>SZKOŁA - PEŁNA NAZWA</th>';
  echo'<th>SKRÓT</th>';
  echo'<th>TYP</th>';
  echo'<th>EDYTUJ</th>';
  echo'<th>USUŃ</th>';
  echo'</tr>';
			  
  //Tworzenie wierszy
  while($row=$result->fetch_object())
  {
	  echo'<tr>';
	  echo'<td>'. $row->opis .'</td>';
	  echo'<td>'. $row->skrot .'</td>';
	  echo'<td>'. $row->typ .'</td>';
	  echo'<td><a href="db_szkola_edit.php?id='. $row->id_sz .'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
	  echo'<td><a href="db_szkola_del.php?id='. $row->id_sz .'"><img src="image/del.png" alt="Kosz"></a></td>';
	  echo'</tr>';
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