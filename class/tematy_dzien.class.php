<?php
class tematyDzien
{
  public $tdzien;

  //Funkcja - Dzień tygodnia słownie
  function dzien()
  {
	$this->tdzien = date("w");
	switch($this->tdzien)
	{
	  case 0 : $this->tdzien = 'Niedziela'; break;
	  case 1 : $this->tdzien = 'Poniedziałek'; break;
	  case 2 : $this->tdzien = 'Wtorek'; break;
	  case 3 : $this->tdzien = 'Środa'; break;
	  case 4 : $this->tdzien = 'Czwartek'; break;
	  case 5 : $this->tdzien = 'Piątek'; break;
	  case 6 : $this->tdzien = 'Sobota'; break;
	}
	return $this->tdzien;
  }	
}
?>