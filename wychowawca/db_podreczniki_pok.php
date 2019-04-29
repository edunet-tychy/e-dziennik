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

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

function zapytanie($query)
{
  global $mysqli;
  if(!$result = $mysqli->query($query))
  {
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
  }
	return $tab = $result->fetch_row();	
}

?>
<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie_db,' ',$nazwisko_db,' - ', $kto,' klasy: ', $klasa,' ', $sb; ?></p>
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
  <?php
  
  echo '<h3>PODRĘCZNIKI KLASY '.$klasa.' '.$sb.'</h3>';
  
  if($result = $mysqli->query("SELECT * FROM klasy_podreczniki WHERE id_kl='$id_kl'"))
  {
  //zwraca liczbę rekordów i sprawdzmy, czy jest ich więcej niż 0
    if($result->num_rows > 0)
    {
      $nr=0;
      
      echo'<table id="center-tabela-pod">';
      echo'<tr>';
      echo'<th>L.P.</th>';
      echo'<th>PRZEDMIOT</th>';
      echo'<th>NR DOP.</th>';
      echo'<th>TYTUŁ</th>';
      echo'<th>AUTORZY</th>';
      echo'<th>WYDAWNICTWO</th>';
      echo'</tr>';
  
        while($row=$result->fetch_object())
        {
          $id_kp = $row->id_klpd;
          $id_pod = $row->id_pod;
          $id_przed = $row->id_przed;
          $id_kl = $row->id_kl;
  
          $query = "SELECT nazwa FROM przedmioty WHERE id_przed='$id_przed'";
          $tab = zapytanie($query);
          $nazwa = $tab[0];
          
          $query = "SELECT nr_dop, tytul, autorzy, wydawnictwo FROM podreczniki WHERE id_pod='$id_pod'";
          $tab = zapytanie($query);
          $nr_dop = $tab[0];
          $tytul = $tab[1];
          $autorzy = $tab[2];
          $wydawnictwo = $tab[3];
          
          $tab_na[] = $nazwa.'; '.$nr_dop.'; '.$tytul.'; '.$autorzy.'; '.$wydawnictwo;
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
          }

      echo'</table><br><br>';
    }else {
      echo '<img src="image/pytanie.png" alt="Brak rekordów">';
      echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
    }
  }else {
  echo 'Błąd: ' . $mysqli->error;
  }
  ?>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>