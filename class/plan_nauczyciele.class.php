<?php
class plan_nauczyciele
{
  private $result;
  private $row;
  private $mysqli;
  private $id;
  public $id_kp;
  
  //Funkcja - klasy_nauczyciele
  public function klasy_nauczyciele($id,$mysqli) 
  {
	$this->id = $id;
	$this->mysqli = $mysqli;
	
	if($this->result = $mysqli->query("SELECT id_kp FROM klasy_nauczyciele WHERE id_naucz='$this->id'"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($this->row=$this->result->fetch_object())
		{
		  $this->id_kp[] = $this->row->id_kp;	
		}
	  }
	}
	return $this->id_kp;
  }	
}
?>