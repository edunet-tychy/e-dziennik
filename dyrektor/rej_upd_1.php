<?php
include_once('status.php');

include("class/pData.class.php");
include("class/pDraw.class.php");
include("class/pImage.class.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_03.js"></script>
<link href="styl/styl_stat.css" rel="stylesheet" type="text/css">
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

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Zmienne
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];

//Obiekty
$wiadomosc = new news;
$baza = new zapytanie;
$query = "SELECT * FROM pop_oceny_1 ORDER BY id_przed";
$baza->pytanie($query);
$old = $baza->tab[0];
$new = $baza->tab[1];
$data = $baza->tab[2];
$id_przed = $baza->tab[3];
$id_user = $baza->tab[4];
$id_kl = $baza->tab[6];

//Funkcja - View: rejUpdate
function rejestrUpdate()
{
  global $mysqli;
  
  $baza = new zapytanie;
  
  if($result = $mysqli->query("SELECT * FROM pop_oceny_1 ORDER BY id_przed"))
  {
    if($result->num_rows > 0)
    {
      $nr=0;
      
      echo'<table id="center-tabela-pod">';
      echo'<tr>';
      echo'<th>L.P.</th>';
      echo'<th>OC. POP.</th>';
      echo'<th>OC. NAST.</th>';
      echo'<th>DATA ZMIANY</th>';
      echo'<th>PRZEDMIOT</th>';
      echo'<th>UCZEŃ</th>';
	  echo'<th>NAUCZYCIEL</th>';
      echo'<th>KLASA</th>';
      echo'</tr>';
  
        while($row=$result->fetch_object())
        {
			
		
          $old = $row->old;
          $new = $row->new;
          $data = $row->data;
          $id_przed = $row->id_przed;
		  $id_user = $row->id_user;		  
          $id_kl = $row->id_kl;

          $query = "SELECT nazwa FROM przedmioty WHERE id_przed='$id_przed'";
          $baza->pytanie($query);
          $nazwa = $baza->tab[0];

          $query = "SELECT imie, nazwisko FROM users WHERE id='$id_user'";
          $baza->pytanie($query);
          $imie = $baza->tab[0];
		  $nazwisko = $baza->tab[1];
		  
		  $query = "SELECT klasa, sb FROM vklasy WHERE id_kl='$id_kl'";
          $baza->pytanie($query);
          $klasa = $baza->tab[0];
		  $sb = $baza->tab[1];
		  
		  $query = "SELECT id_kp FROM klasy_przedmioty WHERE id_przed='$id_przed' AND id_kl='$id_kl'";
          $baza->pytanie($query);
          $id_kp = $baza->tab[0];
		  
		  $query = "SELECT id_naucz FROM klasy_nauczyciele WHERE id_kp='$id_kp'";
          $baza->pytanie($query);
          $id_naucz = $baza->tab[0];
		  
		  $query = "SELECT imie, nazwisko FROM users WHERE id='$id_naucz'";
          $baza->pytanie($query);
          $imieN = $baza->tab[0];
		  $nazwiskoN = $baza->tab[1];
          
          $tab_na[] = $old.'; '.$new.'; '.$data.'; '.$nazwa.'; '.$imie.' '.$nazwisko.'; '.$imieN.' '.$nazwiskoN.'; '.$klasa.' '.$sb;
        }
  
          sort($tab_na);
          foreach($tab_na as $dane)
          {
            $dane = explode('; ', $dane);
            $nr++;
            echo'<tr>';
            echo'<td>'. $nr .'</td>';
            echo'<td>'. $dane[0] .'</td>';
            echo'<td>'. $dane[1] .'</td>';
            echo'<td>'. $dane[2] .'</td>';	
            echo'<td>'. $dane[3] .'</td>';
            echo'<td>'. $dane[4] .'</td>';
			echo'<td>'. $dane[5] .'</td>';
			echo'<td>'. $dane[6] .'</td>';		 		 
          }
  
      echo'</table><br><br>';
    }else {
      echo '<img src="image/pytanie.png" alt="Brak rekordów">';
      echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
    }
  }else {
  echo 'Błąd: ' . $mysqli->error;
  }
}

?>

<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie_db,' ',$nazwisko_db,' - ', $kto; ?></p>
  </div>
  <div id="opis"><div id="nowosc"><?php $wiadomosc->wiadomosc(); ?></div>
   <p class="info">
   <a class="linki" href="../logout.php">Wylogowanie</a>
   </p>
  </div>
  <div id="spis">
  <?php include_once('menu.php'); ?>
  </div>   
  <div id="czescGlowna">
    <div id="lista" class="zawartosc">
      <?php 
		echo '<h3>REJESTR POPRAWIONYCH OCEN - SEMESTR I</h3>';
		rejestrUpdate();
	  ?>
    </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>