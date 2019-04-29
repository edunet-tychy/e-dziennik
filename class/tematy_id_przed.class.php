<?php
class tematyIdPrzedmiot
{
  private $przed_klasy;
  private $przed_naucz;

  //Funkcja - Identyfikator przedmiotu
  function idPrzed($id,$id_kl,$mysqli)
  {
	$bazaNauczPrzed = new tematyNauczanyPrzedmiot;
	$this->przed_naucz = $bazaNauczPrzed->nauczPrzed($id,$mysqli);
	$bazaKlasaPrzed = new tematyKlasaPrzedmiot;
	$this->przed_klasy = $bazaKlasaPrzed->klasaPrzed($id_kl,$mysqli);
  
	foreach($this->przed_naucz as $przedmiot)
	{
	  foreach($this->przed_klasy as $dane)
	  {
		$dane = explode(';', $dane);
		
		if($przedmiot == $dane[0])
		{
		  $id_przed[] = $dane[1];
		}
	  }
	}
	return $id_przed;
  }	
}
?>