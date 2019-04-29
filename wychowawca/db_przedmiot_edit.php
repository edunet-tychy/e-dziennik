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
  var url = 'db_przedmiot_pok.php';
  $("#pokazPrzedmioty").load(url);
});
</script>
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

$id_kp=$_GET['id_kp'];

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;

function baza($nazwa,$mysqli)
{
  
  if(!$zapytanie = $mysqli->query($nazwa))
  {
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
  }
  
  $wynik = $zapytanie->fetch_row();
  $id = $wynik[0];
  
  return $id;
}

function dane($nazwa,$mysqli)
{
  
  if(!$zapytanie = $mysqli->query($nazwa))
  {
   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
   $mysqli->close();
  }
  
  $wynik = $zapytanie->fetch_row();
  
  $opis[] = $wynik[0];
  $opis[] = $wynik[1];
  
  return $opis;
}

function tablica($nazwa,$mysqli)
{
  
  if(!$zapytanie = $mysqli->query($nazwa)){
	 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
  }
  
  if($zapytanie->num_rows > 0)
  {
	while($row=$zapytanie->fetch_object())
	{
	  $naucz[] = $row->id_naucz;
	}			
  } else {
	echo 'Brak rekordów';
  }
    return $naucz;
}

function id_kn($nazwa,$mysqli)
{
  
  if(!$zapytanie = $mysqli->query($nazwa)){
	 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
  }
  
  if($zapytanie->num_rows > 0)
  {
	while($row=$zapytanie->fetch_object())
	{
	  $id_kn[] = $row->id_kn;
	}			
  } else {
	echo 'Brak rekordów';
  }
    return $id_kn;
}

function przedmioty($mysqli)
{
  
  echo '<option value="x">...</option>';
  
  if($result = $mysqli->query("SELECT * FROM przedmioty"))
  {	  
	if($result->num_rows > 0)
	{
	  while($row=$result->fetch_object())
	  {
		echo '<option value="'.$row->id_przed.'">'. $row->nazwa .'</option>';
	  }
	}
  }
}

function nauczyciel($mysqli)
{
  
  echo '<option value="x">...</option>';
  
  if($result = $mysqli->query("SELECT id, nazwisko, imie FROM users WHERE id_st <> 1 AND id_st <> 2 AND id_st < 5 ORDER BY nazwisko"))
  {	  
	  if($result->num_rows > 0)
	  {
		  while($row=$result->fetch_object())
		  {
			echo '<option value="'.$row->id.'">'. $row->nazwisko .' '. $row->imie .'</option>';
		  }
	  }
  }
}

//Identyfikator przedmiotu
$zap_1 = "SELECT id_przed FROM klasy_przedmioty WHERE id_kp='$id_kp'";
$id_przed = baza($zap_1,$mysqli);
//Nazwa przedmiotu
$zap_2 = "SELECT nazwa FROM przedmioty WHERE id_przed='$id_przed'";
$przedmiot = baza($zap_2,$mysqli);

//Identyfikator nauczyciela
$zap_3 = "SELECT id_naucz FROM klasy_nauczyciele WHERE id_kp='$id_kp'";
$naucz = tablica($zap_3,$mysqli);

//Identyfikator pozycji na liście
$zap_6 = "SELECT id_kn FROM klasy_nauczyciele WHERE id_kp='$id_kp'";
$id_kn = id_kn($zap_6,$mysqli);

if(count($naucz) == 2)
{
  //Pierwszy nauczyciel
  $zap_4 = "SELECT nazwisko, imie FROM users WHERE id='$naucz[0]'";
  $naucz_1 = dane($zap_4,$mysqli);
  $_SESSION['id_kn1'] = $id_kn[0];
  //Drugi nauczyciel
  $zap_5 = "SELECT nazwisko, imie FROM users WHERE id='$naucz[1]'";
  $naucz_2 = dane($zap_5,$mysqli);
  $_SESSION['id_kn2'] = $id_kn[1];
} else {
  //Pierwszy nauczyciel
  $zap_4 = "SELECT nazwisko, imie FROM users WHERE id='$naucz[0]'";
  $naucz_1 = dane($zap_4,$mysqli);
  $_SESSION['id_kn1'] = $id_kn[0];
  $_SESSION['id_kn2'] = 0;
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
  <div class="left" id="formularz">
  <h3 id="naglPrzedmiot">EDYCJA PRZEDMIOTU</h3>
  <form action="db_przedmiot_upd.php" method="post" name="formPrzedmiot" id="formPrzedmiot">
  <input type="hidden" name="id_kp" id="id_kp" value="<?php echo $id_kp ?>">
    <table id="przedmioty">
    <tr><td class="dane">Przedmiot:*</td><td>
      <select name="przedmiot" id="przedmiot">
        <?php
        echo '<option class="op" value="'.$id_przed.'">'.$przedmiot.'</option>';
        echo przedmioty($mysqli);
        ?>
      </select>
    </td></tr>
    <tr><td class="dane">Nauczyciel 1:*</td><td>
      <select name="id_naucz1" id="id_naucz1">
        <?php
          if(isset($naucz[0]))
          {
            echo '<option class="op" value="'.$naucz[0].'">'.$naucz_1[0].' ' .$naucz_1[1] . '</option>';
          }
          echo nauczyciel($mysqli);
        ?>
      </select>
    </td></tr>
    <tr>
    <td class="dane">Nauczyciel 2:&nbsp;</td><td>
      <select name="id_naucz2" id="id_naucz2">
        <?php
          if(isset($naucz[1]))
          {
            echo '<option class="op" value="'.$naucz[1].'">'.$naucz_2[0].' ' .$naucz_2[1] . '</option>';
          }
          echo nauczyciel($mysqli);	
        ?>
      </select>      
    </td></tr>
    <tr>
      <td></td><td><input type="button" value="Popraw przedmiot" class="przycisk" id="poprawPrzedmiot"></td>
    </tr>
    </table>
  </form>
    <div id="informacje">
    <p>* - w tym polu dane są obowiązkowe</p>
    </div>
  </div>
  <div class="right">
  <h3>LISTA PRZEDMIOTÓW I NAUCZYCIELI KLASY <?php echo $klasa .' '.$sb ?></h3>
  <div id="pokazPrzedmioty">
  </div>
      <br><br>
  </div>

  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>