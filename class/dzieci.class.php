<?php
class dzieci
{
  private $query;
  private $result;
  private $query2;
  private $result2;
  private $id_ucz;
  public $uczen;
 
  //Funkcja - Potomek
  function potomek($id_user)
  {
	global $mysqli;
	
	$bazaRodzic = new rodzice;
	$id_rodz = $bazaRodzic->rodzic($id_user);
	
	$this->query = "SELECT id_ucz FROM rodzice WHERE id_rodz = '$id_rodz'";
  
	if(!$this->result = $mysqli->query($this->query))
	{
	 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	 $mysqli->close();
	}
	
	if($this->result->num_rows > 0)
	{
	  while($row=$this->result->fetch_object())
	  {
		$this->id_ucz = $row->id_ucz;
		$this->query2 = "SELECT id_user FROM uczen WHERE id_ucz = '$this->id_ucz'";
  
		if(!$this->result2 = $mysqli->query($this->query2))
		{
		   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
		   $mysqli->close();
		}
  
		$row2 = $this->result2->fetch_row();
		$uczen[] = $row2[0];
	  }	  
	}
  
	array_unique($uczen);
	return $uczen;
  }	
}
?>