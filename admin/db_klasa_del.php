<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MysQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

$id_st = 4;
$id_wych = $_GET['id_wych'];
$id_sz=$_GET['id_sz'];
 
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
	$id=$_GET['id'];
	if($stmt=$mysqli->prepare("DELETE FROM klasy WHERE id_kl = ? LIMIT 1"))
	{
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
	}

	if($stmtup = $mysqli->prepare("UPDATE users SET id_st = ? WHERE id = ?"))
	{
		 $stmtup->bind_param("ii",$id_st,$id_wych);
		 $stmtup->execute();
		 $stmtup->close(); 
	}
	
 $mysqli->close();
 header("location: db_klasa.php?id_sz=" . $id_sz);
} else {
 	header("location: db_klasa.php?id_sz=" . $id_sz);	
}
?>