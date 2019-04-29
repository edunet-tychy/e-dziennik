<?php
class ocenyKlasa
{
  private $kl;
  private $zapytanie;
  private $wynik;
  private $klasa;
  private $sb;
  public $tab;
  
  //Funkcja - Klasa
  function klasa($id_kl,$mysqli)
  {
	$this->kl = "SELECT klasa, sb FROM vklasy WHERE id_kl='$id_kl'";
	
	if(!$this->zapytanie = $mysqli->query($this->kl)){
	  echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	  $mysqli->close();
	}
  
	$this->wynik = $this->zapytanie->fetch_row();
	$this->klasa = $this->wynik[0];	
	$this->sb = $this->wynik[1];
	
	$this->tab = $this->klasa .' '. $this->sb;
	
	return $this->tab;
  }
	
}
?>