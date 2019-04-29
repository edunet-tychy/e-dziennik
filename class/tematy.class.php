<?php
class tematPokaz
{
  private $query;
  private $result;
  private $row;
  
  //Funkcja - Temat
  function temat($id_zag,$mysqli)
  {
	$this->query = "SELECT * FROM rozklad WHERE id_zag = '$id_zag'";
  
	if(!$this->result = $mysqli->query($this->query))
	{
	 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	 $mysqli->close();
	}
	
	if($this->result->num_rows > 0)
	{
	  while($this->row=$this->result->fetch_object())
	  {
		$zag = $this->row->zagadnienie;
	  }	  
	}
	return $zag;
  }  	
}
?>