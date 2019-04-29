<?php
/*
  Skrypt odczytuje, zapisuje i usuwa oceny
  
  Autor: Grzegorz Szymkowiak
  Utworzono: 18.09.2014
  Ostatnia modyfikacja: 25.11.2014 r.
*/

include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$nr = htmlentities($_POST['l_ucz'], ENT_QUOTES, 'UTF-8');
$data = date('Y-m-d');
$id_przed = htmlentities($_POST['id_przed'], ENT_QUOTES, 'UTF-8');
$id_kl = $_SESSION['id_kl'];

//Oceny cząstkowe, semestralne, roczne - wywołanie funkcji
for($i=1; $i<=$nr; $i++)
{
  $id_user = htmlentities($_POST['id_user-'.$i], ENT_QUOTES, 'UTF-8');

  for($j=0;$j<25;$j++)
  {
	echo $poz = htmlentities($_POST['poz-'.$i.'-'.$j], ENT_QUOTES, 'UTF-8');
	echo $oc = htmlentities($_POST['ocena-'.$i.'-'.$j], ENT_QUOTES, 'UTF-8');
	
	zapytanie($poz,$oc,$data,$id_user,$id_przed,$id_kl);	
  }

	if(isset($_POST['prop_'.$i]))
	{
	  $prop_rok = htmlentities($_POST['prop_'.$i], ENT_QUOTES, 'UTF-8');
	  
	  if($prop_rok == 'N' || $prop_rok == 'n')
	  {
		$prop_rok = 'N';
	  } elseif ($prop_rok == 'Z' || $prop_rok == 'z') {
		$prop_rok = 'Z';
	  } elseif($prop_rok > 0 && $prop_rok < 7) {
		$prop_rok = $prop_rok;
	  } else {
		$prop_rok = '';
	  }
	  
	  $poz_prop = $i;
	  prop($prop_rok,$poz_prop,$data,$id_user,$id_przed,$id_kl);	
	}

	if(isset($_POST['sem_'.$i]))
	{
	  $rok = htmlentities($_POST['sem_'.$i], ENT_QUOTES, 'UTF-8');
	  
	  if($rok == 'N' || $rok == 'n')
	  {
		$rok = 'N';
	  } elseif ($rok == 'Z' || $rok == 'z') {
		$rok = 'Z';
	  } elseif($rok > 0 && $rok < 7) {
		$rok = $rok;
	  } else {
		$rok = '';
	  }
	  
	  $poz_rok = $i;
	  rok($rok,$poz_rok,$data,$id_user,$id_przed,$id_kl);		
	}
}

//Opis oceny - wywołanie funkcji
for($k=0; $k<25; $k++)
{
  $poz_opis = $k;
  $sk = htmlentities($_POST['op-'.$k], ENT_QUOTES, 'UTF-8');

  if (isset($sk)) {
	
	$id_op=sprawdz_opis($poz_opis,$id_kl,$id_przed);  
  
	if (isset($id_op)) {
	  $up_opis = $_POST['new_op-'.$k];		
	  update_opis($poz_opis,$id_kl,$id_przed,$up_opis);	
	}
	
	opis_oc($poz_opis,$id_kl,$id_przed,$sk);		
  }
}

//Funkcja - Ocena cząstkowa
function zapytanie($poz,$oc,$data,$id_user,$id_przed,$id_kl)
{
 global $mysqli;
 
 $id_oc=sprawdz($poz,$id_user,$id_kl,$id_przed);
 
  if($result = $mysqli->query("SELECT * FROM oceny_cz_2 WHERE id_oc='$id_oc' AND poz='$poz'"))
  {
	  $row=$result->fetch_object();
	  
	  if($result->num_rows == 0)
	  {
		   if($oc != '' && $data != '' && $id_user != '' && $id_przed != '' && $id_kl != '')
		   {
			if($stmt = $mysqli->prepare("INSERT oceny_cz_2 (poz,oc,data,id_user,id_przed,id_kl) VALUES (?,?,?,?,?,?)"))
			{
			  $stmt->bind_param("sssiii",$poz,$oc,$data,$id_user,$id_przed,$id_kl);
			  $stmt->execute();
			  $stmt->close();
			}
		   }
	  } elseif ($result->num_rows == 1) {
		   if($oc != '' && $data != '' && $id_oc != '' && $oc != $row->oc)
		   {
			if($stmt = $mysqli->prepare("UPDATE oceny_cz_2 SET oc = ?, data = ? WHERE id_oc = ?"))
			{
			   $stmt->bind_param("ssi",$oc,$data,$id_oc);
			   $stmt->execute();
			   $stmt->close();
			}
		   } elseif ($oc == '' && $id_oc != '') {
			if($stmt=$mysqli->prepare("DELETE FROM oceny_cz_2 WHERE id_oc = ?"))
			{
			  $stmt->bind_param("i", $id_oc);
			  $stmt->execute();
			  $stmt->close();
			}
		 }
	  }
  }	
}

