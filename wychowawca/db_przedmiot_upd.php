<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
</head>
<body>
<?php
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');
 
//Sprawdzenie nawiązania połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

$id_kl = $_SESSION['id_kl'];
$id_kn1 = $_SESSION['id_kn1'];
$id_kn2 = $_SESSION['id_kn2'];

$id_kp = htmlentities($_POST['id_kp'], ENT_QUOTES, 'UTF-8');
$id_przed = htmlentities($_POST['przedmiot'], ENT_QUOTES, 'UTF-8');
$id_naucz1 = htmlentities($_POST['id_naucz1'], ENT_QUOTES, 'UTF-8');
$id_naucz2 = htmlentities($_POST['id_naucz2'], ENT_QUOTES, 'UTF-8');


//sprawdzenie, czy w bazie istnieje podany przedmiot
if($result = $mysqli->query("SELECT * FROM klasy_przedmioty WHERE id_kp='$id_kp' AND id_kl='$id_kl'"))
{
//zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
  if($result->num_rows == 1)
  {        
	 if($id_przed == '')
	 {
		$error = 'Wypełnij wszystkie pola!';
	 } else {
		if($stmt = $mysqli->prepare("UPDATE klasy_przedmioty SET id_przed = ? WHERE id_kp = ? AND id_kl= ? "))
		{
		   $stmt->bind_param("iii",$id_przed,$id_kp,$id_kl);
		   $stmt->execute();
		   $stmt->close();
		} else {
		   echo "Błąd zapytania";
		}
	 }
  }
} else {
	echo 'Błąd: ' . $mysqli->error;
}

//NAUCZYCIEL I
if(isset($id_kn1))
{
  if($stmt = $mysqli->prepare("UPDATE klasy_nauczyciele SET id_naucz = ? WHERE id_kn = ?"))
	{
	   $stmt->bind_param("ii",$id_naucz1,$id_kn1);
	   $stmt->execute();
	   $stmt->close();
	} else {
	   echo "Błąd zapytania";
	}	
}
		
//NAUCZYCIEL II
if(isset($id_kn2))
{
  if($stmt = $mysqli->prepare("UPDATE klasy_nauczyciele SET id_naucz = ? WHERE id_kn = ?"))
	{
	   $stmt->bind_param("ii",$id_naucz2,$id_kn2);
	   $stmt->execute();
	   $stmt->close();
	} else {
	   echo "Błąd zapytania";
	}	
}

if($result = $mysqli->query("SELECT id_naucz FROM klasy_nauczyciele WHERE id_kp='$id_kp'"))
{
  if($result->num_rows < 2)
  {
	if($id_naucz2 != 0)
	{
	  if($stmt = $mysqli->prepare("INSERT klasy_nauczyciele (id_kp,id_naucz) VALUES (?,?)"))
	  {
		$stmt->bind_param("ii",$id_kp,$id_naucz2);
		$stmt->execute();
		$stmt->close();
	  }
	}
  }
}



//Usunięcie pustej wartości NAUCZYCIEL II
if($result = $mysqli->query("SELECT id_kn FROM klasy_nauczyciele WHERE id_naucz=0"))
{
  if($result->num_rows > 0)
  {
	while($row=$result->fetch_object())
	{
	  $id_kn = $row->id_kn;
	  
	  if($stmt=$mysqli->prepare("DELETE FROM klasy_nauczyciele WHERE id_kn = ?"))
	  {
		  $stmt->bind_param("i", $id_kn);
		  $stmt->execute();
		  $stmt->close();
	  } else {
		  echo 'Błąd zapytania';
	  }			
	}
  }
}


?>
</body>
</html>