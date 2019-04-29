﻿<?php
include_once('status.php');
$_SESSION['wstecz'] = 1;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_o.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function()
{
  var url_n = 'db_oceny_opis.php?id_zaj=';
  var zaj = $(".adres").attr("id").valueOf();
  url_n += zaj;
  $("#zawartosc").load(url_n);
});
</script>
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

//Zmienne
$id_db = $_SESSION['id_db'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];

//Klasy
include_once('../class/oceny_przedmioty.class.php');
include_once('../class/oceny_klasa.class.php');
include_once('../class/oceny_uczniowie_sm.class.php');
include_once('../class/oceny_sm.class.php');
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$bazaPrzedmioty = new ocenyPrzedmioty;
$bazaKlasa = new ocenyKlasa;
$bazaUczniowie = new ocenyUczniowie;
$bazaOceny = new wpisOceny;
$wiadomosc = new news;

if(isset($_GET['id_kl']))
{
  $_SESSION['id_kl'] = $_GET['id_kl'];
  $id_kl = $_SESSION['id_kl'];
  ?><script type="text/javascript">id_kl = "<?=$id_kl;?>";</script><?php
} else {
  $id_kl = $_SESSION['id_kl'];
  ?><script type="text/javascript">id_kl = "<?=$id_kl;?>";</script><?php
}

if(isset($_GET['id']))
{
  $_SESSION['id'] = $_GET['id'];
  $id = $_SESSION['id'];
  ?><script type="text/javascript">id = "<?=$id;?>";</script><?php
} else {
  $id = $_SESSION['id'];
  ?><script type="text/javascript">id = "<?=$id;?>";</script><?php
}

//Aktywowanie zakładek
if(isset($_GET['id_zaj']))
{
  $id_zaj=$_GET['id_zaj'];
  $oceny = $bazaOceny->oceny($id_kl,$id_zaj,$mysqli);

  $ile = count($oceny);
  if($ile>0){sort($oceny);}
} else {
  if($result = $mysqli->query("SELECT id_kp FROM klasy_nauczyciele WHERE id_naucz='$id_db'"))
  {
	if($result->num_rows > 0)
	{
	  while($row=$result->fetch_object())
	  {
		$id_kp = $row->id_kp;
		if($result2 = $mysqli->query("SELECT id_przed FROM klasy_przedmioty WHERE id_kp='$id_kp' AND id_kl='$id_kl'"))
		{
		  if($result2->num_rows > 0)
		  {
			while($row2=$result2->fetch_object())
			{
				$przed[]=$row2->id_przed;
			}
		  }
		}
	  }
	}
  }
  
  if(isset($przed[0]))
  {
	$id_zaj=$przed[0];
  } else {
	$id_zaj=0;
  }

$oceny = $bazaOceny->oceny($id_kl,$id_zaj,$mysqli);
$ile = count($oceny);
if($ile>0){sort($oceny);}
  
@$_SESSION['przed']= $przed;
}

//Blok przechowujący identyfikator zajęć
echo'<div class="adres" id="'.$id_zaj.'"></div>';

//Funkcja - Tablica
function tablica($mysqli,$id_kl,$id_zaj)
{
  //Utworzenie tabeli z pustymi wartościami
  for($i=0; $i<25; $i++)
  {
	  $tab_opis[$i] = '';
	  $tab_sk[$i] = '';
  }
  
  //Wpisanie do tablicy opisu ocen z bazy
  if($result = $mysqli->query("SELECT * FROM oceny_op WHERE id_kl='$id_kl' AND id_przed='$id_zaj'"))
  {
	  
	if($result->num_rows > 0)
	{
	  while($row=$result->fetch_object())
	  {
		  $poz=$row->poz;
		  for($i=0; $i<25; $i++)
		  {
			if($i == $poz)
			{
			  $tab_opis[$i] = $row->opis;
			  $tab_sk[$i] = $row->sk;
			}
		  }
	  }
	}
  }

  echo '<script type="text/javascript">';
	echo 'tab_opis=new Array();';
	foreach($tab_opis as $opis)
	echo 'tab_opis.push(\''.$opis.'\');';
	echo 'tab_sk=new Array();';
	foreach($tab_sk as $sk)
	echo 'tab_sk.push(\''.$sk.'\');';
  echo '</script>';
}

