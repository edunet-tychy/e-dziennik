<?php
class tematyKlasaPrzedmiot
{
  private $result;
  private $row;
  private $id_kp;
  private $id_przed;

  //Funkcja - Przedmioty klasy
  function klasaPrzed($id_kl,$mysqli)
  {
	if($this->result = $mysqli->query("SELECT id_kp, id_przed FROM klasy_przedmioty WHERE id_kl='$id_kl'"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($this->row=$this->result->fetch_object())
		{		
		  $this->id_kp = $this->row->id_kp;
		  $this->id_przed = $this->row->id_przed;
		  
		  $klasa[] = $this->id_kp.';'.$this->id_przed;
		}
	  }
	}
	return $klasa;
  }
	
}
?>