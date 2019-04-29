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

//Nawiązanie połączenia serwerem MySQL.
include_once('db_connect.php');
  
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$kto=$_SESSION['zalogowany'];
$id_sz=$_GET['id_sz'];

//Zapytanie
$query = "SELECT nazwisko, imie, id_st FROM users WHERE login='$kto'";

if(!$result = $mysqli->query($query)){
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
}

if($result = $mysqli->query("SELECT * FROM vwychowawca WHERE id_sz='$id_sz' ORDER BY sb, klasa"))
{

//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
			
  if($result->num_rows > 0)
  {
	  echo'<table id="user-tabela">';
	  echo'<tr>';
	  echo'<th>KLASA</th>';
	  echo'<th>WYCHOWAWCA</th>';
	  echo'<th>EDYTUJ</th>';
	  echo'<th>USUŃ</th>';
	  echo'</tr>';
				  
	  //Generujemy wiersze
	  while($row=$result->fetch_object())
	  {
		  echo'<tr>';
		  echo'<td>'. $row->klasa .' '. $row->sb .'</td>';
		  echo'<td>'. $row->imie .' '. $row->nazwisko .'</td>';
		  echo'<td><a href="db_klasa_edit.php?id='. $row->id_kl .'&id_sz='.$id_sz.'&id_wych='.$row->id.'"><img src="image/edytuj.png" alt="Edytuj"></a></td>';
		  echo'<td><a href="db_klasa_del.php?id='. $row->id_kl .'&id_sz='.$id_sz.'&id_wych='.$row->id.'"><img src="image/del.png" alt="Kosz"></a></td>';
		  echo'</tr>';
	  }
   echo'</table>';
  }
}
?>
</body>
</html>