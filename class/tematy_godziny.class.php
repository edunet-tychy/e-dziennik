<?php
class tematyGodziny
{
  private $result;
  private $row;
  private $nr;
  private $pocz;
  private $kon;

  //Funkcja - Godziny
  function godziny($mysqli)
  {
	
	if($this->result = $mysqli->query("SELECT nr, pocz, kon FROM godziny WHERE pocz !='' ORDER BY nr"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($this->row=$this->result->fetch_object())
		{
		  $this->nr = $this->row->nr;
		  $this->pocz = $this->row->pocz;
		  $this->kon = $this->row->kon;
		  
		  $godz[] = $this->nr.';'.$this->pocz.';'.$this->kon;
		}	
	  }
	}
	return $godz;
  }	
}
?>