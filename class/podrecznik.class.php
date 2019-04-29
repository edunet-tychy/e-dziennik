<?php
class podrecznik
{
  private $result;
  private $row;
  
  function podreczniki($mysqli) 
  {
	if($this->result = $mysqli->query("SELECT id_pod, tytul FROM podreczniki ORDER BY tytul"))
	{
	  if($this->result->num_rows > 0)
	  {
		echo'<option value="x">...</option>';
		while($this->row=$this->result->fetch_object())
		{
		  $id_pod = $this->row->id_pod;
		  $tytul = $this->row->tytul;
		  
		  echo'<option value="'.$id_pod.'">'.$tytul.'</option>';		
		}
	  }
	}
  }	
}
?>