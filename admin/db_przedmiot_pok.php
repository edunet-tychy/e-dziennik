<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

if($result = $mysqli->query("SELECT * FROM przedmioty ORDER BY nazwa"))
{
//Sprawdzamy, czy rekordów jest więcej niż 0
  if($result->num_rows > 0)
  {
	echo'<table id="user-tabela">';
	echo'<tr>';
	echo'<th>NAZWA</th>';
	echo'<th>SKRÓT</th>';
	echo'<th>DO ŚREDNIEJ</th>';
	echo'<th>EDYTUJ</th>';
	echo'<th>USUŃ</th>';
	echo'</tr>';
				
	//Generujemy wiersze
	while($row=$result->fetch_object())
	{
	  echo'<tr>';
	  echo'<td>'. $row->nazwa .'</td>';
	  echo'<td>'. $row->skrot .'</td>';
	  if($row->licz_sr==1)
	  {
		$sr = 'Tak';
	  } else {
		$sr = 'Nie';
	  }
	  echo'<td>'. $sr .'</td>';
	  echo'<td><a href="db_przedmiot_edit.php?id='. $row->id_przed .'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
	  echo'<td><a href="db_przedmiot_del.php?id='. $row->id_przed .'"><img src="image/del.png" alt="Kosz"></a></td>';
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
