<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<link href="styl/styl_log.css" rel="stylesheet" type="text/css">
<link href="styl/styl_login.css" rel="stylesheet" type="text/css">
<link href="styl/print.css" rel="stylesheet" type="text/css" media="print">
<script type="text/javascript">
function drukuj(){
  alert("Zalecana orientacja wydruku: pionowo")
 // sprawdź możliwości przeglądarki
   if (!window.print){
      alert("Twoja przeglądarka nie drukuje!")
   return 0;
   }
 window.print(); // jeśli wszystko ok drukuj
}
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

?>

<div id="kontener">
  <div id="logo">
    <img src="../image/logo_user.png" alt="Logo">
    <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $_SESSION['imie_db'],' ',$_SESSION['nazwisko_db'],' - ', $_SESSION['kto'];?></p>
  </div>
  <div id="opis"><div id="nowosc"><?php $wiadomosc->wiadomosc(); ?></div><p class="info"><a class="linki" href="../logout.php">Wylogowanie</a></p></div>
  <div id="spis"><?php include_once('menu.php');?></div>
  <div id="czescGlowna">
  <h3 id="nagRamka">ZESTAWIENIE LOGINÓW NAUCZYCIELI</h3>
  <div id="time-2"><a href="javascript:drukuj()"><img src="image/printer.png" alt="Drukarka" title="Drukuj"></a></div>
    <table id="zestawienie-3">
    <tr><th>LP</th><th>Nazwisko</th><th>Imię</th><th>Login</th><th>Hasło</th></tr>
    
	<?php
    if($result = $mysqli->query("SELECT nazwisko,imie,login,haslo FROM users WHERE id_st = 3 OR id_st = 4 ORDER BY nazwisko"))
    {
    //Sprawdzamy, czy rekordów jest więcej niż 0
      if($result->num_rows > 0)
      {
        $nr=1;	
        //Generujemy wiersze
        while($row=$result->fetch_object())
        {
          echo'<tr>';
          echo'<td class="nr">'. $nr .'</td>';
          echo'<td class="daneUser">'. $row->nazwisko .'</td>';
          echo'<td class="daneUser">'. $row->imie .'</td>';
          echo'<td class="loginUser">'. $row->login .'</td>';
          echo'<td class="loginUser">'. $row->haslo .'</td>';
          echo'</tr>';
          $nr++;
        }
      }else {
        echo '<img src="image/pytanie.png" alt="Brak rekordów">';
        echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
      }
    }else {
      echo 'Błąd: ' . $mysqli->error;
    }
    ?>
    </table><br><br>
  </div>
  <div id="stopka"><p class="stopka">&copy; G.Szymkowiak 2014/2015</p></div>
</div>
</body>
</html>