<?php
include_once('status.php');

//Zmienna
$id = $_SESSION['id_db'];

//Klasy
include_once('../class/sem.class.php');

//Obiekty

$sem = new semestr;
?>
<ol id="menu">
<li><a href="ucz.php">Start</a>
<li><a href="plan_zajec.php">Plan zajęć</a></li>
<li><a href="poczta.php">Poczta</a></li>
<li><a href="<?php echo $sem->getSem(); ?>">Oceny</a></li>
<li><a href="obecnosc.php">Obecność</a></li>
<li><a href="uwagi.php">Uwagi</a></li>
<li><a href="konto.php">Moje konto</a></li>
<li><a href="usr_pass.php">Zmień hasło</a></li>
</ol>
