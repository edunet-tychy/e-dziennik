<?php
include_once('status.php');
include_once('db_connect.php');
  
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
	
  $id=$_GET['id'];
  
	if($stmt=$mysqli->prepare("DELETE FROM szkoly WHERE id_sz = ? LIMIT 1"))
	{
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
	} else {
		echo 'Błąd zapytania';
	}
	
 $mysqli->close();
 header('location: db_szkoly.php');
} else {
 	header('location: db_szkoly.php');	
}
?>