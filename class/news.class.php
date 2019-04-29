<?php
class news
{
  private $tab;
  function wiadomosc()
  {
	$baza = new zapytanie;
	global $mysqli;
	
	if(!isset($_SESSION['wiadomosc']))
	{
	  
	  
	  if ($_SESSION['kto'] == 'Administrator' || $_SESSION['kto'] == 'Dyrektor' || $_SESSION['kto'] == 'Wychowawca' || $_SESSION['kto'] == 'Nauczyciel') {
		  
		  $query = $mysqli->query("SELECT informacje FROM news WHERE odb=1");
		  
		  while($row=$query->fetch_object())
		  {
			$this->tab[] = $row->informacje;
		  }
		  
		  $ile = count($this->tab);
		  $los = rand(1,$ile);
		  $los = $los - 1;
		  
		  $_SESSION['wiadomosc'] = $this->tab[$los];
		  	  
	  } elseif ($_SESSION['kto'] == 'Rodzic' || $_SESSION['kto'] == 'Uczeń' ) {

		  $query = $mysqli->query("SELECT informacje FROM news WHERE odb=2");
		  
		  while($row=$query->fetch_object())
		  {
			$this->tab[] = $row->informacje;
		  }
		  
		  $ile = count($this->tab);
		  $los = rand(1,$ile);
		  $los = $los - 1;
		  
		  $_SESSION['wiadomosc'] = $this->tab[$los];
		  
	  }
		
	}
	  echo $_SESSION['wiadomosc'];
  }	
}
?>