<?php
class statystykaKlasySrednie
{
  private $result;
  private $id_kl;
  public $klsr;
  

  public function srKlasy($sem)
  {
	global $mysqli;
	$baza = new zapytanie;
	
	if($this->result = $mysqli->query("SELECT id_kl FROM $sem"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($row=$this->result->fetch_object())
		{
		   $id_kl[] = $row->id_kl;
		}
	  }
	}
	
	if(isset($id_kl))
	{
	  $id_kl = array_unique($id_kl);
	  
	  foreach ($id_kl as $kl)
	  {
		 $query = "SELECT avg(sem) FROM $sem WHERE id_kl='$kl'";
		 $baza->pytanie($query);
		 $sr = $baza->tab[0];
  
		 $sr = number_format($sr, 2, '.', '');
		 
		 $query = "SELECT klasa,sb FROM vklasy WHERE id_kl='$kl'";
		 $baza->pytanie($query);
		 
		 $klasa = $baza->tab[0];
		 $sb = $baza->tab[1];
		 
		 $klsr[] = $klasa.'; '.$sb.'; '.$sr;		
	  }
	}
	
	if(isset($klsr))
	{
	  sort($klsr);
	  return $klsr;
	}
  }	
}
?>