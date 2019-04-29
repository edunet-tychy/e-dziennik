<?php
class nowaPoczta
{
  private $nr;
  private $result;
  private $query;
  private $nowe;
  
  //Funkcja - Poczta
  function poczta($id)
  {
	global $mysqli;
	$this->nr=0;
	
	$this->query = "SELECT odczyt FROM poczta WHERE odb = '$id'";
  
	if(!$this->result = $mysqli->query($this->query))
	{
	 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	 $mysqli->close();
	}
	
	if($this->result->num_rows > 0)
	{
	  while($row=$this->result->fetch_object())
	  {
		$this->nowe = $row->odczyt;
		if($this->nowe == 1)
		{
		  $this->nr++;
		}
	  }	  
	}
	if($this->nr > 0)
	{
		echo '<span class="poczta">Masz nową pocztę ('.$this->nr.')</span>';
	}
  }	
}
?>