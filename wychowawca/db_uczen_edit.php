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

//id ucznia
$id = $_GET['id'];

//Klasy
include_once('../class/zapytanie.class.php');
include_once('../class/news.class.php');

//Obiekty
$wiadomosc = new news;
 
//Dane z tabeli USER
if($result = $mysqli->query("SELECT * FROM users WHERE id='$id'"))
{
  if($result->num_rows > 0)
  {
	  while($row=$result->fetch_object())
	  {
		  $nazwisko = $row->nazwisko;
		  $imie = $row->imie;
		  $email = $row->email;
		  $login = $row->login;
	  }
  }
}

//Dane z tabeli UCZEN
if($result = $mysqli->query("SELECT * FROM uczen WHERE id_user='$id'"))
{
  if($result->num_rows > 0)
  {  
	  while($row=$result->fetch_object())
	  {
		  $id_ucz = $row->id_ucz;
		  $nr_ewid = $row->nr_ewid;
		  $pesel = $row->pesel;
		  $data_ur = $row->data_ur;
		  $miejsce_ur = $row->miejsce_ur;
		  $plec = $row->plec;
	  }
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
		$emailR = $row->email;
	  }
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
  <div id="klasa">
  <ul class="nawigacja">
  <li><a href="db_uczen.php" title="lista" class="zakladki" id="z_01">LISTA UCZNIÓW</a></li>
  </ul>
  <div id="obramowanie">
    <div id="edytuj" class="zawartosc">
      <h3>EDYCJA UCZNIA <?php echo mb_strtoupper($nazwisko,"UTF-8").' '.mb_strtoupper($imie,"UTF-8"); ?></h3>
      <form action="db_uczen_upd.php" method="post" name="form" id="form">
      <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
      <input type="hidden" id="id_ucz" name="id_ucz" value="<?php echo $id_ucz; ?>">
      <input type="hidden" id="id_rodz" name="id_rodz" value="<?php echo $id_rodz; ?>">
      <input type="hidden" id="id_ad" name="id_ad" value="<?php echo $id_ad; ?>">
      <input type="hidden" id="id_tel" name="id_tel" value="<?php echo $id_tel; ?>">
      <input type="hidden" id="id_user" name="id_user" value="<?php echo $id_user; ?>">
        <table class="center">
        <tr><td class="dane">Nazwisko:*</td><td><input type="text" id="nazwisko" size="30" class="pole" name="nazwisko" value="<?php echo $nazwisko; ?>"></td><td><div class="kontrola" id="konNazw"></div></td>
        <td class="dane">Imię:*</td><td><input type="text" id="imie" size="30" class="pole" name="imie" value="<?php echo $imie; ?>"></td><td><div class="kontrola" id="konImie"></div></td></tr>
        <tr><td class="dane">E-mail:*</td><td><input type="email" id="email" size="30" class="pole" name="email" value="<?php echo $email; ?>"></td><td><div class="kontrola" id="konEmail"></div></td>
        <td class="dane">Login:*</td><td><input type="text" id="login" size="30" class="pole" name="login" value="<?php echo $login; ?>"></td><td><input type="button" value="Generuj login" class="button" id="genLog"></td></tr>
        <tr><td class="dane">Hasło:*</td><td><input type="password" id="passwd" size="30" class="pole" name="passwd" maxlength="8"></td><td><input type="button" value="Generuj hasło" class="button" id="genHas"></td>
        <td class="dane">Powtórz hasło:*</td><td><input type="password" id="passwdPow" size="30" class="pole" name="passwdPow" maxlength="8"></td><td><div class="kontrola" id="konPasswdPow"></div></td></tr>
        <tr><td class="dane">Nr ewidencyjny:*</td><td><input type="text" id="nrEwiden" size="30" class="pole" name="nrEwiden" value="<?php echo $nr_ewid; ?>"></td><td><div class="kontrola" id="konNrEwiden"></div></td>
        <td class="dane">Pesel:</td><td><input type="text" id="pesel" size="30" class="pole" name="pesel" value="<?php echo $pesel; ?>" maxlength="11"></td><td><div class="kontrola" id="konPesel"></div></td></tr>
        <tr><td class="dane">Data urodzenia:*</td><td><input type="text" id="dataUrodz" size="30" class="pole" name="dataUrodz" value="<?php echo $data_ur; ?>"></td><td><div class="kontrola" id="konDataUrodz">RRRR-MM-DD</div></td>
        <td class="dane">Miejsce urodz.:*</td><td><input type="text" id="miejsceUrodz" size="30" class="pole" name="miejsceUrodz" value="<?php echo $miejsce_ur; ?>"></td><td><div class="kontrola" id="konMiejsceUrodz"></div></td></tr>
        <tr><td class="dane">Płeć:*</td><td>
        <select name="plec" id="plec">
        <?php   
          if($plec == 'm')
          {
            echo'<option id="ch" value="m">chłopiec</option>';
            echo'<option id="dz" value="k">dziewczyna</option>';
          } else {
            echo'<option id="dz" value="k">dziewczyna</option>';
            echo'<option id="ch" value="m">chłopiec</option>';
          }
        ?>
        </select>
        </td><td colspan="4"></td></tr>
        <tr><td></td><td>RODZICE/OPIEKUNOWIE</td><td colspan="4"></td></tr>
        <tr><td class="dane">Imię matki:*</td><td><input type="text" id="imieM" size="30" class="pole" name="imieM" value="<?php echo $imieM; ?>"></td><td><div class="kontrola" id="konImieM"></div></td>
        <td class="dane">Nazwisko:*</td><td><input type="text" id="nazwiskoR" size="30" class="pole" name="nazwiskoR"  value="<?php echo $nazwiskoR; ?>"></td><td><div class="kontrola" id="konNazwiskoR"></div></td></tr>
        <tr><td class="dane">Imię ojca:*</td><td><input type="text" id="imieO" size="30" class="pole" name="imieO"  value="<?php echo $imieO; ?>"></td><td><div class="kontrola" id="konImieO"></div></td>
        <tr><td></td><td>ADRES ZAMIESZKANIA</td><td colspan="4"></td></tr>
        <tr><td class="dane">Ulica:*</td><td><input type="text" id="ulica" size="30" class="pole" name="ulica" value="<?php echo $ulica; ?>"></td><td><div class="kontrola" id="konUlica"></div></td>
        <td class="dane">Miasto:*</td><td><input type="text" id="miasto" size="30" class="pole" name="miasto" value="<?php echo $miasto; ?>"></td><td><div class="kontrola" id="konMiasto"></div></td></tr>
        <tr><td class="dane">Lokal:*</td><td><input type="text" id="lokal" size="30" class="pole" name="lokal" value="<?php echo $lokal; ?>"></td><td><div class="kontrola" id="konLokal"></div></td>
        <td class="dane">Województwo:*</td><td><input type="text" id="woj" size="30" class="pole" name="woj" value="<?php echo $woj; ?>"></td><td><div class="kontrola" id="konWoj"></div></td></tr>
        <tr><td class="dane">Kod:*</td><td><input type="text" id="kod" size="30" class="pole" name="kod" value="<?php echo $kod; ?>"></td><td colspan="4"><div class="kontrola" id="konKod"></div></td></tr>
        <tr><td></td><td>DANE KONTAKTOWE</td><td colspan="4"></td></tr>
        <tr><td class="dane">E-mail:*</td><td><input type="text" id="emailRodzic" size="30" class="pole" name="emailRodzic" value="<?php echo $emailR; ?>"></td><td><div class="kontrola" id="konEmailRodzic"></div></td>
        <td class="dane">Telefon:*</td><td><input type="text" id="telefon" size="30" class="pole" name="telefon" value="<?php echo $telefon; ?>"></td><td><div class="kontrola" id="konTelefon"></div></td></tr>
        <tr>
          <td colspan="6" class="center-2"><input type="button" value="Popraw dane ucznia" class="button" id="poprawDaneUcznia"></td>
        </tr>
        <tr><td colspan="6"><div class="kontrola" id="konLoginu"></div><div class="kontrola" id="konPasswd"></div></td></tr>
        </table>
      </form>
    </div>
  </div>
  </div>
  </div>
  <div id="stopka">
  <p class="stopka">&copy; G.Szymkowiak 2014/2015</p>
  </div>
</div>
</body>
</html>