<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_d.js"></script>
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

//klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Zmienne
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];
$klasa = $_SESSION['klasa'];
$sb = $_SESSION['sb'];
$id_przed = $_GET['id_przed'];
$id_zag = 	$_GET['id_zag'];

//Obiekty
$wiadomosc = new news;
$baza = new zapytanie;
$query = "SELECT nazwa FROM przedmioty WHERE id_przed='$id_przed'";
$baza->pytanie($query);
$nazwa = $baza->tab[0];

$query = "SELECT * FROM rozklad WHERE id_zag = '$id_zag'";
$baza->pytanie($query);

$msc = $baza->tab[1];
$wpis = $baza->tab[2];
$godz = $baza->tab[3];

function miesiac($i)
{
  switch($i){
	case 1 : return "Wrzesień"; break;
	case 2 : return "Październik"; break;
	case 3 : return "Listopad"; break;
	case 4 : return "Grudzień"; break;
	case 5 : return "Styczeń"; break;
	case 6 : return "Luty"; break;
	case 7 : return "Marzec"; break;
	case 8 : return "Kwiecień"; break;
	case 9 : return "Maj"; break;
	case 10 : return "Czerwiec"; break;
  }			
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
    <div id="lista" class="zawartosc">
      <h3 id="nagRamka1"><?php echo mb_strtoupper($nazwa,"UTF-8"); ?> - POPRAW ZAGADNIENIE - KLASA <?php echo $klasa .' '. $sb; ?></h3>
      <form action="rozklad_upd.php?id_zag=<?php echo $_GET['id_zag'];?>&id_kl=<?php echo $_GET['id_kl'];?>&id_przed=<?php echo $_GET['id_przed'];?>" method="post" name="form" id="form">
        <table id="center-tabela-pod-3">
        <tr><td class="dane-3" colspan="2">Miesiąc realizacji:*</td></tr>
        <tr><td class="dane-3" colspan="2">
        <?php
          echo'<select class="min-1" name="miesiac">';
            for($i=1; $i<=10; $i++)
            {
              if($msc == $i)
              {
				echo'<option value="'.$i.'" selected>'.miesiac($i).'</option>';
              } else {
				echo'<option value="'.$i.'">'.miesiac($i).'</option>';
              }
            }
          echo'</select>';
        ?>
        </td></tr>
        <tr><td class="dane-3" colspan="2">Treść zagadnienia:*</td></tr>
        <?php
          echo'<tr>';
          echo'<td class="dane-3">';
          echo'<input class="dane" type="text" name="wpis" id="" value="'.$wpis.'">';
          echo'</td>';
          echo'<td class="dane-6">';
          echo'<select class="min-4" name="godz">';
            for($i=1; $i<7; $i++)
            {
              if($godz == $i)
              {
                  echo'<option value="'.$i.'" selected>'.$i.' godz.</option>';
              } else {
                  echo'<option value="'.$i.'">'.$i.' godz.</option>';
              }
            }
          echo'</select>';
          echo'</td>';
          echo'</tr>';
        ?>
        <tr>
          <td colspan="2" class="center-3"><input type="button" value="Popraw zagadnienie" class="button" id="poprawZagadnienie"></td>
        </tr>
        </table>
      </form>
    </div><br>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>