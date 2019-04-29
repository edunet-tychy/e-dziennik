<?php
class users
{
  private $query;
  private $result;
  private $nazwisko;
  private $imie;
  public $id_st;
  public $dane;
  
  //Funkcja - Użytkownik
  public function user($id)
  {
	global $mysqli;
	
	$this->query = "SELECT * FROM users WHERE id = '$id'";
  
	if(!$this->result = $mysqli->query($this->query))
	{
	 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	 $mysqli->close();
	}
	
	if($this->result->num_rows > 0)
	{
	  while($row = $this->result->fetch_object())
	  {
		$this->nazwisko = $row->nazwisko;
		$this->imie = $row->imie;
		$this->id_st = $row->id_st;
		$this->dane = $this->nazwisko.' '.$this->imie;
	  }	  
	}
	return $this->dane;
  }	
}

class statusy
{
  private $query;
  private $result;
  public $rola;
  public $id_st;

  //Funkcja - Status
  public function status($id)
  {
	global $mysqli;

	$this->id_st = $this->user_st($id);
	
	$this->query = "SELECT rola FROM status WHERE id_st = '$this->id_st'";
	
	if(!$this->result = $mysqli->query($this->query))
	{
	 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	 $mysqli->close();
	}
  
	if($this->result->num_rows > 0)
	{
	  while($row=$this->result->fetch_object())
	  {
		$this->rola = $row->rola; 
	  }	  
	}
	return $this->rola;
  }

  //Funkcja - Rola
  public function user_st($id)
  {
	global $mysqli;
	
	$this->query = "SELECT * FROM users WHERE id = '$id'";
  
	if(!$this->result = $mysqli->query($this->query))
	{
	 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	 $mysqli->close();
	}
	
	if($this->result->num_rows > 0)
	{
	  while($row=$this->result->fetch_object())
	  {
		$this->id_st = $row->id_st;
	  }	  
	}
	return $this->id_st;
  }
}
?>