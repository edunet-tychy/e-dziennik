<?php
class statystykaKlasyFr
{
  private $result;
  private $id_kl;
  public $klsr;

  public function srKlasy($sem, $msc)
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
	
	if($msc == 1)
	{
	  if(isset($id_kl))
	  {
		$id_kl = array_unique($id_kl);
		
		foreach ($id_kl as $kl)
		{
		  $query = "SELECT count(stan) FROM $sem WHERE id_kl='$kl' AND stan='u' AND (month(data) > 8 OR month(data) < 2)";
		  $baza->pytanie($query);
		  $us = $baza->tab[0];
		   
		  $query = "SELECT count(stan) FROM $sem WHERE id_kl='$kl' AND stan='n' AND (month(data) > 8 OR month(data) < 2)";
		  $baza->pytanie($query);
		  $ns = $baza->tab[0];
		  
		  $query = "SELECT count(stan) FROM $sem WHERE id_kl='$kl' AND stan='o' OR stan ='s' AND (month(data) > 8 OR month(data) < 2)";
		  $baza->pytanie($query);
		  $ob = $baza->tab[0];
		   
		  $nb = $us + $ns;
		  $suma = $ob+$nb;
		  if($suma > 0)
		  $wynik = ($ob*100)/$suma;
		   
		  @$wynik = number_format($wynik, 2, '.', '');
		  
		  $query = "SELECT klasa,sb FROM vklasy WHERE id_kl='$kl'";
		  $baza->pytanie($query);
			
		  $klasa = $baza->tab[0];
		  $sb = $baza->tab[1];
		  
		  $klsr[] = $klasa.'; '.$sb.'; '.$wynik;		
		}
	  }		
	} elseif ($msc == 6){
	  if(isset($id_kl))
	  {
		$id_kl = array_unique($id_kl);
		
		foreach ($id_kl as $kl)
		{
		  $query = "SELECT count(stan) FROM $sem WHERE id_kl='$kl' AND stan='u' AND month(data) < 7 AND month(data) != 1";
		  $baza->pytanie($query);
		  $us = $baza->tab[0];
		   
		  $query = "SELECT count(stan) FROM $sem WHERE id_kl='$kl' AND stan='n' AND month(data) < 7 AND month(data) != 1";
		  $baza->pytanie($query);
		  $ns = $baza->tab[0];
		  
		  $query = "SELECT count(stan) FROM $sem WHERE id_kl='$kl' AND stan='o' AND month(data) < 7 AND month(data) != 1";
		  $baza->pytanie($query);
		  $ob = $baza->tab[0];
		   
		  $nb = $us + $ns;
		  $suma = $ob+$nb;
		  
		  if($suma > 0)
		  $wynik = ($ob*100)/$suma;
		   
		  @$wynik = number_format($wynik, 2, '.', '');
		  
		  $query = "SELECT klasa,sb FROM vklasy WHERE id_kl='$kl'";
		  $baza->pytanie($query);
			
		  $klasa = $baza->tab[0];
		  $sb = $baza->tab[1];
		  
		  $klsr[] = $klasa.'; '.$sb.'; '.$wynik;		
		}
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