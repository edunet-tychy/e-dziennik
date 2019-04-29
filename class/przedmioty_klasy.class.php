<?php
class przedmiotyKlasy
{
  private $wynik;
  private $przedmiot;
  public $nazwa;
  
  //Funkcja - nazwa przedmiotu
  function przedmiot($id_przed)
  {
	global $mysqli;
  
	$this->przedmiot = "SELECT nazwa FROM przedmioty WHERE id_przed='$id_przed'";
	
	if(!$zapytanie1 = $mysqli->query($this->przedmiot))
	{
	 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	 $mysqli->close();
	}
	
	$wynik = $zapytanie1->fetch_row();
	$this->nazwa = $wynik[0];
	
	echo $this->nazwa;
  }
}
?>