<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');
 
//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
	echo 'ok';
	$id=$_GET['id'];
	if($stmt=$mysqli->prepare("DELETE FROM kalendarz WHERE id_kal = ? LIMIT 1"))
	{
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}
 $mysqli->close();
 header('location: db_kalendarz.php');
} else {
 	header('location: db_kalendarz.php');	
}
?>
</body>
</html>