//Funkcja - Sprawdzam, czy ocena cząstkowa istnieje
function sprawdz($poz,$id_user,$id_kl,$id_przed)
{
 global $mysqli;
  if($result = $mysqli->query("SELECT id_oc FROM oceny_cz_2 WHERE poz='$poz' AND id_user='$id_user' AND id_kl='$id_kl' AND id_przed='$id_przed'"))
  {
	if($result->num_rows == 1)
	{
	  $row = $result->fetch_row();
	  $id_oc = $row[0];
	}
  }
  
  if (isset($id_oc)) {
	  return $id_oc;
  }
}

//Funkcja - Propozycja oceny rocznej
function prop($prop_rok,$poz_prop,$data,$id_user,$id_przed,$id_kl)
{
 global $mysqli;
 
 $id_ocp=spr_prop($poz_prop,$id_user,$id_kl,$id_przed);
 
  if($result = $mysqli->query("SELECT * FROM ocen_prop_rok WHERE id_ocp='$id_ocp' AND poz='$poz_prop'"))
  {
	  $row=$result->fetch_object();
	  
	  if($result->num_rows == 0)
	  {
		   if($prop_rok != '' && $prop_rok < 7 && $data != '' && $id_user != '' && $id_przed != '' && $id_kl != '')
		   {
			if($stmt = $mysqli->prepare("INSERT ocen_prop_rok (poz,prop,data,id_user,id_przed,id_kl) VALUES (?,?,?,?,?,?)"))
			{
			  $stmt->bind_param("issiii",$poz_prop,$prop_rok,$data,$id_user,$id_przed,$id_kl);
			  $stmt->execute();
			  $stmt->close();
			}
		   }
	  } elseif($result->num_rows == 1) {
		   if($prop_rok != '' && $prop_rok < 7 || $data != '' && $id_ocp != '' && $prop_rok != $row->prop)
		   {
			if($stmt = $mysqli->prepare("UPDATE ocen_prop_rok SET prop = ?, data = ? WHERE id_ocp = ?"))
			{
			   $stmt->bind_param("ssi",$prop_rok,$data,$id_ocp);
			   $stmt->execute();
			   $stmt->close();
			}
		   } elseif ($prop_rok == '' && $id_ocp != '') {
			if($stmt=$mysqli->prepare("DELETE FROM ocen_prop_rok WHERE id_ocp = ?"))
			{
			  $stmt->bind_param("i", $id_ocp);
			  $stmt->execute();
			  $stmt->close();
			}
		 }
	  }
  }	
}

//Funkcja - Sprawdzam, czy propozycja oceny rocznej istnieje
function spr_prop($poz_prop,$id_user,$id_kl,$id_przed)
{
 global $mysqli;
  if($result = $mysqli->query("SELECT id_ocp FROM ocen_prop_rok WHERE poz='$poz_prop' AND id_user='$id_user' AND id_kl='$id_kl' AND id_przed='$id_przed'"))
  {
	if($result->num_rows == 1)
	{
	  $row = $result->fetch_row();
	  $id_ocp = $row[0];
	}
  }
  if(isset($id_ocp)) return $id_ocp;
}

