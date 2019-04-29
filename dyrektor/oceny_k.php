<?php
include_once('status.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Scholium</title>
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script_ok.js"></script>
<link href="styl/styl.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function()
{
  var url_n = 'oceny_opis_k.php?id_zaj=';
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

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/oceny_klasy_rok.class.php');
include_once('../class/uczniowie_zestaw.class.php');
include_once('../class/przedmioty_zestaw.class.php');
include_once('../class/klasy_zestaw.class.php');
include_once('../class/news.class.php');

//Zmienne
$id_db = $_SESSION['id_db'];
$nazwisko_db = $_SESSION['nazwisko_db'];
$imie_db = $_SESSION['imie_db'];
$rola_db = $_SESSION['rola_db'];
$kto = $_SESSION['kto'];

//Obiekty
$wiadomosc = new news;
$bazaOceny = new ocenyKlasy;
$bazaPrzedmioty = new przedmiotyZestaw;
$bazaUczen = new uczniowieZestaw;
$bazaKlasa = new klasyZestaw;

//Zmienna przekazand do JS - id_kl
if(isset($_GET['id_kl']))
{
  $_SESSION['id_kl'] = $_GET['id_kl'];
  $id_kl = $_SESSION['id_kl'];
  ?><script type="text/javascript">id_kl = "<?=$id_kl;?>";</script><?php
} else {
  $id_kl = $_SESSION['id_kl'];
  ?><script type="text/javascript">id_kl = "<?=$id_kl;?>";</script><?php
}

//Zmienna przekazand do JS - id
if(isset($_GET['id']))
{
  $_SESSION['id'] = $_GET['id'];
  $id = $_SESSION['id'];
  ?><script type="text/javascript">id = "<?=$id;?>";</script><?php
} else {
  $id = $_SESSION['id'];
  ?><script type="text/javascript">id = "<?=$id;?>";</script><?php
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
	
	if(isset($ids))
	{
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
		  echo 'Nauczyciel: '.$imie.' '.$nazwisko;
		} elseif($nr == 1)
		{
		  echo 'Nauczyciel: '.$imie.' '.$nazwisko.', ';
		}
		  
	  }		
	}
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
  
  if(isset($przed[0])){ $id_zaj=$przed[0]; } else { $id_zaj=0; }
  $oceny = $bazaOceny->oceny($id_kl,$id_zaj,$mysqli);
  $ile = count($oceny);
  if($ile>0){sort($oceny);}
  if($_SESSION['kto'] == "Dyrektor") $_SESSION['przed'] = 0;
}

//Blok przechowujący identyfikator zajęć
echo'<div class="adres" id="'.$id_zaj.'"></div>';

//Funkcja - View: Góra tabeli
function tabela_gora($id_kl,$id_zaj,$mysqli)
{
  echo '<tr><th id="lp" rowspan="2">LP</th><th id="dane" rowspan="2">Nazwisko i imie</th>';
  echo '<th colspan="25">Ocena za:</th>';
  echo '<th id="wyl" rowspan="2">Śr.</th><th id="wyl" rowspan="2">Prop.</th><th id="wyl2" rowspan="2">Rok</th></tr>';
  echo '<tr>';
  
	for($i=0; $i<25 ; $i++)
	{
	  if($result = $mysqli->query("SELECT sk FROM oceny_op_k WHERE id_kl='$id_kl' AND poz='$i' AND id_przed='$id_zaj'"))
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
	  echo '<th class="opis"><input class="for-oc-br" type="text" name="op-'.$i.'" id="op-'.$i.'" maxlength="2" value="'.$sk.'"></th>';
	}
  echo '</tr>';	
}

//Funkcja - View: Dół tabeli
function tabela_dol($id_kl,$id_zaj,$mysqli)
{
  //Dół tabeli
  echo '<tr><th colspan="2" class="prawy">Oceny za: </th>';
	for($i=0; $i<25 ; $i++)
	{
	  if($result = $mysqli->query("SELECT sk FROM oceny_op_k WHERE id_kl='$id_kl' AND poz='$i' AND id_przed='$id_zaj'"))
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
	  echo '<th class="opis"><input class="for-oc-br-2" type="text" name="opk-'.$i.'" id="opk-'.$i.'" maxlength="2" value="'.$sk.'"></th>';
	}
  echo '<th class="opis"></th>';
  echo '<th class="opis"></th>';
  echo '<th class="opis"></th>';
  echo '</tr>';
}
?>
<div id="kontener">
  <div id="logo">
   <img src="../image/logo_user.png" alt="Logo">
   <p id="zalogowany">Jesteś zalogowany jako: <?php  echo $imie_db,' ',$nazwisko_db,' - ', $kto?></p>
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
    <div id="nauczyciel"><?php echo nauczyciel($id_zaj,$id_kl,$mysqli); ?></div>
    <p class="panel-2">Klasa <?php echo $bazaKlasa->klasa($id_kl,$mysqli);?></p>
    <div class="linia-2"></div>
    <ul class="nawigacja-2">
    <?php $nr = $bazaPrzedmioty->przedmioty($id_kl,$id,$id_zaj,$mysqli);?>
    </ul>
    <div class="linia-3"></div>
	  <?php
      
        //Utworzenie tabeli z pustymi wartościami
        for($i=0; $i<25; $i++)
        {
            $tab_opis[$i] = '';
            $tab_sk[$i] = '';
        }
        
        //Wpisanie do tablicy opisu ocen z bazy
        if($result = $mysqli->query("SELECT * FROM oceny_op_k WHERE id_kl='$id_kl' AND id_przed='$id_zaj'"))
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
          echo 'tab_opis.push("'.$opis.'");';
          echo 'tab_sk=new Array();';
          foreach($tab_sk as $sk)
          echo 'tab_sk.push("'.$sk.'");';
          echo '</script>'; 
        ?>

        <div class="left">
          <!-- Zakładki SEMESTR -->
          <ul class="nawigacja_sem">
            <li><a href="oceny.php" title="Semestr I" class="sem" id="pod_1">SEMESTR I</a></li>
            <li><a href="oceny_k.php" title="Semestr II" class="sem aktywna" id="pod_2">SEMESTR II</a></li>
          </ul>
          <!-- Opis ocen -->
          <div id="view">
          <p class="opis-2">Opis oceny:
          <input class="for-oc-br-4" type="text" name="" id="widok_sk" maxlength="2" value="">
          <input class="for-oc-br-3" type="text" name="" id="widok_opis" maxlength="56" value="">
          </p>
          </div>
        </div>
      
      <div id="lista" class="zawartosc">
      <table id="plan-oc">
      <?php 
      //Góra tabeli
      tabela_gora($id_kl,$id_zaj,$mysqli);
      
      //Uczniowie i ich oceny
      $bazaUczen->uczniowie($id_kl, $ile, $oceny,$nr,$id_zaj,$mysqli);
      
      //Dół tabeli
      tabela_dol($id_kl,$id_zaj,$mysqli);
      ?>
      </table>
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