<?php
class daneUcznia
{
  private $query;
  private $result;
  private $imie;
  private $nazwisko;
  public $dane;

  //Funkcja - Dane ucznia
  function dane($dziecko)
  {
	global $mysqli;
	
	$this->query = "SELECT nazwisko, imie FROM users WHERE id='$dziecko'";
	
	if(!$this->result = $mysqli->query($this->query))
	{
	   echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	   $mysqli->close();
	}
	
	$row = $this->result->fetch_row();
	
	$this->imie = $row[1];  
	$this->nazwisko = $row[0];
  
	$this->dane = $this->imie.' '.$this->nazwisko;
	return $this->dane;
  }	
}
?>