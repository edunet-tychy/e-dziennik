<?php
class uwagiEdycja
{
  private $wpis;
  private $zapytanie;
  public $wynik;
  
  //Funkcja - Uwagi
  public function uwaga($id_uw,$mysqli)
  {
	$this->wpis = "SELECT * FROM uwagi WHERE id_uw='$id_uw'";
  
	if(!$this->zapytanie = $mysqli->query($this->wpis))
	{
	  echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	  $mysqli->close();
	}
  
	$this->wynik = $this->zapytanie->fetch_row();
	return $this->wynik;
  }	
}
?>