<?php
class plan_KlasyPrzedmioty
{
  private $klasy_nauczyciele;
  private $id_kp;
  private $query;
  private $mysqli;
  private $id_przed;
  private $n_kl;
  private $id;
  public $kl_przed;

  //Funkcja - klasy_przedmioty
  public function klasy_przedmioty($id,$mysqli) 
  {
	$this->mysqli = $mysqli;
	$this->id = $id;
	
	$bazaNa = new plan_nauczyciele;
	$this->klasy_nauczyciele = $bazaNa->klasy_nauczyciele($this->id,$this->mysqli);
	
	$baza = new zapytanie;
	
	if(isset($this->klasy_nauczyciele)) {
	  foreach ($this->klasy_nauczyciele as $this->id_kp)
	  {
		$this->query = "SELECT id_przed, id_kl FROM klasy_przedmioty WHERE id_kp='$this->id_kp'";
		$baza->pytanie($this->query);
		$this->id_przed = $baza->tab[0];
		$this->n_kl = $baza->tab[1];
		
		$this->kl_przed[] = $this->id_przed.'; '.$this->n_kl;
	  }		
	}

  return $this->kl_przed;
  }	
}
?>