<?php
class propOcenySemestr
{
  private $query;
  private $prop;
  private $data;
  public $pr;
 
  //Funkcja - Propozycja oceny semestralnej
  function prop_sem($id,$id_przed,$id_kl)
  {
	global $mysqli;
	$baza = new zapytanie;
	
	$this->query = "SELECT prop, data FROM ocen_prop_sem WHERE id_user='$id' AND id_kl='$id_kl' AND id_przed='$id_przed'";
	$baza->pytanie($this->query);
	$this->prop = $baza->tab[0];
	$this->data = $baza->tab[1];
	
	$this->pr = $this->prop.'; '.$this->data;
	return $this->pr;
  }	
}

class ocenaSemestr
{
  private $query;
  private $sm;
  private $data;
  public $sem;
  
  //Funkcja - Ocena semestralna
  function sem($id,$id_przed,$id_kl)
  {
	global $mysqli;
	$baza = new zapytanie;
	$this->query = "SELECT sem, data FROM ocen_sem WHERE id_user='$id' AND id_kl='$id_kl' AND id_przed='$id_przed'";
	$baza->pytanie($this->query);
	$this->sm = $baza->tab[0];
	$this->data = $baza->tab[1];
	
	$this->sem = $this->sm.'; '.$this->data;
	return $this->sem;
  }
}
?>