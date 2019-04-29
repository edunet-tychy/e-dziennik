<?php
class zapytanie
{
  private $result;
  private $query;
  public $tab;
  
  //Funkcja - zapytanie
  public function pytanie($query)
  {
	global $mysqli;
	$this->query = $query;
 
	if(!$this->result = $mysqli->query($this->query))
	{
	 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	 $mysqli->close();
	}
	
	return $this->tab = $this->result->fetch_row();

  }

}
?>