//Funkcja - Ocena roczna
function rok($rok,$poz_rok,$data,$id_user,$id_przed,$id_kl)
{
 global $mysqli;

 $id_ocs=spr_rok($poz_rok,$id_user,$id_kl,$id_przed);
 
  if($result = $mysqli->query("SELECT * FROM ocen_rok WHERE id_ocs='$id_ocs' AND poz='$poz_rok'"))
  {
	  $row=$result->fetch_object();
	  
	  if($result->num_rows == 0)
	  {
		   if($rok != '' && $rok < 7 && $data != '' && $id_user != '' && $id_przed != '' && $id_kl != '')
		   {
			   
			if($stmt = $mysqli->prepare("INSERT ocen_rok (poz,sem,data,id_user,id_przed,id_kl) VALUES (?,?,?,?,?,?)"))
			{
			  $stmt->bind_param("issiii",$poz_rok,$rok,$data,$id_user,$id_przed,$id_kl);
			  $stmt->execute();
			  $stmt->close();
			}
		   }
	  } elseif($result->num_rows == 1) {
		   if($rok != '' && $rok < 7 && $data != '' && $id_ocs != '' && $rok != $row->sem)
		   {
			if($stmt = $mysqli->prepare("UPDATE ocen_rok SET sem = ?, data = ? WHERE id_ocs = ?"))
			{
			   $stmt->bind_param("ssi",$rok,$data,$id_ocs);
			   $stmt->execute();
			   $stmt->close();
			}
		   } elseif ($rok == '' && $id_ocs != '') {
			if($stmt=$mysqli->prepare("DELETE FROM ocen_rok WHERE id_ocs = ?"))
			{
			  $stmt->bind_param("i", $id_ocs);
			  $stmt->execute();
			  $stmt->close();
			}
		 }
	  }
  }	
}

//Funkcja - Sprawdzam, czy ocena roczna istnieje
function spr_rok($poz_rok,$id_user,$id_kl,$id_przed)
{
 global $mysqli;
  if($result = $mysqli->query("SELECT id_ocs FROM ocen_rok WHERE poz='$poz_rok' AND id_user='$id_user' AND id_kl='$id_kl' AND id_przed='$id_przed'"))
  {
	if($result->num_rows == 1)
	{
	  $row = $result->fetch_row();
	  $id_ocs = $row[0];
	}
  }
  if(isset($id_ocs)) return $id_ocs;
}

//Funkcja - Opis oceny cząstkowej
function opis_oc($poz_opis,$id_kl,$id_przed,$sk)
{
 global $mysqli;
 
 $id_op=sprawdz_opis($poz_opis,$id_kl,$id_przed);
 
  if($result = $mysqli->query("SELECT * FROM oceny_op_k WHERE id_op='$id_op' AND poz='$poz_opis'"))
  {
	  if($result->num_rows == 0)
	  {
		   if($poz_opis >= 0 && $id_kl != '' && $id_przed != '' && $sk != '')
		   {
			if($stmt = $mysqli->prepare("INSERT oceny_op_k (poz,id_przed,id_kl,sk) VALUES (?,?,?,?)"))
			{
			  $stmt->bind_param("iiis",$poz_opis,$id_przed,$id_kl,$sk);
			  $stmt->execute();
			  $stmt->close();
			}
		   }
	  } elseif($result->num_rows == 1) {
		   if($sk != '')
		   {
			if($stmt = $mysqli->prepare("UPDATE oceny_op_k SET sk = ? WHERE id_op = ?"))
			{
			   $stmt->bind_param("si",$sk,$id_op);
			   $stmt->execute();
			   $stmt->close();
			}
		   } elseif ($sk == '' && $id_op != '') {
			if($stmt=$mysqli->prepare("DELETE FROM oceny_op_k WHERE id_op = ?"))
			{
			  $stmt->bind_param("i", $id_op);
			  $stmt->execute();
			  $stmt->close();
			}
		 }
	  }
  }	
}
//Funkcja - Sprawdzam, czy opis oceny istnieje
function sprawdz_opis($poz_opis,$id_kl,$id_przed)
{
 global $mysqli;
  if($result = $mysqli->query("SELECT id_op FROM oceny_op_k WHERE poz='$poz_opis' AND id_kl='$id_kl' AND id_przed='$id_przed'"))
  {
	if($result->num_rows == 1)
	{
	  $row = $result->fetch_row();
	  $id_op = $row[0];
	}
  }
  if(isset($id_op)) return $id_op;
}

//Funkcja - Zmiana opisu oceny
function update_opis($poz_opis,$id_kl,$id_przed,$up_opis)
{
 global $mysqli;
 
 $id_op=sprawdz_opis($poz_opis,$id_kl,$id_przed);
 
  if($result = $mysqli->query("SELECT * FROM oceny_op_k WHERE id_op='$id_op' AND poz='$poz_opis'"))
  {
	if($result->num_rows == 1)
	{
	if($up_opis != '')
	  {
	  if($stmt = $mysqli->prepare("UPDATE oceny_op_k SET opis = ? WHERE id_op = ?"))
		{
		  $stmt->bind_param("si",$up_opis,$id_op);
		  $stmt->execute();
		  $stmt->close();
		}
	  }
	}
  }	
}
?>