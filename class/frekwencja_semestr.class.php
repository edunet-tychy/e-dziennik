<?php
class frekwencjaSemestr
{
  private $result;
  private $row;
  private $u = 0;
  private $n = 0;
  private $s = 0;
  private $stan;
  private $data;
  private $termin;
  private $id_ucz;
  private $mysqli;
  
  //Funkcja - frekwencja semestralna
  function frek_sem($id_ucz,$mysqli)
  {

	$this->mysqli = $mysqli;	
	$this->id_ucz = $id_ucz;
	
	if($this->result = $this->mysqli->query("SELECT data,stan FROM frekwencja WHERE id_ucz='$this->id_ucz'"))
	{
	  while($this->row=$this->result->fetch_object())
	  {
		 $this->stan = $this->row->stan;
		 
		 $this->data = $this->row->data;
		 $this->termin = date("m",strtotime($this->data));
		 
		 if($this->termin == '09' || $this->termin == '10' || $this->termin == '11' || $this->termin == '12' || $this->termin == '01')
		 {	   	   
		   switch($this->stan)
		   {
			 case 'u': $this->u++; break;
			 case 'n': $this->n++; break;
			 case 's': $this->s++; break;
		   }
		 }
	  }
	  
	  echo'<td>'.$this->u.'</td>';
	  echo'<td>'.$this->n.'</td>';
	  echo'<td id="prawy">'.$this->s.'</td>';
	}
	 
	 $this->u = 0;
	 $this->n = 0;
	 $this->s = 0;	
  }	
}
?>