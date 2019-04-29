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

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$id_kl=$_GET['id_kl'];
$id_przed = $_GET['id_przed'];	
$id_user = 	$_GET['id'];

$query = "SELECT * FROM rozklad WHERE id_kl = '$id_kl' AND id_user = '$id_user' AND id_przed = '$id_przed' ORDER BY msc";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}

function miesiac($i)
{
  switch($i)
  {
	case 1 : return "Wrzesień"; break;
	case 2 : return "Październik"; break;
	case 3 : return "Listopad"; break;
	case 4 : return "Grudzień"; break;
	case 5 : return "Styczeń"; break;
	case 6 : return "Luty"; break;
	case 7 : return "Marzec"; break;
	case 8 : return "Kwiecień"; break;
	case 9 : return "Maj"; break;
	case 10 : return "Czerwiec"; break;
  }				
}
	
//Zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0		
if($result->num_rows > 0)
{
  $nr=0;
  $pom=0;
  
  echo'<table id="center-tabela-pod-4">';
  echo'<tr>';
  echo'<th>NR kol.</th>';
  echo'<th>M-sc</th>';
  echo'<th>ZAGADNIENIA</th>';
  echo'<th>Il. godz.</th>';
  echo'<th>EDYTUJ</th>';
  echo'<th>USUŃ</th>';
  echo'</tr>';	
  			
  //Generujemy wiersze
  while($row=$result->fetch_object())
  {
	$nr++;
	$row->id_zag;
	$i = $row->msc;

	echo'<tr>';
	echo'<td>'. $nr . '</td>';
	  if($i != $pom)
	  {
		echo'<td>'. miesiac($i) .'</td>';
	  } else {
		echo'<td> </td>';  
	  }
	  $pom = $i;
	echo'<td>'. $row->zagadnienie .'</td>';
	echo'<td>'. $row->il_godz .'</td>';
	echo'<td><a href="rozklad_edit.php?id_zag='. $row->id_zag .'&id_kl='.$id_kl.'&id_przed='.$id_przed.'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
	echo'<td><a href="rozklad_del.php?id_zag='. $row->id_zag .'&id_kl='.$id_kl.'&id_przed='.$id_przed.'"><img src="image/del.png" alt="Kosz"></a></td>';
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