<?php
class uwagiKlasa
{
  private $kl;
  private $zapytanie;
  public $wynik;
 
  //Funkcja - Klasa
  public function klasa($id_kl,$mysqli)
  {
	$this->kl = "SELECT klasa, sb FROM vklasy WHERE id_kl='$id_kl'";
  
	if(!$this->zapytanie = $mysqli->query($this->kl))
	{
	  echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	  $mysqli->close();
	}
  
	$this->wynik = $this->zapytanie->fetch_row();
	return $this->wynik;
  }	
}
?>