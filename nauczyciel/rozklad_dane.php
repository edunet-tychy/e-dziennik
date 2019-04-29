<?php
include_once('status.php');
$_SESSION['wstecz'] = 1;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_r.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.scrollTo(0, 200)">
<?php
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Klasa
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Zmienne
$kto=$_SESSION['zalogowany'];
$nazwisko = $_SESSION['nazwisko_db'];
$imie = $_SESSION['imie_db'];
$rola = $_SESSION['rola_db'];
$id = $_SESSION['id_db'];
$id_kl = $_GET['id_kl'];

//Obiekt
$wiadomosc = new news;
$baza = new zapytanie;
$kl = "SELECT klasa, sb FROM vklasy WHERE id_kl='$id_kl'";
$baza->pytanie($kl);
$klasa = $baza->tab[0];	
$sb = $baza->tab[1];

$_SESSION['klasa'] = $klasa;
$_SESSION['sb'] = $sb;

function przedmiot($id, $id_kl,$mysqli)
{
  $nr=0;
  if($result = $mysqli->query("SELECT id_kp FROM klasy_nauczyciele WHERE id_naucz='$id'"))
  {
	if($result->num_rows > 0)
	{
	  while($row=$result->fetch_object())
	  {
		$id_kp = $row->id_kp;
		if($result2 = $mysqli->query("SELECT id_przed FROM klasy_przedmioty WHERE id_kp='$id_kp' AND id_kl='$id_kl'"))
		{
		  if($result2->num_rows > 0)
		  {
			while($row2=$result2->fetch_object())
			{
			  $id_przed=$row2->id_przed;			
			  if($result3 = $mysqli->query("SELECT nazwa FROM przedmioty WHERE id_przed='$id_przed'"))
			  {
				
				if($result3->num_rows > 0)
				{
				  while($row3=$result3->fetch_object())
				  {
					$nazwa = $row3->nazwa;
					
					if(isset($_GET['id_przed']))
					{
					  if($id_przed == $_GET['id_przed'])
					  {
						echo' <li><a href="#" title="Przedmiot aktywny" class="zajecia aktywna" id="rozklad_pok.php?id_kl='.$id_kl.'&id='.$id.'&id_przed='.$id_przed.'">' .$nazwa. '</a></li>';
						$nr++;
					  } else {
						echo' <li><a href="#" title="Przedmiot" class="zajecia" id="rozklad_pok.php?id_kl='.$id_kl.'&id='.$id.'&id_przed='.$id_przed.'">' .$nazwa. '</a></li>';
					  }						
					} else {
					  if($nr==0)
					  {
						echo' <li><a href="#" title="Przedmiot aktywny" class="zajecia aktywna" id="rozklad_pok.php?id_kl='.$id_kl.'&id='.$id.'&id_przed='.$id_przed.'">' .$nazwa. '</a></li>';
						$nr++;
					  } else {
						echo' <li><a href="#" title="Przedmiot" class="zajecia" id="rozklad_pok.php?id_kl='.$id_kl.'&id='.$id.'&id_przed='.$id_przed.'">' .$nazwa. '</a></li>';
					  }						
					}
				  }
				}  
			  }			  
			}
		  }
		}
	  }
	}
  }
}

function iden($kto)
{
  if($_SESSION['kto'] == "Wychowawca")
  {
	 return $_SESSION['idenfyfikator'];
  }	else {
	 return $_SESSION['kto'];
  }
}
?>

<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $_SESSION['imie_db'],' ',$_SESSION['nazwisko_db'],' - '. iden($kto); ?></p>
  </div>
  <div id="opis"><div id="nowosc"><?php $wiadomosc->wiadomosc(); ?></div>
   <p class="info"><a class="linki" href="../logout.php">Wylogowanie</a></p>
  </div>
  <div id="spis">
    <?php include_once('menu.php');?>
  </div>
  
  <div id="czescGlowna">
      <ul class="nawigacja_new"><?php przedmiot($id,$id_kl,$mysqli); ?></ul>
      <div id="lista" class="zawartosc">
        <h3 id="nagRamka2">ROZKŁAD MATERIAŁU DLA KLASY - <?php echo $klasa . ' ' . $sb?></h3>
        <ul class="nawigacja_pr">
        <li><a href="#" title="Zagadnienie" class="zaj" id="Zagadnienie">Dodaj zagadnienie</a></li>
        </ul>
        <div id="user"></div><br><br>
      </div>
  </div>
  <div id="stopka">
    <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>