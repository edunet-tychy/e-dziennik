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
include_once('../class/statystyka_frekwencja.class.php');
include_once('../class/news.class.php');

//Zmienne
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];

//Miesiac
$msc = date("n");
//$msc = 1;
//$msc = 6;

//Obiekty
$wiadomosc = new news;

//Funkcja - View: Wykres frekwencji
function interfejsKlasy($sem, $msc)
{
  $bazaStatystyka = new statystykaKlasyFr;
  $tab = $bazaStatystyka->srKlasy($sem, $msc);
  $nr = 0;
  
  if(isset($tab))
  foreach($tab as $ob)
  {
	  $ob = explode('; ', $ob);
	  
	  $kl = $ob[0];
	  $sb = $ob[1];
	  $sr = $ob[2];
  
	  $klasa[] = $kl.' '.$sb.' ';
	  $srednia[] = $sr;  
  }

  //Ustawienie zmiennych, gdy brak wystawionych ocen
  if(!isset($srednia)) {$srednia = 0;}
  if(!isset($klasa)) {$klasa = 0;}

   /* Create and populate the pData object */
   $MyData = new pData();  
   $MyData->addPoints($srednia,"Srednia");
   $MyData->addPoints($klasa,"Options");
   $MyData->setAbscissa("Options");
  
   /* Create the pChart object */
   $myPicture = new pImage(500,500,$MyData);
  
   /* Define the default font */ 
   $myPicture->setFontProperties(array("FontName"=>"fonts/MankSans.ttf","FontSize"=>10));
  
   /* Set the graph area */ 
   $myPicture->setGraphArea(50,50,450,200);
  
   /* Draw the chart scale */ 
   $scaleSettings = array("AxisAlpha"=>10,"TickAlpha"=>10,"DrawXLines"=>FALSE,"Mode"=>SCALE_MODE_START0,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>0,"Pos"=>SCALE_POS_TOPBOTTOM);
   $myPicture->drawScale($scaleSettings); 
   
   /* Turn on shadow computing */ 
   $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
  
   $Palette = array("0"=>array("R"=>188,"G"=>224,"B"=>46,"Alpha"=>100),
					"1"=>array("R"=>224,"G"=>100,"B"=>46,"Alpha"=>100),
					"2"=>array("R"=>224,"G"=>214,"B"=>46,"Alpha"=>100),
					"3"=>array("R"=>46,"G"=>151,"B"=>224,"Alpha"=>100),
					"4"=>array("R"=>176,"G"=>46,"B"=>224,"Alpha"=>100),
					"5"=>array("R"=>224,"G"=>46,"B"=>117,"Alpha"=>100),
					"6"=>array("R"=>92,"G"=>224,"B"=>46,"Alpha"=>100),
					"7"=>array("R"=>224,"G"=>176,"B"=>46,"Alpha"=>100));
  
   /* Draw the chart */ 
   $myPicture->drawBarChart(array("DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30,"OverrideColors"=>$Palette)); 
  
   /* Render the picture (choose the best way) */
   $myPicture->Render("image/frek.png");
   
   /* Wyświetlenie statystyki */
   echo '<img src="image/frek.png" alt="Frekwencja">';
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
    <div id="lista" class="zawartosc">
    <?php 
	  if ($msc < 6) {
		$termin = '- SEMESTR I';
	  } elseif ($msc > 5) {
		$termin = '- SEMESTR II'; 
	  }
	?>
      <h3 id="nagRamka4">WYKRES - FREKWENCJA KLAS [%] <?php echo $termin; ?></span></h3>
        <?php
		  if($msc < 6)
          {
			 $msc = 1;
            interfejsKlasy('frekwencja', $msc);
          } elseif ($msc > 5) {
			 $msc = 6;
            interfejsKlasy('frekwencja', $msc);
          }
        ?>
      <div id="user"></div><br><br>
    </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>