//Funkcja - View: Góra tabeli
function tabela_gora($mysqli,$id_kl,$id_zaj,$aktywny)
{
  echo '<tr><th id="lp" rowspan="2">LP</th><th id="dane" rowspan="2">Nazwisko i imie</th>';
  echo '<th colspan="25">Ocena za:</th>';
  echo '<th id="wyl" rowspan="2">Śr.</th><th id="wyl" rowspan="2">Prop.</th><th id="wyl2" rowspan="2">Sem.</th></tr>';
  echo '<tr>';
  
	for($i=0; $i<25 ; $i++)
	{
	  if($result = $mysqli->query("SELECT sk FROM oceny_op WHERE id_kl='$id_kl' AND poz='$i' AND id_przed='$id_zaj'"))
	  {
		if($result->num_rows == 1)
		{
		  while($row=$result->fetch_object())
		  {
			$sk = $row->sk;
		  }
		} else {
			$sk='';
		}
	  }
	  //Opis ocen góra
	  if($aktywny==0)
	   {
		  echo '<th class="opis"><input class="for-oc-br" type="text" name="op-'.$i.'" id="op-'.$i.'" maxlength="2" value="'.$sk.'" disabled></th>';
	   } else {
		  echo '<th class="opis"><input class="for-oc-br" type="text" name="op-'.$i.'" id="op-'.$i.'" maxlength="2" value="'.$sk.'"></th>';
	   }
	}
  echo '</tr>';
}

//Funkcja - View: Dół tabeli
function tabela_dol($mysqli,$id_kl,$id_zaj,$aktywny)
{
  echo '<tr><th colspan="2" class="prawy">Oceny za: </th>';
	for($i=0; $i<25 ; $i++)
	{
	  if($result = $mysqli->query("SELECT sk FROM oceny_op WHERE id_kl='$id_kl' AND poz='$i' AND id_przed='$id_zaj'"))
	  {
		if($result->num_rows == 1)
		{
		  while($row=$result->fetch_object())
		  {
			$sk = $row->sk;
		  }
		} else {
			$sk='';
		}
	  }
	  //Opis ocen dół
	  if($aktywny==0)
	   {
		 echo '<th class="opis"><input class="for-oc-br-2" type="text" name="opk-'.$i.'" id="opk-'.$i.'" maxlength="2" value="'.$sk.'" disabled></th>';
	   } else {
		 echo '<th class="opis"><input class="for-oc-br-2" type="text" name="opk-'.$i.'" id="opk-'.$i.'" maxlength="2" value="'.$sk.'"></th>';
	   }
	}
  echo '<th class="opis"></th>';
  echo '<th class="opis"></th>';
  echo '<th class="opis"></th>';
  echo '</tr>';
}


//Funkcja Przycisk
function przycisk($id_zaj,$li,$traf,$zaj)
{
  if($li > 1) //Przypadek 1 - nauczyciel prowadzi więcej niż 1 przedmiot
  {
	for($i = 0; $i < $li; $i++)
	{
	  if($zaj[$i] == $id_zaj)
	  {
		echo '<div class="prawy"><div id="zapis"></div><input type="button" value="Zapisz oceny" class="przycisk-oc" id="zapisOcen"></div> ';
		//Formularz - id_przed
		echo '<input type="hidden" name="id_przed" id="id_przed" value="'.$zaj[$i].'">';
		$traf=1;
		$aktywny=1;
	  }
	}
	
	if ($traf == 0)
	{
	  echo '<div class="prawy"><input type="button" value="Zapisz oceny" class="przycisk-oc" id="zapisOcen" disabled></div> ';
	  $aktywny=0;
	}
  } else { //Przypadek 2 - nauczyciel prowadzi 1 przedmiot
	  if($zaj[0] == $id_zaj)
	  {
		echo '<div class="prawy"><div id="zapis"></div><input type="button" value="Zapisz oceny" class="przycisk-oc" id="zapisOcen"></div> ';
		//Formularz - id_przed
		echo '<input type="hidden" name="id_przed" id="id_przed" value="'.$zaj[0].'">';
		$aktywny=1;
	  } else {
		echo '<div class="prawy"><input type="button" value="Zapisz oceny" class="przycisk-oc" id="zapisOcen" disabled></div> ';
		$aktywny=0;
	  }				  
  }
  return $aktywny;
}

