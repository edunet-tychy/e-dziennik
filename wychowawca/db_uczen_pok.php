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

$id_kl = $_SESSION['id_kl'];

$query = "SELECT id_user FROM uczen WHERE id_kl='$id_kl'";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}

if($result->num_rows > 0)
{
	$nr=0;
	
	echo'<table id="center-tabela">';
	echo'<tr>';
	echo'<th>L.P.</th>';
	echo'<th>NAZWISKO</th>';
	echo'<th>IMIE</th>';
	echo'<th>DANE</th>';
	echo'<th>EDYTUJ</th>';
	echo'<th>USUŃ</th>';
	echo'</tr>';
	
	while($row=$result->fetch_object())
	{
		$id = $row->id_user;
		$query2 = "SELECT * FROM users WHERE id = '$id'";

		if(!$result2 = $mysqli->query($query2)){
		   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
		   $mysqli->close();
		}
			
		if($result2->num_rows > 0)
		{					
			while($row2=$result2->fetch_object())
			{
				// Polskie znaki - zmiana
				$search = array('Ś','Ł','Ź');
				$replace = array('Szz','Lzz','Nzz');
				$row2->nazwisko = str_replace($search, $replace,$row2->nazwisko);
				
				$uczniowie[] = $row2->nazwisko.'; '.$row2->imie.'; '.$row2->id;
				
			}
		}else {
			echo 'Brak rekordów';
		}
	}
	
		//Sortowanie wyników
	if(isset($uczniowie))
	{

		sort($uczniowie);
		
		foreach($uczniowie as $uczen)
		{
			$uczen = explode('; ', $uczen);
			$nr++;
			
			$nazwisko = $uczen[0];
			
			// Polskie znaki - zmiana
			$search = array('Szz','Lzz','Nzz');
			$replace = array('Ś','Ł','Ź');
			$nazwisko = str_replace($search, $replace, $nazwisko);
			
			$imie = $uczen[1];
			$id = $uczen[2];
			
			echo'<tr>';
			echo'<td>'. $nr. '</td>';
			echo'<td>'. $nazwisko .'</td>';
			echo'<td>'. $imie .'</td>';
			echo'<td><a href="db_uczen_dane.php?id='. $id .'"><img src="image/dane.png" alt="Dane"></a></td>';
			echo'<td><a href="db_uczen_edit.php?id='. $id .'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
			echo'<td><a href="db_uczen_del.php?id='. $id .'"><img src="image/del.png" alt="Kosz"></a></td>';
			echo'</tr>';
		}
	}

	echo'</table>';

} else {
        echo '<img src="image/pytanie.png" alt="Brak rekordów">';
        echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
}
?>
</body>
</html>