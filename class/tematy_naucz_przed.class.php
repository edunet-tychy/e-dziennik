<?php
class tematyNauczanyPrzedmiot
{
  private $result;
  private $row;
  
  //Funkcja - Przedmioty nauczyciela
  function nauczPrzed($id,$mysqli)
  {
	if($this->result = $mysqli->query("SELECT id_kp FROM klasy_nauczyciele WHERE id_naucz='$id'"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($this->row=$this->result->fetch_object())
		{
		  $id_kp[] = $this->row->id_kp;
		}
	  }
	}
	return $id_kp;
  }
}
?>