<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połącznia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
if(isset($_GET['id_st']))
{
  $id_st = $_GET['id_st'];
  $sp = substr($id_st,0,1);
  if($sp != 'R')
  {
	if($id_st < 7)
	{
	  users($id_st);
	} else {
	  uczen($id_st) ;
	}	  
  } else {
	$id_kl = substr($id_st,1);
	rodzic($id_kl);
  }

}

//Funkcja - Nauczyciele
function users($id_st)
{
  global $mysqli;

  if($result = $mysqli->query("SELECT id, nazwisko, imie FROM users WHERE id_st='$id_st' ORDER BY nazwisko, imie"))
  {
	if($result->num_rows > 0)
	{
	  echo'<select class="min-8" name="kto">';
	  echo'<option value="x">---</option>';
	  
	  while($row=$result->fetch_object())
	  {
		$id = $row->id;
		$nazwisko = $row->nazwisko;
		$imie = $row->imie;
		
		echo'<option value="'.$id.'">'.$nazwisko.' '.$imie.'</option>';	
	  }
	  
	  echo'</select>';
	}
  }
}

?>