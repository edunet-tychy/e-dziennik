<?php
class tematyNazwaPrzedmiotu
{
  private $id_przed;
  private $result;
  private $row;
  private $nazwa;
  
  //Funkcja - Nazwa przedmiotu
  function nazwaPrzed($id, $id_kl,$mysqli)
  {
	$bazaTematyIdPrzed = new tematyIdPrzedmiot;
	$this->id_przed = $bazaTematyIdPrzed->idPrzed($id, $id_kl,$mysqli);
  
	foreach($this->id_przed as $dane)
	{
	  if($this->result = $mysqli->query("SELECT nazwa FROM przedmioty WHERE id_przed='$dane'"))
	  {
		if($this->result->num_rows > 0)
		{
		  $this->row=$this->result->fetch_object();
		  $this->nazwa = $this->row->nazwa;
		  
		  $przedmiot[] = $dane.';'.$this->nazwa;
		}
	  }
	}
	return $przedmiot;
  }	
}
?>