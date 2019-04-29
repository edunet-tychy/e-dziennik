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

if($result = $mysqli->query("SELECT * FROM news ORDER BY odb, data DESC;"))
{
			
  if($result->num_rows > 0)
  {
	echo'<table id="center-2-tabela">';
	echo'<tr>';
	echo'<th>DATA</th>';
	echo'<th>WYDARZENIE</th>';
	echo'<th>ODBIORCA</th>';
	echo'<th>EDYTUJ</th>';
	echo'<th>USUŃ</th>';
	echo'</tr>';
				
	while($row=$result->fetch_object())
	{
	  echo'<tr>';
	  echo'<td>'. $row->data .'</td>';
	  echo'<td class="lewy">'. $row->informacje .'</td>';
	  if ($row->odb == 1) {
		  $odbiorca = 'Nauczyciel';
	  } elseif ($row->odb == 2) {
		  $odbiorca = 'Rodzic';
	  }
	  echo'<td>'. $odbiorca .'</td>';
	  echo'<td><a href="db_news_edit.php?id='. $row->id_news .'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
	  echo'<td><a href="db_news_del.php?id='. $row->id_news .'"><img src="image/del.png" alt="Kosz"></a></td>';
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