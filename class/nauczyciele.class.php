<?php
class nauczyciele
{
  private $zapytanie;
  private $odp;
  private $wiersz;
  
  //Funkcja - nauczyciele
  public function nauczyciel()
  {
	global $mysqli;
  
	$this->zapytanie = "SELECT id, imie, nazwisko FROM users WHERE id_st=4 ORDER BY nazwisko";
	
	if($this->odp = $mysqli->query($this->zapytanie))
	{
	  if($this->odp->num_rows > 0)
	   {
		while($this->wiersz=$this->odp->fetch_object())
		{
			echo '<option value="'.$this->wiersz->id .'">'.$this->wiersz->nazwisko.' '.$this->wiersz->imie.'</option>';
		}
	  }	
	}
  }
}
?>