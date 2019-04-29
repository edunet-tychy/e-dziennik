<?php
class tematUsers
{
  private $result;
  private $result2;
  private $row;
  private $row2;
  private $id_user;
  private $nazwisko;
  private $imie;
  
  //Funkcja - Uczniowie
  function uczniowie($id_kl,$mysqli)
  {
  
	if($this->result = $mysqli->query("SELECT id_user FROM uczen WHERE id_kl='$id_kl'"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($this->row=$this->result->fetch_object())
		{
		  $this->id_user = $this->row->id_user;
		  
		  if($this->result2 = $mysqli->query("SELECT nazwisko, imie FROM users WHERE id='$this->id_user'"))
		  {
			if($this->result2->num_rows > 0)
			{
			  while($this->row2=$this->result2->fetch_object())
			  {
				$this->nazwisko = $this->row2->nazwisko;
				$this->imie = $this->row2->imie;
			  }
			}
				
		  // Polskie znaki - zmiana
		  $search = array('Ś','Ł','Ź');
		  $replace = array('Szz','Lzz','Nzz');
		  $this->nazwisko = str_replace($search, $replace,$this->nazwisko);
		
		  $uczen[] = $this->nazwisko.'; '.$this->imie.'; '.$this->id_user;		  
		  }
		}
	  }  
	}
	if(isset($uczen)){ return $uczen; }
  }	
}
?>