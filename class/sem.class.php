<?php
class semestr
{
  private $aktualny_miesiac;
  private $sem;
  private $db_sem;
  private $frek_sem;
  
  // Konstruktor
  public function __construct()
  {
	$this->sem();
  }

  // Funkcja zwraca aktualny semestr
  public function sem()
  {
	$this->akutalny_miesiac = date("n");
	
	if (($this->akutalny_miesiac > 1) && ($this->akutalny_miesiac < 9)) {
	  $this->sem = 'oceny_k.php';
	  $this->db_sem = 'db_oceny_k.php';
	  $this->frek_sem = 'frekwencja_rok.php';
	} else {
	  $this->sem = 'oceny.php';
	  $this->db_sem = 'db_oceny.php';
	  $this->frek_sem = 'frekwencja.php';
	}
  }
  
  // Akcesor GET
  public function getSem()
  {
	return $this->sem;
  }

  // Akcesor GET
  public function getDbSem()
  {
	return $this->db_sem;
  }

  // Akcesor GET
  public function getFrekSem()
  {
	return $this->frek_sem;
  }
}
?>