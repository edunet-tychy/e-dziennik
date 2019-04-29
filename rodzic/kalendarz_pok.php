<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="../javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_02.js"></script>
<link href="styl/styl_szkola.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.scrollTo(0, 200)">
<?php

//Nawiązanie połączenia serwerem MySQL
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

//klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

//Zmienne
$id_db = $_SESSION['id_db'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$nr=1;

//Data
$dzisiaj = date('Y-m-d');
$pierwszy = date('Y-m-d', mktime(0,0,0,date('m'),1,date('Y')));
$ostatni = date('Y-m-d', mktime(23,59,59,date('m')+1,0,date('Y')));

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
  <h3 id="nagSzkola">KALENDRIUM AKTUALNYCH WYDARZEŃ SZKOLNYCH</h3>
	<?php
    if($result = $mysqli->query("SELECT * FROM kalendarz WHERE do >= '".$pierwszy."' AND do <= '".$ostatni."' ORDER BY od"))
    {
                
      if($result->num_rows > 0)
      {
        echo'<table id="center-2-tabela">';
        echo'<tr>';
		echo'<th>NR</th>';
        echo'<th>OD</th>';
        echo'<th>DO</th>';
        echo'<th>WYDARZENIE</th>';
        echo'</tr>';
                    
        while($row=$result->fetch_object())
        {
          echo'<tr>';
		  echo'<td>'. $nr++ .'</td>';
          echo'<td>'. $row->od .'</td>';
          echo'<td>'. $row->do .'</td>';
          echo'<td class="lewy">'. $row->tresc .'</td>';
          echo'</tr>';
        }
        
        echo'</table>';
      }else {
          echo '<img src="image/pytanie.png" alt="Brak rekordów">';
          echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
      }
    } else {
      echo 'Błąd: ' . $mysqli->error;
    }
    ?>
  <br><br>
  </div>
  <div id="stopka">
    <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>