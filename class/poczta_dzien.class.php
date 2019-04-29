<?php
class dzien
{
  private $dzn;
  public $dzien;
  
  //Funkcja - Dzień tygodnia słownie
  public function dzw()
  {
	$this->dzn = date("w");
	switch($this->dzn)
	{
	  case 0 : $this->dzien = 'niedziela'; break;
	  case 1 : $this->dzien = 'poniedziałek'; break;
	  case 2 : $this->dzien = 'wtorek'; break;
	  case 3 : $this->dzien = 'środa'; break;
	  case 4 : $this->dzien = 'czwartek'; break;
	  case 5 : $this->dzien = 'piątek'; break;
	  case 6 : $this->dzien = 'sobota'; break;
	}
	return $this->dzien;
  }
}
?>