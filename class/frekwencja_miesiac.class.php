<?php
class frekwencjaMiesiaca
{
  private $result;
  private $row;
  private $data;
  private $termin;
  private $m;
  private $stan;
  private $u = 0;
  private $n = 0;
  private $s = 0;
  private $id_ucz;
  private $mysqli;

  //Funkcja - frekwencja miesiąca
  function frek_msc($id_ucz,$m,$mysqli)
  {
	$this->mysqli = $mysqli;
	$this->id_ucz = $id_ucz;
	$this->m = $m;
	
	if($this->result = $this->mysqli->query("SELECT data,stan FROM frekwencja WHERE id_ucz='$this->id_ucz'"))
	{
	  while($this->row=$this->result->fetch_object())
	  {
		 $this->data = $this->row->data;
		 $this->termin = date("m",strtotime($this->data));
		 
		 if($this->termin == $this->m)
		 {
		   $this->stan = $this->row->stan;
		   switch($this->stan)
		   {
			 case 'u': $this->u++; break;
			 case 'n': $this->n++; break;
			 case 's': $this->s++; break;
		   }
		 }
	  }
	  
	  if($this->u == 0) $this->u = '';
	  if($this->n == 0) $this->n = '';
	  if($this->s == 0) $this->s = '';
	  
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