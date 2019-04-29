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
	$tab[] = $row[1];
 return $tab;
}

$id_kl = $_SESSION['id_kl'];

$query = "SELECT * FROM rodz_spotkania WHERE id_kl = '$id_kl' ORDER BY data DESC";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}

//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0		
if($result->num_rows > 0)
{
  $nr=0;
  
  echo'<table id="center-tabela-pod-4">';
  echo'<tr>';
  echo'<th>NR</th>';
  echo'<th>NAZWISKO I IMIĘ</th>';
  echo'<th>DATA</th>';
  echo'<th>INFORMACJA O SPOTKANIU</th>';
  echo'<th>EDYTUJ</th>';
  echo'<th>USUŃ</th>';
  echo'</tr>';	
  			
  //Generujemy wiersze
  while($row=$result->fetch_object())
  {
	  $nr++;
	  $id_sp = $row->id_sp;
	  $id_ucz = $row->id_ucz;
  
	  echo'<tr>';
	  echo'<td>'. $nr . '</td>';
	  
	  $query = "SELECT imie, nazwisko FROM users WHERE id = '$id_ucz'";
	  $tab = zapytanie($query);
	  $imie = $tab[0];
	  $nazwisko =  $tab[1];	  
	  
	  echo'<td>' . $imie . ' ' . $nazwisko . '</td>';
	  echo'<td>'. $row->data. '</td>';
	  echo'<td class="tresc-2">'. $row->tresc .'</td>';

	  echo'<td><a href="db_spotkania_edit.php?id_sp='. $row->id_sp .'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
	  echo'<td><a href="db_spotkania_del.php?id_sp='. $row->id_sp .'"><img src="image/del.png" alt="Kosz"></a></td>';
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