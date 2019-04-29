<?php
class rodzice
{
  private $nr;
  private $query;
  private $result;
  public $rodzic;

  //Funkcja - Rodzic
  public function rodzic($id_user)
  {
	global $mysqli;
	$this->nr=0;
	
	$this->query = "SELECT id_rodz FROM rodzic WHERE id_user = '$id_user'";
  
	if(!$this->result = $mysqli->query($this->query))
	{
	 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	 $mysqli->close();
	}
	
	if($this->result->num_rows > 0)
	{
	  while($row=$this->result->fetch_object())
	  {
		$this->rodzic = $row->id_rodz;
	  }	  
	}
  return $this->rodzic;
  }
}
?>