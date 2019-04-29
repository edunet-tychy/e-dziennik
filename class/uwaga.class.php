<?php
class uwaga
{
  private $mysqli;
  private $row;
  private $result;
  private $id_uw;
  private $data;
  private $tresc;
  private $id_ucz;
  private $nazwisko;
  private $imie;

  //Funkcja - Uwagi
  function uwagi($id_kl,$id,$mysqli)
  {
	$this->mysqli = $mysqli;
	
	$bazaUser = new uwagi_user;
	
	if($this->result = $this->mysqli->query("SELECT * FROM uwagi WHERE id_kl = '$id_kl' AND id_naucz='$id'"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($this->row=$this->result->fetch_object())
		{	
		  $this->id_uw = $this->row->id_uw;
		  $this->data = $this->row->data;
		  $this->tresc = $this->row->tresc;
		  $this->id_ucz = $this->row->id_ucz;
		  
		  $zestaw = $bazaUser->uczniowie($this->id_ucz,$this->mysqli);
		  
		  if($zestaw != '')
		  {
			$dane = explode('; ',$zestaw[0]);
			
			$this->nazwisko = $dane[0];
			$this->imie = $dane[1];
			
			$wpis[] = $this->id_uw.'; '.$this->nazwisko.'; '.$this->imie.'; '.$this->data.'; '.$this->tresc;			
		  }
  
		}
	  }
	}
	if(isset($wpis)) 
	{
	  rsort($wpis);
	  return $wpis;
	}
  }	
}
?>