//Funkcja - Nauczyciel
function nauczyciel($id_zaj,$id_kl,$mysqli)
{
	$baza = new zapytanie;
	$query = "SELECT id_kp FROM klasy_przedmioty WHERE id_kl='$id_kl' AND id_przed='$id_zaj'";
	$baza->pytanie($query);
	$id_kp = $baza->tab[0];
	
	if($result = $mysqli->query("SELECT id_naucz FROM klasy_nauczyciele WHERE id_kp='$id_kp'"))
	{
	  if($result->num_rows > 0)
	  {
		while($row=$result->fetch_object())
		{
		  $ids[] = $row->id_naucz;
		}
	  }
	}
	
	$ile = count($ids);
	$nr=0;
	
	foreach ($ids as $id)
	{
	  $query = "SELECT imie, nazwisko FROM users WHERE id='$id'";
	  $baza->pytanie($query);
	  $imie = $baza->tab[0];
	  $nazwisko = $baza->tab[1];	
	  
	  $nr++;
	  
	  if($nr == $ile)
	  {
		echo $imie.' '.$nazwisko;
	  } elseif($nr == 1)
	  {
		echo $imie.' '.$nazwisko.', ';
	  }
	  	
	}
}

//Funkcja - Wychowawca
function iden($kto)
{
  if($_SESSION['kto'] == "Wychowawca")
  {
	 return $_SESSION['idenfyfikator'];
  }	else {
	 return $_SESSION['kto'];
  }	
}
?>
<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie_db,' ',$nazwisko_db,' - '. iden($kto);?></p>
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
    <div id="nauczyciel">Nauczyciel: <?php echo nauczyciel($id_zaj,$id_kl,$mysqli); ?></div>
    <p class="panel-2">Klasa <?php echo $bazaKlasa->klasa($id_kl,$mysqli);?></p>
    <div class="linia-2"></div>
    <ul class="nawigacja-2">
    <?php $nr = $bazaPrzedmioty->przedmioty($id_kl,$id,$id_zaj,$mysqli);?>
    </ul>
    <div class="linia-3"></div>
      <form action="db_oceny.php" method="post" name="form" id="form">
      <?php
        $li = count($_SESSION['przed']);
        $zaj = $_SESSION['przed'];
        $blok=0;
        $traf=0;
		
        tablica($mysqli,$id_kl,$id_zaj);
      ?>

      <div class="left">
        <!-- Zakładki SEMESTR -->
        <ul class="nawigacja_sem">
          <li><a href="oceny.php" title="Semestr I" class="sem aktywna" id="pod_1">SEMESTR I</a></li>
          <li><a href="oceny_k.php" title="Semestr II" class="sem" id="pod_2">SEMESTR II</a></li>
        </ul>
        <!-- Opis ocen -->
        <div id="view">
        <p class="opis-2">Opis oceny:
        <input class="for-oc-br-4" type="text" name="" id="widok_sk" maxlength="2" value="">
        <input class="for-oc-br-3" type="text" name="" id="widok_opis" maxlength="56" value="">
        </p>
        </div>
      </div>
         
      <?php
	  //Przycisk ZAPISZ OCENĘ
	  $aktywny = przycisk($id_zaj,$li,$traf,$zaj);
      ?>
      
      <div id="lista" class="zawartosc">
      <table id="plan-oc">
      <?php 
      //Góra tabeli
      tabela_gora($mysqli,$id_kl,$id_zaj,$aktywny);
      
      //Uczniowie i ich oceny
      $bazaUczniowie->uczniowie($id_kl,$ile,$oceny,$mysqli,$nr,$id_zaj,$aktywny);
      
      //Dół tabeli
      tabela_dol($mysqli,$id_kl,$id_zaj,$aktywny);
      ?>
      </table>
      </form>
      <!-- Informacje dla użytkownika -->
      <div class="left" id="user">
        <h2 class="opis">WPISY OBOWIĄZUJACE W DZIENNIKU:</h2>
        <p class="opis">Oceny cząstkowe:</p>
        <ul class="opis">
        <li>0, 1, 1+, 2-, 2, 2+, 3-, 3, 3+, 4-, 4, 4+, 5-, 5, 5+, 6-, 6</li>
        </ul>
        <p class="opis">Oceny semestralne:</p>
        <ul class="opis">
        <li>1 do 6</li>
        <li>N/n - nieklasyfikowany</li>
        <li>Z/z - zwolniony</li>
        </ul>
        <p class="opis">Inne wpisy:</p>
        <ul class="opis">
        <li>np - nieprzygotowanie</li>
        <li>nb - nieobecny</li>
        <li>zw - zwolniony</li>
        </ul>
        <br><br>
      </div>
      
      <div class="right" id="zawartosc">
      <br><br>
      </div>
      
    </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
 </div><br>
</body>
</html>