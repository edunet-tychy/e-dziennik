<?php
include_once('status.php');

//Nawiązanie połączenia serwerem MySQL.
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

$kto=$_SESSION['zalogowany'];
$query = "SELECT nazwisko, imie, id_st FROM users WHERE login='$kto'";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}

//Zmienna
$db_user=$_GET['st'];

  if($db_user==4)
  {
	$zm=$result = $mysqli->query("SELECT * FROM users WHERE id_st>2 AND id_st<5 ORDER BY nazwisko");
  } else {
	$zm=$result = $mysqli->query("SELECT * FROM users WHERE id_st='$db_user' ORDER BY nazwisko");
  }

  if($zm)
  {
	  
	$nr=0;
  
	if($result->num_rows > 0)
	{
		echo'<table id="user-tabela-u">';
		echo'<tr>';
		echo'<th>L.P.</th>';
		echo'<th>NAZWISKO</th>';
		echo'<th>IMIE</th>';
		echo'<th>LOGIN</th>';
		echo'<th>E-MAIL</th>';
		echo'<th>EDYTUJ</th>';
		echo'<th>USUŃ</th>';
		echo'</tr>';
					
		while($row=$result->fetch_object())
		{
		  $nr++;
		  echo'<tr>';
		  echo'<td>'. $nr .'</td>';
		  echo'<td>'. $row->nazwisko .'</td>';
		  echo'<td>'. $row->imie .'</td>';
		  echo'<td>'. $row->login .'</td>';
			if($row->email=="")
			{
				$poczta = 'Brak';
			} else {
				$poczta = $row->email;
			}
		  echo'<td>'. $poczta .'</td>';
		  echo'<td><a href="db_user_edit.php?id='. $row->id .'&st='.$db_user.'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
		  echo'<td><a href="db_user_del.php?id='. $row->id .'&st='.$db_user.'"><img src="image/del.png" alt="Kosz"></a></td>';
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
$mysqli->close();
?>