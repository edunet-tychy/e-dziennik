<?php
class tematyPokazGodz
{
  private $query;
  private $result;
  private $row;
  private $pocz;
  private $kon;

  //Funkcja - Godziny
  function godziny($nr,$mysqli)
  {
	$this->query = "SELECT pocz, kon FROM godziny WHERE nr = '$nr'";
	
	if(!$this->result = $mysqli->query($this->query))
	{
	 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	 $mysqli->close();
	}
  
	if($this->result->num_rows > 0)
	{
	  while($this->row=$this->result->fetch_object())
	  {
		$this->pocz = $this->row->pocz;
		$this->kon = $this->row->kon;
	  }	  
	}
	return $godz = $this->pocz.' - '.$this->kon;  
  }	
}
?>