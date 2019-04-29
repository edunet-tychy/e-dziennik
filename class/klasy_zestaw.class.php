<?php
class klasyZestaw
{
  private $kl;
  private $zapytanie;
  private $wynik;
  private $klasa;
  private $sb;
  private $id_kl;
  private $mysqli;
  public $tab;

  //Funkcja - Klasa
  public function klasa($id_kl,$mysqli)
  {
	$this->id_kl = $id_kl;
	$this->mysqli = $mysqli;
	$this->kl = "SELECT klasa, sb FROM vklasy WHERE id_kl='$this->id_kl'";
	
	if(!$this->zapytanie = $this->mysqli->query($this->kl)){
	  echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	  $this->mysqli->close();
	}
  
	$this->wynik = $this->zapytanie->fetch_row();
	$this->klasa = $this->wynik[0];	
	$this->sb = $this->wynik[1];
	
	$this->tab = $this->klasa .' '. $this->sb;
	
	return $this->tab;
  }
}
?>