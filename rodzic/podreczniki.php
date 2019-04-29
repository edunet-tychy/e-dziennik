<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
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

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

//Zmienne
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$id_db = $_SESSION['id_db'];

//Zmienna identyfikująca ucznia
$id_db = $_GET['id_ucz'];

//Obiekty
$baza = new zapytanie;

$query = "SELECT id_kl FROM uczen WHERE id_user='$id_db'";
$baza->pytanie($query);
$id_kl = $baza->tab[0];

$query = "SELECT klasa, sb FROM vklasy WHERE id_kl='$id_kl'";
$baza->pytanie($query);
$klasa = $baza->tab[0];
$sb = $baza->tab[1];

//Funkcja - View: Podręczniki
function podrecznikiKlasy($id_kl)
{
  global $mysqli;
  
  $baza = new zapytanie;
  
  if($result = $mysqli->query("SELECT * FROM klasy_podreczniki WHERE id_kl='$id_kl'"))
  {
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
          $baza->pytanie($query);
          $nazwa = $baza->tab[0];
          
          $query = "SELECT nr_dop, tytul, autorzy, wydawnictwo FROM podreczniki WHERE id_pod='$id_pod'";
          $baza->pytanie($query);
          $nr_dop = $baza->tab[0];
          $tytul = $baza->tab[1];
          $autorzy = $baza->tab[2];
          $wydawnictwo = $baza->tab[3];
          
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
  <?php include_once('menu.php');?>
  </div>   
  <div id="czescGlowna">
  <?php  
    echo '<h3 id="nagRamka">PODRĘCZNIKI KLASY '.$klasa.' '.$sb.'</h3>';
    podrecznikiKlasy($id_kl);
  ?>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>