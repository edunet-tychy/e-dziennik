<?php
  include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="../javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/jquery-1.js"></script>
<script type="text/javascript" src="javascript/jquery-ui-1.js"></script>
<script type="text/javascript" src="javascript/script_szkola.js"></script>
<link href="styl/jquery-ui-1.css" rel="stylesheet" type="text/css">
<link href="styl/styl_szkola.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
$(document).ready(function($)
{
	$(".pole-center").datepicker({dateFormat: 'yy-mm-dd', firstDay: 1, dayNamesMin: ['Nd', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So'], monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'], maxDate: new Date(2015, 7, 31), minDate: new Date(2014, 7, 1)});
	$(".pole-center-2").datepicker({dateFormat: 'yy-mm-dd', firstDay: 1, dayNamesMin: ['Nd', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So'], monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'], maxDate: new Date(2015, 7, 31), minDate: new Date(2014, 7, 1)});

});
</script>
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
  <h3 id="nagDzwonki">EDYCJA - ORGANIZACJA ROKU SZKOLNEGO</h3>
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
            echo '<td class="lewy"><input class="pole-left-2" type="text" name="wydarzenie'.$ile.'" value="'.$wiersz->wydarzenie.'"></td>';
            echo '<td class="data"><input type="text" id="od'.$ile.'" size="11" class="pole-center" name="od'.$ile.'" value="'.$wiersz->od.'"></td>';
           
           if($wiersz->do != '0000-00-00')
            {
              echo '<td class="data"><input type="text" id="do'.$ile.'" size="11" class="pole-center" name="do'.$ile.'" value="'.$wiersz->do.'"></td>';
            } else {
              echo '<td class="data"><input type="text" id="do'.$ile.'" size="11" class="pole-center-2" name="do'.$ile.'" value=""></td>';
            }
            echo '</tr>';
          }
       }	
    }
    ?>
    
    <tr><th colspan="4" class="knw"><div id="konWpis"></div></th></tr>
    </table>
    <div id="przycisk"><input type="button" value="Popraw dane" class="button" id="poprawOrgRok"></div>
  </form>
      <div id="informacje-4">
      <p>Ten formularz umożliwia wprowadzenie stałych elementów organizacyjnych roku szkolnego. Pole DO może pozostać puste.</p>
      <p id="wyr">Na przykład:</p>
      <ul>
        <li>Początek roku szkolnego 2014-09-01</li>
        <li>Zimowa przerwa świąteczna od 2014-12-23 do 2014-12-31</li>
      </ul>
    </div><br>
  </div>
  <div id="stopka">
    <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>