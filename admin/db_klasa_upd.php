<?php
include_once('status.php');

//Nawiązanie połączenia serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$id_kl = htmlentities($_POST['id'], ENT_QUOTES, 'UTF-8');
$klasa = htmlentities($_POST['klasa'], ENT_QUOTES, 'UTF-8');
$id_zw = htmlentities($_POST['id_zw'], ENT_QUOTES, 'UTF-8');
$id_wych = htmlentities($_POST['id_wych'], ENT_QUOTES, 'UTF-8');
$id_new_wych = htmlentities($_POST['nauczycieleEdycja'], ENT_QUOTES, 'UTF-8');

if(($id_zw != 'xx'))
{
  //Sprawdzenie, czy w bazie istnieje podana klasa
  if($result = $mysqli->query("SELECT * FROM klasy WHERE id_kl='$id_kl'"))
  {
  
  //Zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
	if($result->num_rows == 1)
	{   
	  //Sprawdzenie, czy następuje zmiana wychowawcy
		if($id_new_wych=='brak')
		{
		  if($stmt = $mysqli->prepare("UPDATE klasy SET klasa = ?, id_zw = ? WHERE id_kl = ?"))
		  {
			   $stmt->bind_param("sii",$klasa,$id_zw,$id_kl);
			   $stmt->execute();
			   $stmt->close(); 
		  }
		}
		else if($id_wych != $id_new_wych)
		{
			if($stmt = $mysqli->prepare("UPDATE klasy SET klasa = ?, id_zw = ?, id_wych = ? WHERE id_kl = ?"))
			{
				 $stmt->bind_param("siii",$klasa,$id_zw,$id_new_wych,$id_kl);
				 $stmt->execute();
				 $stmt->close(); 
			}
			
			$id_st = 3;
			
			//nowy nauczyciel zostaje wychowawcą
			if($stmtup = $mysqli->prepare("UPDATE users SET id_st = ? WHERE id = ?"))
			{
				 $stmtup->bind_param("ii",$id_st,$id_new_wych);
				 $stmtup->execute();
				 $stmtup->close(); 
			}
			
			$id_st = 4;
			
			//poprzedni wychowawca zostaje nauczycielem
			if($stmtup = $mysqli->prepare("UPDATE users SET id_st = ? WHERE id = ?"))
			{
				 $stmtup->bind_param("ii",$id_st,$id_wych);
				 $stmtup->execute();
				 $stmtup->close(); 
			}		
		}
	 }
	
  } else {
	  echo 'Błąd: ' . $mysqli->error;
  }
}

?>
