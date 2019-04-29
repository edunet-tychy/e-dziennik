<?php
class zawody
{
  private $zapytanie;
  private $odp;
  private $wiersz;

  //Funkcja - zawod
  public function zawod()
  {
	global $mysqli;
	
	$this->zapytanie = "SELECT id_zw, nazwa FROM zawod";
  
	if($this->odp = $mysqli->query($this->zapytanie))
	{
	  if($this->odp->num_rows > 0)
	   {
		while($this->wiersz=$this->odp->fetch_object())
		{
		  echo '<option value="'.$this->wiersz->id_zw .'">'.$this->wiersz->nazwa.'</option>';
		}
	   }	
	}
  }
}
?>