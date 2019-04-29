<?php
class Kalendarz
{
  const dzien = 1;
  private $nazwa;
  private $czas;
  private $month;
  private $day;
  private $year;
  private $pierwszy;
  private $ile_dni;
  
  public function __construct()
  {
	$this->czas(); 
	$this->miesiace();
  }

  // Akcesor GET
  public function getCzas()
  {
	return $this->czas;
  }
  
  // Akcesor GET
  public function getPierwszy()
  {
	return $this->pierwszy;
  }
  
  // Akcesor GET
  public function getDni()
  {
	return $this->ile_dni;
  }
  
  // Akcesor GET  
  public function getMsc()
  {
	return $this->month;
  }
  
  // Akcesor GET
  public function getDzien()
  {
	return $this->day;
  }
  
  // Akcesor GET
  public function getRok()
  {
	return $this->year;
  }
  
  // Akcesor GET
  public function getNazwa()
  {
	return $this->nazwa;
  }

  // Funkcja zwaraca tablicę z nazwami miesięcy
  private function miesiace()
  {
	$this->nazwa = array
	(
	  '01' => 'STYCZEŃ',
	  '02' => 'LUTY',
	  '03' => 'MARZEC',
	  '04' => 'KWIECIEŃ',
	  '05' => 'MAJ',
	  '06' => 'CZERWIEC',
	  '07' => 'LIPIEC',
	  '08' => 'SIERPIEŃ',
	  '09' => 'WRZESIEŃ',
	  '10' => 'PAŹDZIERNIK',
	  '11' => 'LISTOPAD',
	  '12' => 'GRUDZIEŃ'
	);	  
  }
  
  // Funkcja ustawia zmienne związane z wybranym lub aktualnym czasem
  private function czas()
  {
	if(isset($_GET['t'])) {
	  $this->czas = $_GET['t'];
	} else {
	  $this->czas = time();
	}

	list($this->month, $this->day, $this->year) = explode('/', date('m/d/Y', $this->czas));
	
	$this->pierwszy = date('w', mktime(0, 0, 0, $this->month, 1, $this->year));
	$this->ile_dni = date('t', $this->czas);	
  }
}
?>