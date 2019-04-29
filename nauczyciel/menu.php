<?php
include_once('status.php');



//Zmienna
$id = $_SESSION['id_db'];

//Klasy
include_once('../class/menu.class.php');
include_once('../class/sem.class.php');

//Obiekty
$baza = new menu;
$sem = new semestr;

?>
<ol id="menu">
<?php
if($_SESSION['kto'] == "Wychowawca" && $_SESSION['wstecz'] == 0)
{
  echo'<li class="panel"><a href="../wychowawca/wych.php">Panel</a></li>';		
} elseif($_SESSION['kto'] == "Wychowawca" && $_SESSION['wstecz'] == 1) {
  echo'<li class="panel"><a href="naucz.php">Wstecz</a></li>';	
} else {
  echo'<li><a href="naucz.php">Start</a></li>';	
}


?>
<li><a href="plan_zajec.php">Plan zajęć</a></li>

<li><a href="poczta.php">Poczta</a></li>

<li class="dol"><p class="menu">Oceny</p>
  <ul><?php $baza->klasy($sem->getSem()); ?></ul>
</li>

<li class="dol"><p class="menu">Tematy</p>
  <ul><?php $baza->klasy("tematy.php"); ?></ul>
</li>

<li class="dol"><p class="menu">Rozkłady</p>
  <ul><?php $baza->klasy("rozklad_dane.php"); ?></ul>
</li>

<li class="dol"><p class="menu">Uwagi</p>
  <ul><?php $baza->klasy("uwagi.php"); ?></ul>
</li>
<li><a href="usr_pass.php">Zmień hasło</a></li>
</ol>
