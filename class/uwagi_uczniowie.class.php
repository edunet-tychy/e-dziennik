<?php
class uwagiUczniowie
{
  private $result;
  private $result2;
  private $row;
  private $row2;
  private $nazwisko;
  private $imie;
  private $id_user;

  //Funkcja - Uczniowie
  public function uczniowie($id_kl,$mysqli)
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
		  $uczen[] = $this->id_user.'; '.$this->nazwisko.'; '.$this->imie;		  
		  }
		}
	  }  
	}
	return $uczen;
  }	
}
?>