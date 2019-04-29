<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');
 
//Sprawdzenie nawiązania połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

$id_kl = $_SESSION['id_kl'];

function zapytanie($query)
{
  global $mysqli;
  if(!$result = $mysqli->query($query))
  {
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
  }
	return $tab = $result->fetch_row();	
}

if($result = $mysqli->query("SELECT * FROM samorzad WHERE id_kl='$id_kl'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows > 0)
  {
	$nr=0;
	
	
	echo'<table id="user-tabela">';
	echo'<tr>';
	echo'<th>L.P.</th>';
	echo'<th>FUNKCJA</th>';
	echo'<th>IMIĘ</th>';
	echo'<th>NAZWISKO</th>';
	echo'<th>EDYTUJ</th>';
	echo'<th>USUŃ</th>';
	echo'</tr>';

	  while($row=$result->fetch_object())
	  {
		$nr++;
		$id_user = $row->id_user;
		$rola = $row->rola;
		$id_sm=$row->id_sm;
		
		$query = "SELECT nazwisko, imie FROM users WHERE id='$id_user'";
		$tab = zapytanie($query);
		$imie = $tab[0];	
		$nazwisko = $tab[1];
		
		switch($rola){
		case 'p' :
		  $rola = 'Przewodniczący';
		break;
		case 'z' :
		  $rola = 'Zastępca';
		break;
		case 's' :
		  $rola = 'Skarbnik';
		break;
		}	
		
		echo'<tr>'; 
		echo'<td>'. $nr .'</td>';
		echo'<td>'. $rola .'</td>';
		echo'<td>'. $nazwisko .'</td>';
		echo'<td>'. $imie .'</td>';
		echo'<td><a href="db_samorzad_edit.php?id_sm='. $id_sm .'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
		echo'<td><a href="db_samorzad_del.php?id_sm='. $id_sm .'"><img src="image/del.png" alt="Kosz"></a></td>';
		echo'</tr>';
	  }
	echo'</table><br><br>';
  }else {
	echo '<img src="image/pytanie.png" alt="Brak rekordów">';
	echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
  }
}else {
echo 'Błąd: ' . $mysqli->error;
}
?>
</body>
</html>