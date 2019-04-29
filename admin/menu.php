<?php
//Funkcja - menu Szkoły
function szkoly()
{
  global $mysqli;

  $zapytanie = "SELECT * FROM szkoly";
  
  if($odp_1 = $mysqli->query($zapytanie))
  {
	echo '<li class="prawo"><a href="#">Dodaj klasę</a><ol>';
	if($odp_1->num_rows > 0)
	{
	  while($wiersz=$odp_1->fetch_object())
	  {
		echo '<li><a href="db_klasa.php?id_sz='.$wiersz->id_sz.'"  title="Dodaj nową klasę w tej szkole">'.$wiersz->skrot.'</a></li>';
	  }
	}
	echo '</ol></li>';	
  }
}
?>
<ol id="menu">
<li><a href="admin.php">Start</a></li>
<li><a href="db_dane_szkola.php">Dane placówki</a></li>
<li class="dol"><p class="menu">Konfiguracja</p>
  <ul>
  <li><a href="db_zawod.php">Dodaj zawodów</a></li>
  <li><a href="db_przedmioty.php">Dodaj przedmioty</a></li>
  <li><a href="db_szkoly.php">Dodaj szkołę</a></li>
  <?php szkoly() ;?>
  </ul>
</li>
<li class="dol"><p class="menu">Użytkownicy</p>
  <ul>
    <li><a href="db_user.php?st=1" title="Dodaj Administratora">Administratorzy</a></li>
    <li><a href="db_user.php?st=2" title="Dodaj Dyrektora">Dyrekcja</a></li>
    <li ><a href="db_user.php?st=4" title="Dodaj Nauczyciela">Nauczyciele</a></li>
  </ul>
</li>

<li class="dol"><p class="menu">Kalendarium</p>
  <ul>
    <li><a href="db_org_roku.php">Organizacja roku</a></li>
    <li><a href="db_kalendarz.php">Kalendarz szkolny</a></li>
    <li><a href="db_news.php">Wiadomości</a></li>
  </ul>
</li>
<li><a href="db_dzwonki.php">Rozkład dzwonków</a></li>
<li class="dol"><p class="menu">Narzędzia</p>
  <ul>
  <li><a href="backup/db_backup.php">Backup bazy</a></li>
  <li><a href="db_nauczyciel.php">Drukuj loginy</a></li>
  </ul>
</li>
<li><a href="usr_pass.php">Zmień hasło</a></li>
</ol>
