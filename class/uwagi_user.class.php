<?php
class uwagi_user
{
  private $id_ucz;
  private $result;
  private $row;
  private $mysqli;
  private $nazwisko;
  private $imie;
  public $uczen;

  //Funkcja - Uczniowie
  function uczniowie($id_ucz, $mysqli)
  {
	$this->id_ucz = $id_ucz;
	$this->mysqli = $mysqli;
  
	if($this->result = $this->mysqli->query("SELECT nazwisko, imie FROM users WHERE id='$this->id_ucz'"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($this->row=$this->result->fetch_object())
		{
		  $this->nazwisko = $this->row->nazwisko;
		  $this->imie = $this->row->imie;
		}
	  }
	$uczen[] = $this->nazwisko.'; '.$this->imie;		  
	}
  
	return $uczen;
  }	
}
?>