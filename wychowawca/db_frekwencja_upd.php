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
$data = $_POST['data'];
$ile = $_POST['ile'];

for($i=1; $i <= $ile; $i++)
{
	$tab = $_POST['dane'.$i];
	$_POST[$tab];
	$frek[] = $tab.'; '.$_POST[$tab];
}

for($i=0; $i < $ile; $i++)
{
  $frek[$i];
  $ucz = explode('; ', $frek[$i]);
  
  $rok = substr($data,0,4);
  $miesiac = substr($data,5,2);
  $rokMiesac = $rok.'-'.$miesiac;
  $dzienBiezacy = substr($data,8,2);
  $dzienTygodnia = date("w",strtotime($data));
  
  $dl = strlen($ucz[0]);
  
  switch ($dl){
    case 7: $d=4; break;
    case 6: $d=3; break;
    case 5: $d=2; break;
	} 
  $dzienTygodniaTabela = substr($ucz[0],$d,1);
  
  if($dzienTygodnia < $dzienTygodniaTabela)
  {
	 $roznica = $dzienTygodniaTabela-$dzienTygodnia;
	 $dzienBiezacy = $dzienBiezacy + $roznica;
	 if($dzienBiezacy < 10)
	 {
		 $dzienBiezacy = '0'.$dzienBiezacy;
	 }
  } elseif($dzienTygodnia == $dzienTygodniaTabela)
  {
	 $dzienBiezacy = $dzienBiezacy;
  } elseif($dzienTygodnia > $dzienTygodniaTabela)
  {
	 $roznica = $dzienTygodnia-$dzienTygodniaTabela;
	 $dzienBiezacy = $dzienBiezacy - $roznica;
	 if($dzienBiezacy < 10)
	 {
		 $dzienBiezacy = '0'.$dzienBiezacy;
	 } 
  }
  
  $rokMiesacDzien = $rokMiesac.'-'.$dzienBiezacy;
 
  switch ($dl){
    case 7: $poz=3; $g=6; break;
    case 6: $poz=2; $g=5; break;
    case 5: $poz=1; $g=4; break;
	}
  $rokMiesacDzien;
  $id_ucz = substr($ucz[0],0,$poz);
  $godzina = substr($ucz[0],$g,1);
  $stan = $ucz[1];

  frek_upd_del($rokMiesacDzien,$godzina,$stan,$id_ucz);
}

function frek_upd_del($rokMiesacDzien,$godzina,$stan,$id_ucz)
{
  global $mysqli;
  
  if($result = $mysqli->query("SELECT * FROM frekwencja WHERE data='$rokMiesacDzien' AND godzina='$godzina' AND id_ucz='$id_ucz'"))
  {
	if($result->num_rows > 0)
	{
	  $row=$result->fetch_object();
	  
	   if(($rokMiesacDzien != '' && $godzina != '' && $id_ucz != '') && ($stan == 's' || $stan == 'u' || $stan == 'n' || $stan == 'o') && ($stan != $row->stan))
	   {		   
		  if($stmt = $mysqli->prepare("UPDATE frekwencja SET stan = ? WHERE data = ? AND godzina = ?  AND id_ucz = ? "))
		  {
			 $stmt->bind_param("ssii",$stan,$rokMiesacDzien,$godzina,$id_ucz);
			 $stmt->execute();
			 $stmt->close();
		  } else {
			 echo "Błąd zapytania";
		  }
	   }

	   if($stan == '')
	   {
		  while($row=$result->fetch_object())
		  {
			$id_frek = $row->id_frek;
		  }
		  
		  if($stmt=$mysqli->prepare("DELETE FROM frekwencja WHERE id_frek = ?"))
		  {
			  $stmt->bind_param("i", $id_frek);
			  $stmt->execute();
			  $stmt->close();
		  } else {
			  echo 'Błąd zapytania';
		  }	
	   }
	}
  } else {
	  echo 'Błąd: ' . $mysqli->error;
  }
}

?>