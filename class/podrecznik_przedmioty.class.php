<?php
class przedmioty
{
  private $result;
  private $result2;
  private $result3;
  private $row;
  private $row2;
  private $row3;
  
  function przedmiot($id, $id_kl,$mysqli)
  {
	if($this->result = $mysqli->query("SELECT id_kp FROM klasy_nauczyciele WHERE id_naucz='$id'"))
	{
	  if($this->result->num_rows > 0)
	  {
		echo'<option value="x">...</option>';
		while($this->row=$this->result->fetch_object())
		{
		  $id_kp = $this->row->id_kp;
		  if($this->result2 = $mysqli->query("SELECT id_przed FROM klasy_przedmioty WHERE id_kp='$id_kp' AND id_kl='$id_kl'"))
		  {
			if($this->result2->num_rows > 0)
			{
			  while($this->row2=$this->result2->fetch_object())
			  {
				$id_przed=$this->row2->id_przed;			
				if($this->result3 = $mysqli->query("SELECT nazwa FROM przedmioty WHERE id_przed='$id_przed'"))
				{
				  if($this->result3->num_rows > 0)
				  {
					while($this->row3=$this->result3->fetch_object())
					{
					  $nazwa = $this->row3->nazwa;
					  
					  echo'<option value="'.$id_przed.'">'.$nazwa.'</option>';	
					}
				  }  
				}			  
			  }
			}
		  }
		}
	  }
	}
  }	
}
?>