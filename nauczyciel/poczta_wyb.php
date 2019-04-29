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
if(isset($_GET['id_st']))
{
  $id_st = $_GET['id_st'];
  $sp = substr($id_st,0,1);
  
  if ($sp == 'R') {
	
	$id_kl = substr($id_st,1);
	rodzic($id_kl);
	
  } else if ($sp == 'U') {

	$id_kl = substr($id_st,1);
	uczen($id_kl);
	
  } else {
	users($id_st);	  
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

//Funkcja - Uczniowie
function uczen($id_kl)
{
  global $mysqli;
  
  if($result = $mysqli->query("SELECT id_user FROM uczen WHERE id_kl='$id_kl' ORDER BY id_user"))
  {
	if($result->num_rows > 0)
	{
	  echo'<select class="min-8" name="kto">';
	  echo'<option value="x">---</option>';
	  
	  while($row=$result->fetch_object())
	  {
		$id_user = $row->id_user;
		
		$query = "SELECT id, nazwisko, imie FROM users WHERE id='$id_user' ORDER BY nazwisko, imie";
		
		if(!$zapytanie = $mysqli->query($query))
		{
		  echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
		  $mysqli->close();
		}

		  $wynik = $zapytanie->fetch_row();
		  $id = $wynik[0];	
		  $nazwisko = $wynik[1];
		  $imie = $wynik[2];
		  
		  echo'<option value="'.$id.'">'.$nazwisko.' '.$imie.'</option>';
	  }

	  echo'</select>';
	}
  }
}

//Funkcja - Rodzice
function rodzic($id_kl)
{
  global $mysqli;
  
  if($result = $mysqli->query("SELECT id_user FROM uczen WHERE id_kl='$id_kl' ORDER BY id_user"))
  {
	if($result->num_rows > 0)
	{
	  echo'<select class="min-8" name="kto">';
	  echo'<option value="x">---</option>';
	  
	  while($row=$result->fetch_object())
	  {
		$id_user = $row->id_user;
		
		$query = "SELECT id, nazwisko, imie FROM users WHERE id='$id_user' ORDER BY nazwisko, imie";
		
		if(!$zapytanie = $mysqli->query($query))
		{
		  echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
		  $mysqli->close();
		}

		  $wynik = $zapytanie->fetch_row();
		  $id = $wynik[0];	
		  $nazwisko = $wynik[1];
		  $imie = $wynik[2];
		  
		  if($result2 = $mysqli->query("SELECT id, nazwisko, imie FROM users WHERE id_st = 5 ORDER BY nazwisko"))
		  {
			if($result2->num_rows > 0)
			{
			  while($row2=$result2->fetch_object())
			  {
				echo $id2 = $row2->id;
				echo $nazwisko2 = $row2->nazwisko;
				echo $imie2 = $row2->imie;
				
				if($nazwisko2 == $nazwisko && $imie2 == $imie2)
				{
				  echo'<option value="'.$id2.'">Rodzic ucznia: '.$nazwisko.' '.$imie.'</option>';	
				}
			  }				
			}	  
		  }	
	  }
	  echo'</select>';
	}
  }
}

?>