<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$id_kl=$_GET['id_kl'];
$id = $_SESSION['id_db'];
		
$query = "SELECT id_pod FROM klasy_podreczniki WHERE id_kl = '$id_kl'";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}

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

echo'<h3 id="nagRamka">LISTA PODRĘCZNIKÓW</h3>';
	
if($result = $mysqli->query("SELECT * FROM klasy_podreczniki WHERE id_kl='$id_kl'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows > 0)
  {
	$nr=0;
	
	echo'<table id="center-tabela-pod">';
	echo'<tr>';
	echo'<th>L.P.</th>';
	echo'<th>PRZEDMIOT</th>';
	echo'<th>NR DOP.</th>';
	echo'<th>TYTUŁ</th>';
	echo'<th>AUTORZY</th>';
	echo'<th>WYDAW.</th>';
    echo'<th>EDYTUJ</th>';
    echo'<th>USUŃ</th>';
	echo'</tr>';

	  while($row=$result->fetch_object())
	  {
		$id_kp = $row->id_klpd;
		$id_pod = $row->id_pod;
		$id_przed = $row->id_przed;
		$id_kl = $row->id_kl;

		$query = "SELECT nazwa FROM przedmioty WHERE id_przed='$id_przed'";
		$tab = zapytanie($query);
		$nazwa = $tab[0];
		
		$query = "SELECT nr_dop, tytul, autorzy, wydawnictwo FROM podreczniki WHERE id_pod='$id_pod'";
		$tab = zapytanie($query);
		$nr_dop = $tab[0];
		$tytul = $tab[1];
		$autorzy = $tab[2];
		$wydawnictwo = $tab[3];
		  
		
        $query = "SELECT id_kp FROM klasy_przedmioty WHERE id_przed='$id_przed' AND id_kl='$id_kl'";
        $tab = zapytanie($query);
        $id_kp = $tab[0];

		$res = $mysqli->query("SELECT id_naucz FROM klasy_nauczyciele WHERE id_kp='$id_kp'");
		while($wr=$res->fetch_object())
		{
		  $id_naucz = $wr->id_naucz;
		  
		  if($id_naucz == $id) {
			$nr++;
			echo'<tr>';
			echo'<td>'. $nr .'</td>';
			echo'<td>'. $nazwa .'</td>';		  
			echo'<td>'. $nr_dop .'</td>';
			echo'<td>'. $tytul .'</td>';
			echo'<td>'. $autorzy .'</td>';
			echo'<td>'. $wydawnictwo .'</td>';
			echo'<td><a href="podrecznik_edit.php?id_pod='. $row->id_pod .'&id_kl='.$id_kl.'&id_przed='.$id_przed.'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
			echo'<td><a href="podrecznik_del.php?id_pod='. $row->id_pod .'&id_kl='.$id_kl.'&id_przed='.$id_przed.'"><img src="image/del.png" alt="Kosz"></a></td>';
			echo'</tr>';
		  }
		}
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