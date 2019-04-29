<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function()
{
//Dodanie przedmiotu do klasy	
	$("#zapiszPlan").click(function()
	{
		var dane = $("form").serialize();
		var url = $("form").attr("action");
		var art = 'db_plan.php';
		$.post(url, dane, function()
		{
		  $(location).attr('href',art);
		});
		
		$("#konWpisPlan").html("Dane są zapisywane! <img src='image/ajax-loader.gif' id='loader-2'>")
	});
});
</script>
</head>
<body onload="window.scrollTo(0, 200)">
<?php
//Nawiązanie połączenia z serwerem MySQL
include_once('db_connect.php');
 
//Sprawdzenie nawiązania połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//Zmienne
$id_kl = $_SESSION['id_kl'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$klasa = $_SESSION['klasa'];
$sb = $_SESSION['sb'];
$ile = 0;

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

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

function przedmioty()
{
  global $mysqli;
  global $id_kl;
  if($result = $mysqli->query("SELECT * FROM klasy_przedmioty WHERE id_kl='$id_kl'"))
  {
	if($result->num_rows > 0)
	{
	  while($row=$result->fetch_object())
	  {
		  $id_przed = $row->id_przed;
		  
		  $przedmiot = "SELECT nazwa FROM przedmioty WHERE id_przed='$id_przed'";
		  
		  if(!$zapytanie1 = $mysqli->query($przedmiot))
		  {
		   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
		   $mysqli->close();
		  }
		  
		  $wynik = $zapytanie1->fetch_row();
		  $nazwa = $wynik[0];
		  
		  $tab_przedmioty[] = $nazwa.'; '.$id_przed;
	  }
	}
  }
  
  if(isset($tab_przedmioty))
  {
	sort($tab_przedmioty);
	
	foreach($tab_przedmioty as $tab_przedmiot)
	{
	  $przed = explode('; ', $tab_przedmiot);
	  echo'<option value="'.$przed[1].'">'.$przed[0].'</option>';
	}
  }
  
}

function przedmiot($id_przed)
{
  global $mysqli;

  $przedmiot = "SELECT nazwa FROM przedmioty WHERE id_przed='$id_przed'";
  
  if(!$zapytanie1 = $mysqli->query($przedmiot))
  {
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
  }
  
  $wynik = $zapytanie1->fetch_row();
  $nazwa = $wynik[0];
  
  echo'<option value="'.$id_przed.'">'.$nazwa.'</option>';
}

function szkielet()
{
  global $ile;
  global $mysqli;
  $zaj = 0;
  $up_1 = 0;
  $up_2 = 0;
  $id_1 = 0;
  $id_2 = 0;
  $plan_z = plan();
  
  if($result = $mysqli->query("SELECT nr, pocz, kon FROM godziny WHERE pocz != ''"))
  {	  
	if($result->num_rows > 0)
	{
		while($row=$result->fetch_object())
		{
		  echo '<tr><th class="ng" rowspan="2">'.$row->nr.'</th><td rowspan="2" class="godz">'. $row->pocz .'-'. $row->kon .'</td><td class="gr">1</td>';
		  for($i=0; $i<5; $i++)
		  {
			$zaj++;
			$up_1=0;
			echo '<input type="hidden" name="dzien_'.$zaj.'" value="'.$i.'">';
			echo '<input type="hidden" name="godz_'.$zaj.'" value="'.$row->nr.'">';
			echo '<input type="hidden" name="gr_'.$zaj.'" value="1">';
			echo '<td>';
			echo '<select class="min-3" name="przed_'.$zaj.'">';
			
			for($j=0; $j<$ile; $j++)
			{
			  $id_pl = $plan_z[0][$j];
			  $dzien = $plan_z[1][$j];
			  $godz = $plan_z[2][$j];
			  $przed = $plan_z[3][$j];
			  $gr = $plan_z[4][$j];
			  
			  if($dzien == $i && $godz == $row->nr && $gr == 1)
			  {
			   przedmiot($przed);
			   $up_1=1;
			   $id_1=$id_pl;
			  }
			}
			echo '<option value="0">...</option>';
			przedmioty();
			echo '</select>';
			if($up_1==1)
			{
				echo '<input type="hidden" name="id_pl'.$zaj.'" value="'.$id_1.'">';
			} else {
				echo '<input type="hidden" name="id_pl'.$zaj.'" value="0">';
			}
			echo '</td>';
		  }
		  echo '</tr>';
		  echo '<tr><td class="gr-2">2</td>';
		  for($i=0; $i<5; $i++)
		  {
			$zaj++;
			$up_2=0;
			echo '<input type="hidden" name="dzien_'.$zaj.'" value="'.$i.'">';
			echo '<input type="hidden" name="godz_'.$zaj.'" value="'.$row->nr.'">';
			echo '<input type="hidden" name="gr_'.$zaj.'" value="2">';
			echo '<td class="dwa">';
			echo '<select class="min-3" name="przed_'.$zaj.'">';
			for($j=0; $j<$ile; $j++)
			{
			  $id_pl = $plan_z[0][$j];
			  $dzien = $plan_z[1][$j];
			  $godz = $plan_z[2][$j];
			  $przed = $plan_z[3][$j];
			  $gr = $plan_z[4][$j];
			  
			  if($dzien == $i && $godz == $row->nr && $gr == 2)
			  {
			   przedmiot($przed);
			   $up_2=1;
			   $id_2=$id_pl;
			  }
			}
			echo '<option value="0">...</option>';
			przedmioty();
			echo '</select>';
			if($up_2==1)
			{
				echo '<input type="hidden" name="id_pl'.$zaj.'" value="'.$id_2.'">';
			} else {
				echo '<input type="hidden" name="id_pl'.$zaj.'" value="0">';
			}
			
			echo '</td>';
		  }
		  echo '</tr>';
		}
	}
  }	
}

?>

<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie_db,' ',$nazwisko_db,' - ', $_SESSION['kto']; ?></p>
  </div>
  <div id="opis"><div id="nowosc"><?php $wiadomosc->wiadomosc(); ?></div>
   <p class="info">
   <a class="linki" href="../logout.php">Wylogowanie</a>
   </p>
  </div>
  <div id="spis">
  <?php include_once('menu.php');?>
  </div>   
  <div id="czescGlowna">
  <h3 id="nagRamka">PLAN ZAJĘĆ KLASY <?php echo $klasa. ' '. $sb?></h3>
  <form action="db_plan_dod.php" method="post" name="form" id="form">
    <table id="plan">
      <tr>
        <th colspan="3">LEKCJA</th>
        <th>PONIEDZIAŁEK</th>
        <th>WTOREK</th>
        <th>ŚRODA</th>
        <th>CZWARTEK</th>
        <th>PIĄTEK</th>
      </tr>
      <?php szkielet(); ?>
      <tr>
        <td colspan="8" class="infor"><div id="konWpisPlan"></div></td>
      </tr>
    </table>
    
    <div id="przycisk"><input type="button" value="Zapisz plan zajęć" class="button" id="zapiszPlan"></div>

  </form>
  <br><br>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>