<?php
include_once('status.php');

//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');
 
//Sprawdzenie nawiązania połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

$id_kl = $_SESSION['id_kl'];
$ile=0;

$plan_z = plan();

function usuwam($id_pl)
{
  global $mysqli;
  if($stmt=$mysqli->prepare("DELETE FROM plan_zajec WHERE id_pl = ? LIMIT 1"))
  {
	  $stmt->bind_param("i", $id_pl);
	  $stmt->execute();
	  $stmt->close();
  } else {
	  echo 'Błąd zapytania';
  }
}

function plan()
{
  global $ile;
  global $mysqli;
  global $id_kl;
  $pln='';
  if($result = $mysqli->query("SELECT id_pl, dzien, nr_godz, id_przed, gr FROM plan_zajec WHERE id_kl='$id_kl'"))
  {
	if($result->num_rows > 0)
	{
	  while($row=$result->fetch_object())
	  {
		$pln[0][] = $row->id_pl;
		$pln[1][] = $row->dzien;
		$pln[2][] = $row->nr_godz;
		$pln[3][] = $row->id_przed;
		$pln[4][] = $row->gr;
		$ile++;
	  }
	}
  }
  return $pln;
}

for($i=1; $i<=120; $i++)
{
  if(isset($_POST['przed_'.$i]))
  {
	$id_pl =   htmlentities($_POST['id_pl'.$i], ENT_QUOTES, 'UTF-8');
	$dzien =  htmlentities($_POST['dzien_'.$i], ENT_QUOTES, 'UTF-8');
	$nr_godz = htmlentities($_POST['godz_'.$i], ENT_QUOTES, 'UTF-8');
	$id_przed = htmlentities($_POST['przed_'.$i], ENT_QUOTES, 'UTF-8');
	$gr = htmlentities($_POST['gr_'.$i], ENT_QUOTES, 'UTF-8');
	$id_kl = $_SESSION['id_kl'];
	
	if($id_przed != '0' && $id_pl >= 0 )
	{
		if($id_pl == 0) 
		{
		  zapytanie($dzien,$nr_godz,$id_przed,$gr,$id_kl);	  
		} elseif ($id_pl > 0)
		{
			for($j=0; $j<$ile; $j++)
			{
			  $id_pl_db = $plan_z[0][$j];
			  $dzien_db = $plan_z[1][$j];
			  $godz_db = $plan_z[2][$j];
			  $przed_db = $plan_z[3][$j];
			  $gr_db = $plan_z[4][$j];	
			  
				if($id_pl == $id_pl_db && $przed_db != $id_przed)
				{
				  if($stmt = $mysqli->prepare("UPDATE plan_zajec SET dzien = ?, nr_godz = ?, id_przed = ? , gr = ? WHERE id_pl = ?"))
				  {
					 $stmt->bind_param("iiiii",$dzien,$nr_godz,$id_przed,$gr,$id_pl);
					 $stmt->execute();
					 $stmt->close();
				  } else {
					 echo "Błąd zapytania";
				  }
				}
			}
		}
	}
	
	if($id_przed == '0' && $id_pl > 0)
	{
		  for($j=0; $j<$ile; $j++)
		  {
			$id_pl_db = $plan_z[0][$j];
			
			  if($id_pl == $id_pl_db)
			  {
				  usuwam($id_pl);
			  }
		  }
	}	  
  }
}

function zapytanie($dzien,$nr_godz,$id_przed,$gr,$id_kl)
{
 global $mysqli;

	if($stmt = $mysqli->prepare("INSERT plan_zajec (dzien,nr_godz,id_przed,gr,id_kl) VALUES (?,?,?,?,?)"))
	{
	  $stmt->bind_param("iiiii",$dzien,$nr_godz,$id_przed,$gr,$id_kl);
	  $stmt->execute();
	  $stmt->close();
	}else {
	  echo 'Błąd: ' . $mysqli->error;
	}
}

?>