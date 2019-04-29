<?php
class terminy
{
  private $result;
  public $data;
  public $dat;
  public $dats;
  
  //Funkcja - Godziny
  public function godziny()
  {
	global $mysqli;
	
	if($this->result = $mysqli->query("SELECT nr, pocz, kon FROM godziny WHERE pocz !='' ORDER BY nr"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($row=$result->fetch_object())
		{
		  $nr = $row->nr;
		  $pocz = $row->pocz;
		  $kon = $row->kon;
		  
		  $godz[] = $nr.'; '.$pocz.'; '.$kon;
		}	
	  }
	}
	return $godz;
  }
  
  //Funkcja - Godzina
  public function godz()
  {
	$this->dat = date("G:i");
	return $this->dat;
  }
  
  //Funkcja - Bieżąca data
  public function dt()
  {
	$this->data = date("Y-m-d");
	return $this->data;
  }
  
  //Funkcja - Data
  function data()
  {
	return $dats = date("d.m.y");
  }
}
?>