<?php
  include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="../javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_szkola.js"></script>
<link href="styl/styl_szkola.css" rel="stylesheet" type="text/css">

</head>
<body onload="window.scrollTo(0, 200)">

<?php
//Nawiązanie połączenia serwerem MySQL.
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
$id_db = $_SESSION['id_db'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];

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
  <h3 id="nagDzwonki">ORGANIZACJA ROKU SZKOLNEGO</h3>
  <form action="db_org_roku_upd.php" method="post" name="formUp" id="formUp">
  
    <table id="orgRokuSzkol">
    <tr><th>NR</th><th>WYDARZENIE</th><th>OD</th><th>DO</th></tr>
  
    <?php
    $zapytanie = "SELECT * FROM org_roku_szkol";
    
    if($odp = $mysqli->query($zapytanie))
    {
      if($odp->num_rows > 0)
       {
          $ile=0;
          while($wiersz=$odp->fetch_object())
          {
            $ile++;
            echo '<input type="hidden" name="wydarzenie'.$ile.'" value="'.$wiersz->wydarzenie.'">';
            echo '<tr>';
            echo '<td class="nr">'.$ile.'</td>';
            echo '<td class="lewy">'.$wiersz->wydarzenie.'</td>';
            echo '<td class="data">'.$wiersz->od.'</td>';
           
           if($wiersz->do != '0000-00-00')
            {
              echo '<td class="data">'.$wiersz->do.'</td>';
            } else {
              echo '<input type="hidden" name="do'.$ile.' value="pusty">';
              echo '<td class="data"> </td>';
            }
            echo '</tr>';
          }
       }	
    }
    ?>
    </table>
  </form>
  <br><br>
  </div>
  <div id="stopka">
    <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>