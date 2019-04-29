<?php
include_once('status.php');

//Zmienna
$id = $_SESSION['id_db'];

//Klasy
include_once('../class/menu_dyr.class.php');
include_once('../class/sem.class.php');

//Obiekty
$baza = new menu;
$sem = new semestr;

?>
<ol id="menu">
<li><a href="dyr.php">Start</a>
<li><a href="poczta.php">Poczta</a></li>
<li class="dol"><p class="menu">Oceny</p>
<ul><?php $baza->klasy("oceny.php");?></ul>
</li>
<li class="dol"><p class="menu">Frekwencja</p>
<ul><?php $baza->klasy($sem->getFrekSem());?></ul>
</li>
<li class="dol"><p class="menu">Uwagi</p>
<ul><?php $baza->klasy("uwagi.php");?></ul>
</li>
<li class="dol"><p class="menu">Statystyka</p>
<ul>
<li><a href="stat_oceny.php">Średnia ocen klas</a></li>
<li><a href="stat_frek.php">Średnia frekwencja</a></li>
<li><a href="stat_max.php">Uczniowie najlepsi</a></li>
<li><a href="stat_min.php">Uczniowie najsłabsi</a></li>
<li><a href="stat_nkl.php">Uczniowie nieklas.</a></li>
</ul>
</li>
<li class="dol"><p class="menu">Rejestr ocen</p>
<ul>
<li><a href="rej_upd_1.php">Poprawione - Sem. I</a></li>
<li><a href="rej_upd_2.php">Poprawione - Sem. II</a></li>
<li><a href="rej_del_1.php">Usunięte - Sem. I</a></li>
<li><a href="rej_del_2.php">Usunięte - Sem. II</a></li>
</ul>
</li>
<li><a href="usr_pass.php">Zmień hasło</a></li>
</ol>