<?php
class uwagaUczen
{
  private $wpis;
  private $zapytanie;
  public $wynik;
  
  //Funkcja - Uczeń
  public function uczen($id_ucz,$mysqli)
  {
	$this->wpis = "SELECT nazwisko, imie FROM users WHERE id='$id_ucz'";
  
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