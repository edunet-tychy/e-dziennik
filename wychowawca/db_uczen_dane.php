<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="../javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
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

//Zmienne
$id_kl = $_SESSION['id_kl'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$klasa = $_SESSION['klasa'];
$sb = $_SESSION['sb'];
$id = $_GET['id'];

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;
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
  <div id="klasa">
  <ul class="nawigacja">
  <li><a href="db_uczen.php" class="zakladki" id="z_01">LISTA UCZNIÓW</a></li>
  <li><a href="db_uczen_edit.php?id=<?php echo $id ?>" class="zakladki" id="z_02">EDYTUJ UCZNIA</a></li>
  </ul>
  <div id="obramowanie">
  <?php
    
    //Dane z tabeli USER
    if($result = $mysqli->query("SELECT * FROM users WHERE id='$id'"))
    {
      if($result->num_rows > 0)
      {
          while($row=$result->fetch_object())
          {
              $nazwisko = $row->nazwisko;
              $imie = $row->imie;
          }
      }
    }
    echo '<h3 id="dane-ucznia">'.mb_strtoupper($nazwisko,"UTF-8").' '.mb_strtoupper($imie,"UTF-8").'</h3>';
   
    //Dane z tabeli UCZEN
    if($result = $mysqli->query("SELECT * FROM uczen WHERE id_user='$id'"))
    {  
      if($result->num_rows > 0)
      {
          echo'<table id="center-tabela">';
          echo'<tr>';
          echo'<th>NR EWIDENCYJNY</th>';
          echo'<th>PESEL</th>';
          echo'<th>DATA URODZENIA</th>';
          echo'<th>MIEJSCE URODZENIA</th>';
          echo'</tr>';

          while($row=$result->fetch_object())
          {
              $id_ucz = $row->id_ucz;
              echo'<tr>';
              echo'<td>'. $row->nr_ewid .'</td>';
              echo'<td>'. $row->pesel .'</td>';
              echo'<td>'. $row->data_ur .'</td>';
              echo'<td>'. $row->miejsce_ur .'</td>';
              echo'</tr>';
          }
       echo'</table>';
      }
    }
    
    //Dane z tabeli RODZICE  - id
    $query = "SELECT id_rodz FROM rodzice WHERE id_ucz='$id_ucz'";
    
    if(!$result = $mysqli->query($query))
    {
       echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
       $mysqli->close();
    }
    
    $row = $result->fetch_row();
    $id_rodz = $row[0]; 
    
    //Dane z tabeli RODZIC
    if($result = $mysqli->query("SELECT * FROM rodzic WHERE id_rodz='$id_rodz'"))
    {		
      if($result->num_rows > 0)
      {
          while($row=$result->fetch_object())
          {
            $imieM = $row->imieM;
            $imieO = $row->imieO;
            $nazwiskoR = $row->nazwisko;
            $id_ad = $row->id_ad;
            $id_tel = $row->id_tel;
            $id_user = $row->id_user;
          }
      }
    }
    
   //Dane z tabeli ADRES
    if($result = $mysqli->query("SELECT * FROM adresy WHERE id_ad='$id_ad'"))
    {
      if($result->num_rows > 0)
      {
          while($row=$result->fetch_object())
          {
            $ulica = $row->ulica;
            $lokal = $row->lokal;
            $miasto = $row->miasto;
            $kod = $row->kod;
            $woj = $row->woj;
          }
      }
    }
    
    //Dane z tabeli TELEFONY
    if($result = $mysqli->query("SELECT * FROM telefony WHERE id_tel='$id_tel'"))
    {
      if($result->num_rows > 0)
      {
          while($row=$result->fetch_object())
          {
            $telefon = $row->numer;
          }
      }
    }
    
    //Dane z tabeli USERS
    if($result = $mysqli->query("SELECT * FROM users WHERE id='$id_user'"))
    {
      if($result->num_rows > 0)
      {
          while($row=$result->fetch_object())
          {
            $email = $row->email;
          }
      }
    }	  
    
    echo'<br><table id="center-tabela">';
    echo'<tr>';
    echo'<th>RODZICE</th>';
    echo'</tr>';	    
    echo'<tr><td>'. $imieM .' '. $nazwiskoR.', ' . $imieO . ' ' . $nazwiskoR. '</td></tr>';
    echo'</table>';
    
    echo'<br><table id="center-tabela">';
    echo'<tr>';
    echo'<th>ADRES ZMIESZKANIA</th>';
    echo'</tr>';	    
    echo'<tr><td>ul. '. $ulica .' '. $lokal.',  kod ' . $kod . ' ' . $miasto. '</td></tr>';
    echo'</table>';

    echo'<br><table id="center-tabela">';
    echo'<tr>';
    echo'<th>KONTAKT</th>';
    echo'</tr>';	    
    echo'<tr><td>telefon: '. $telefon .',  email: ' . $email . '</td></tr>';
    echo'</table>';
    ?>
</div>
</div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>