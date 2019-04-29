<?php
class tablicaObecnosc
{
  private $i;
  public $tabs;
  //Funkcja - uzupełnia tablicę z obecnościami
  public function uzup_tab($tabs)
  {
	for($this->i=0; $this->i<11; $this->i++)
	{
	  if (!isset($this->tabs[$i]))
	  {
	   $this->tabs[$i] = '';
	  }
	}
	return $this->tabs;
  }
}

class dniTygodnia
{
  public $dzien;
 
  //Funkcja - Dzień tygodnia
  public function dni_tyg($day)
  {
	switch($day)
	{
	  case 'Monday': $this->dzien = 'Poniedziałek';
		break;
	  case 'Tuesday': $this->dzien = 'Wtorek';
		break;
	  case 'Wednesday': $this->dzien = 'Środa';
		break;
	  case 'Thursday': $this->dzien = 'Czwartek';
		break;
	  case 'Friday': $this->dzien = 'Piątek';
		break;
	  case 'Saturday': $this->dzien = 'Sobota';
		break;
	  case 'Sunday': $this->dzien = 'Niedziela';
		break;					
	}
	return $this->dzien;
  }	
}

class miesiace
{
  public $miesac;
  
  //Funkcja - miesiąc
  public function msc($msc)
  {
	switch($msc)
	{
	  case '1': $this->miesiac = 'Styczeń';
		break;
	  case '2': $this->miesiac = 'Luty';
		break;
	  case '3': $this->miesiac = 'Marzec';
		break;
	  case '4': $this->miesiac = 'Kwiecień';
		break;
	  case '5': $this->miesiac = 'Maj';
		break;
	  case '6': $this->miesiac = 'Czerwiec';
		break;
	  case '9': $this->miesiac = 'Wrzesień';
		break;
	  case '10': $this->miesiac = 'Październik';
		break;
	  case '11': $this->miesiac = 'Listopad';
		break;
	  case '12': $this->miesiac = 'Grudzień';
		break;					
	}
	return $this->miesiac;
  }
}

class zliczanie
{
  private $result;
  private $stan;
  private $sum;
  public $wynik;
  
  //Funkcja - Zliczenie nieobecności miesiącznej
  function suma($msc,$id_kl,$id)
  {
   global $mysqli;
	if($this->result = $mysqli->query("SELECT data,godzina,stan FROM frekwencja WHERE month(data)='$msc' AND id_kl='$id_kl' AND id_ucz='$id' AND stan != 'o' ORDER BY data DESC,godzina"))
	{
	  if($this->result->num_rows > 0)
	  {
		$s=0;
		$n=0;
		$u=0;
		
		while($row=$this->result->fetch_object())
		{
		  $stan = $row->stan;
		  switch($stan)
		  {
			case 'u': $u++;
			  break;
			case 'n': $n++;
			  break;
			case 's': $s++;
			  break;					
		  }		
		}
	  }
	}
	if(!isset($n)) $n=0;
	if(!isset($u)) $u=0;
	if(!isset($s)) $s=0;
	$this->sum = $n + $u;
	
	$this->wynik = $this->sum.'; '.$u.'; '.$n.'; '.$s;
	
	if(isset($this->wynik)) return $this->wynik;
  }
}

?>