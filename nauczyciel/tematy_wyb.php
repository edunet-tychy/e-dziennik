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
$id = $_GET['id'];
$id_przed =  $_GET['id_przed'];
$msc = $_GET['msc'];

if(isset($_GET['tem']))
{
  $tem = $_GET['tem'];
  lekcje_sel($id,$id_kl,$id_przed,$msc,$tem);
} else {
  lekcje($id,$id_kl,$id_przed,$msc);
}

//Funkcja - Lekcje
function lekcje($id,$id_kl,$id_przed,$msc)
{
  global $mysqli;

  if($result = $mysqli->query("SELECT id_zag, zagadnienie FROM rozklad WHERE id_user='$id' AND id_kl='$id_kl' AND id_przed='$id_przed' AND msc='$msc' ORDER BY msc"))
  {
	if($result->num_rows > 0)
	{
	  echo'<select class="min-5" name="temat">';
	  echo'<option value="x">---</option>';
	  
	  while($row=$result->fetch_object())
	  {
		$id_zag = $row->id_zag;
		$zagadnienie = $row->zagadnienie;
		
		echo'<option value="'.$id_zag.'">'.$zagadnienie.'</option>';	
	  }
	  
	  echo'</select>';
	}
  }
}

//Funkcja - Lekcje edycja
function lekcje_sel($id,$id_kl,$id_przed,$msc,$tem)
{
  global $mysqli;

  if($result = $mysqli->query("SELECT id_zag, zagadnienie FROM rozklad WHERE id_user='$id' AND id_kl='$id_kl' AND id_przed='$id_przed' AND msc='$msc' ORDER BY msc"))
  {
	if($result->num_rows > 0)
	{
	  echo'<select class="min-5" name="temat">';
	  
	  while($row=$result->fetch_object())
	  {
		$id_zag = $row->id_zag;
		$zagadnienie = $row->zagadnienie;
		
		if($id_zag == $tem)
		{
		  echo'<option value="'.$id_zag.'" selected>'.$zagadnienie.'</option>';
		} else {
		  echo'<option value="'.$id_zag.'">'.$zagadnienie.'</option>';	
		}
	  }
	  
	  echo'</select>';
	}
  }
}

?>