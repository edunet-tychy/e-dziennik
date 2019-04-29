<?php
class programy
{
  private $result;
  private $row;
  
  function program($mysqli) 
  {
	if($this->result = $mysqli->query("SELECT id_prog, tytul_prog FROM programy ORDER BY tytul_prog"))
	{
	  if($this->result->num_rows > 0)
	  {
		echo'<option value="x">...</option>';
		while($this->row=$this->result->fetch_object())
		{
		  $id_prog = $this->row->id_prog;
		  $tytul = $this->row->tytul_prog;
		  
		  echo'<option value="'.$id_prog.'">'.$tytul.'</option>';		
		}
	  }
	}
  }	
}
?>