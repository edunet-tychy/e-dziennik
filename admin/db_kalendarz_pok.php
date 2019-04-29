<?php
include_once('status.php');

//Nawiązanie połączenia serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$id_db = $_SESSION['id_db'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];

if($result = $mysqli->query("SELECT * FROM kalendarz ORDER BY od"))
{
			
  if($result->num_rows > 0)
  {
	echo'<table id="center-2-tabela">';
	echo'<tr>';
	echo'<th>OD</th>';
	echo'<th>DO</th>';
	echo'<th>WYDARZENIE</th>';
	echo'<th>EDYTUJ</th>';
	echo'<th>USUŃ</th>';
	echo'</tr>';
				
	while($row=$result->fetch_object())
	{
	  echo'<tr>';
	  echo'<td>'. $row->od .'</td>';
	  echo'<td>'. $row->do .'</td>';
	  echo'<td class="lewy">'. $row->tresc .'</td>';
	  echo'<td><a href="db_kalendarz_edit.php?id='. $row->id_kal .'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
	  echo'<td><a href="db_kalendarz_del.php?id='. $row->id_kal .'"><img src="image/del.png" alt="Kosz"></a></td>';
	  echo'</tr>';
	}
	
	echo'</table>';
  }else {
	echo '<img src="image/pytanie.png" alt="Brak rekordów">';
	echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
  }
} else {
  echo 'Błąd: ' . $mysqli->error;
}

?>