<?php
class idPrzedmiot
{
  private $result;
  public $id_przed;
  
  //Funkcja - ID Przedmioty klasy
  public function id_przedmiot($id_kl)
  {
	global $mysqli;
	
	if($this->result = $mysqli->query("SELECT * FROM klasy_przedmioty WHERE id_kl='$id_kl'"))
	{
	  while($row=$this->result->fetch_object())
	  {
		$this->id_przed[] = $row->id_przed;		
	  }
	}
	return $this->id_przed;
  }	
}

class nazwaPrzedmiot
{
  private $query;
  private $nazwa;
  private $id;
  private $id_przed;
  public $przedmiot;
  
  //Funkcja - Nazwa przedmiotu
  public function naz_przedmiot($id_kl)
  {
	global $mysqli;
	$baza = new zapytanie;
	$bazaIdPrzedmiot = new idPrzedmiot;
	
	$this->id_przed = $bazaIdPrzedmiot->id_przedmiot($id_kl);
	
	foreach($this->id_przed as $this->id)
	{
		$this->query = "SELECT nazwa FROM przedmioty WHERE id_przed='$this->id'";
		$baza->pytanie($this->query);
		$this->nazwa = $baza->tab[0];
		$this->przedmiot[] = $this->nazwa.'; '.$this->id;
	}
	sort($this->przedmiot);
	return $this->przedmiot;
  }	
}
?>