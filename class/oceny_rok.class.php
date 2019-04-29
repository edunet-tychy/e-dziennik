<?php
class propOcenyRok
{
  private $query;
  private $prop;
  private $data;
  public $pr;
 
  //Funkcja - Propozycja oceny rocznej
  function prop_rok($id,$id_przed,$id_kl)
  {
	global $mysqli;
	$baza = new zapytanie;
	
	$this->query = "SELECT prop, data FROM ocen_prop_rok WHERE id_user='$id' AND id_kl='$id_kl' AND id_przed='$id_przed'";
	$baza->pytanie($this->query);
	$this->prop = $baza->tab[0];
	$this->data = $baza->tab[1];
	
	$this->pr = $this->prop.'; '.$this->data;
	return $this->pr;
  }	
}

class ocenaRok
{
  private $query;
  private $sm;
  private $data;
  public $sem;
  
  //Funkcja - Ocena roczna
  function rok($id,$id_przed,$id_kl)
  {
	global $mysqli;
	$baza = new zapytanie;
	$this->query = "SELECT sem, data FROM ocen_rok WHERE id_user='$id' AND id_kl='$id_kl' AND id_przed='$id_przed'";
	$baza->pytanie($this->query);
	$this->sm = $baza->tab[0];
	$this->data = $baza->tab[1];
	
	$this->sem = $this->sm.'; '.$this->data;
	return $this->sem;
  }
}
?>