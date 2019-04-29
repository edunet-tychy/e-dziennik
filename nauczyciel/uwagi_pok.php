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

//Klasy
include_once('../class/uwagi_user.class.php');
include_once('../class/uwaga.class.php');

//Zmienne
$id_kl=$_GET['id_kl'];
$id = $_SESSION['id_db'];

//Funkcja - View: Uwagi
function lista($id_kl,$id,$mysqli)
{
  $bazaUwaga = new uwaga;
  $zestaw = $bazaUwaga->uwagi($id_kl,$id,$mysqli);
  
  $nr=0;
  
  if(isset($zestaw))
  {
	foreach($zestaw as $dane)
	{
	  $dane = explode('; ', $dane);
	  
	  $nr++;
	  echo'<tr>';
	  echo'<td>'. $nr .'</td>';
	  echo'<td>'. $dane[3] .'</td>';
	  echo'<td>'. $dane[1] .' '. $dane[2] .'</td>';
	  echo'<td>'. $dane[4] .'</td>';
	  echo'<td><a href="uwagi_edit.php?id_uw='. $dane[0].'&id_kl='.$id_kl.'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
	  echo'</tr>';
	}
  } else {
	  echo'<tr><td colspan="5">';
	  echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
	  echo'</td></tr>';
  } 
}

echo'<h3 id="nagRamka">ZESTAWIENIE DOKONANYCH WPISÓW</h3>';
	
echo'<table id="center-tabela-pod">';
echo'<tr>';
  echo'<th>L.P.</th>';
  echo'<th>DATA</th>';
  echo'<th>NAZWISKO I IMIĘ</th>';
  echo'<th>TREŚĆ</th>';
  echo'<th>EDYTUJ</th>';
echo'</tr>';
  lista($id_kl,$id,$mysqli);
echo'</table><br><br>';

?>
</body>
</html>