<?php
class plan_zajecia
{
  private $dane;
  private $dana;
  private $id_przed;
  private $id_kl;
  private $result;
  private $row;
  private $mysqli;
  private $id;
  private $dzien;
  private $nr_godz;
  private $gr;
  private $zestaw;
  private $bazaPlan;
  private $plan;
  public $planZew;

  //Funkcja - Plan zajęć
  public function plan_zajec($id,$mysqli)
  {
	$this->mysqli = $mysqli;
	$this->id = $id;
	
	$this->bazaPlan = new plan_KlasyPrzedmioty;
	$this->zestaw = $this->bazaPlan->klasy_przedmioty($this->id,$this->mysqli);
	
	if(isset($this->zestaw)) {
	  foreach($this->zestaw as $this->dane)
	  {
		$this->dana = explode('; ', $this->dane);
	
		$this->id_przed = $this->dana[0];
		$this->id_kl = $this->dana[1];
	
		if($this->result = $this->mysqli->query("SELECT dzien, nr_godz, gr FROM plan_zajec WHERE id_przed='$this->id_przed' AND id_kl='$this->id_kl'"))
		{
		  if($this->result->num_rows > 0)
		  {
			while($this->row=$this->result->fetch_object())
			{
			  $this->dzien = $this->row->dzien;
			  $this->nr_godz = $this->row->nr_godz;
			  $this->gr = $this->row->gr;
  
			  $plan[] = $this->dzien.'; '.$this->nr_godz.'; '.$this->id_przed.'; '.$this->gr.'; '.$this->id_kl;	
			}
		  }
		}
	  }		
	}

	if (isset($plan)) {
	  $this->planZew = $plan;	
	}
	
	if (isset($this->planZew)) {
	  return $this->planZew;
	}
  }

}
?>