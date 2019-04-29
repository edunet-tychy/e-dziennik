<?php
class plan_przed
{
  private $query;
  private $mysqli;
  private $id_przed;
  public $przedmiot;
  
  //Funkcja - przedmioty
  public function przed($id_przed,$mysqli)
  {
	$this->mysqli = $mysqli;
	$this->id_przed = $id_przed;
	
	$baza = new zapytanie;
	$this->query = "SELECT skrot FROM przedmioty WHERE id_przed='$this->id_przed'";
	$baza->pytanie($this->query);
	
	$this->przedmiot = $baza->tab[0];
	
	return mb_strtoupper($this->przedmiot,"UTF-8");
  }	
}
?>