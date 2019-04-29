<?php
class ocenyPrzedmioty
{
  private $result;
  private $result2;
  private $row;
  private $row2;
  private $nr=0;

  //Funkcja - Przedmioty
  function przedmioty($id_kl,$id,$id_zaj,$mysqli)
  {
	  
	if($this->result = $mysqli->query("SELECT id_przed FROM klasy_przedmioty WHERE id_kl='$id_kl'"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($this->row=$this->result->fetch_object())
		{
			$id_przed = $this->row->id_przed;
			
			if($this->result2 = $mysqli->query("SELECT nazwa FROM przedmioty WHERE id_przed='$id_przed'"))
			{
			  if($this->result2->num_rows > 0)
			  {
				while($this->row2=$this->result2->fetch_object())
				{
				  $nazwa = $this->row2->nazwa;
				  if($id_zaj == $id_przed)
				  {
					echo' <li><a href="#nawigacja_sem" title="Przedmiot" class="zajecia aktywna" id="'.$id_przed.'">'.$nazwa.'</a></li>';
					$this->nr++;
				  } else {
					echo' <li><a href="#nawigacja_sem" title="Przedmiot" class="zajecia" id="'.$id_przed.'">'.$nazwa.'</a></li>';
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