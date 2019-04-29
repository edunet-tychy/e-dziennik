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
$msc = htmlentities($_POST['miesiac'], ENT_QUOTES, 'UTF-8');
$id_user = $_SESSION['id_db'];
$id_kl=$_GET['id_kl'];
$id_przed=$_GET['id_przed'];

for($i=0; $i<10; $i++)
{
  $zagadnienie= htmlentities($_POST['wpis_'.$i], ENT_QUOTES, 'UTF-8');
  $il_godz = htmlentities($_POST['godz_'.$i], ENT_QUOTES, 'UTF-8');
  
  zapytanie($msc,$zagadnienie,$il_godz,$id_user,$id_kl,$id_przed);
}

function zapytanie($msc,$zagadnienie,$il_godz,$id_user,$id_kl,$id_przed)
{
 global $mysqli;

  if($msc != '' && $zagadnienie != '' && $il_godz != '0' && $id_user != '' && $id_kl != '' && $id_przed != '')
  {
	if($stmt = $mysqli->prepare("INSERT rozklad (msc,zagadnienie,il_godz,id_user,id_kl,id_przed) VALUES (?,?,?,?,?,?)"))
	{
	  $stmt->bind_param("isiiii",$msc,$zagadnienie,$il_godz,$id_user,$id_kl,$id_przed);
	  $stmt->execute();
	  $stmt->close();
	}else {
	  echo 'Błąd: ' . $mysqli->error;
	}
  }
}
?>