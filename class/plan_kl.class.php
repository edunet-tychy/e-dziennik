<?php
class plan_kl
{
  private $query;
  private $klasa;
  private $sb;
  private $mysqli;
  private $id_kl;
  public $dane;
  
  //Funkcja - klasa
  public function kl($id_kl,$mysqli)
  {
	$this->mysqli = $mysqli;
	$this->id_kl = $id_kl;
	
	$baza = new zapytanie;
	$this->query = "SELECT klasa, sb FROM vklasy WHERE id_kl='$this->id_kl'";
	$baza->pytanie($this->query);
	
	$this->klasa = $baza->tab[0];	
	$this->sb = $baza->tab[1];
	$this->dane = $this->klasa.' '.$this->sb;
	
	return $this->dane;
  }	
}
?>