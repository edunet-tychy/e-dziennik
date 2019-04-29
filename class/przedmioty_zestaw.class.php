<?php
class przedmiotyZestaw
{
  private $result;
  private $result2;
  private $row;
  private $row2;
  private $nr=0;
  private $id_przed;
  private $nazwa;
  private $id;
  private $id_kl;
  private $id_zaj;
  private $mysqli;
  
  //Funkcja - Przedmioty
  public function przedmioty($id_kl,$id,$id_zaj,$mysqli)
  {
	 $this->id_kl = $id_kl;
	 $this->id = $id;
	 $this->id_zaj = $id_zaj;
	 $this->mysqli = $mysqli;
	  
	if($this->result = $mysqli->query("SELECT id_przed FROM klasy_przedmioty WHERE id_kl='$this->id_kl'"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($this->row=$this->result->fetch_object())
		{
			$this->id_przed = $this->row->id_przed;
			
			if($this->result2 = $mysqli->query("SELECT nazwa FROM przedmioty WHERE id_przed='$this->id_przed'"))
			{
			  if($this->result2->num_rows > 0)
			  {
				while($this->row2=$this->result2->fetch_object())
				{
				  $this->nazwa = $this->row2->nazwa;
				  if($this->id_zaj == $this->id_przed)
				  {
					echo' <li><a href="#nawigacja_sem" title="Przedmiot" class="zajecia aktywna" id="'.$this->id_przed.'">' .$this->nazwa. '</a></li>';
					$this->nr++;
				  } else {
					echo' <li><a href="#nawigacja_sem" title="Przedmiot" class="zajecia" id="'.$this->id_przed.'">' .$this->nazwa. '</a></li>';
					$this->nr++;					
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