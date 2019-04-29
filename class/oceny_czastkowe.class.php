<?php
class ocenyCzastkoweSem
{
  private $result;

  //Funkcja - Oceny cząstkowe
  public function oceny($id,$id_przed,$id_kl)
  {
	global $mysqli;
	
	if($this->result = $mysqli->query("SELECT * FROM oceny_cz_1 WHERE id_user='$id' AND id_przed='$id_przed' AND id_kl='$id_kl' ORDER BY poz"))
	{
	  while($row=$this->result->fetch_object())
	  {
		$oc[] = $row->poz.'; '.$row->oc.'; '.$row->data;	
	  }
	}
	if(isset($oc))
	{
	  return $oc; 	  
	}
  }	
}

class ocenyCzastkoweKon
{
  private $result;

  //Funkcja - Oceny cząstkowe
  public function oceny($id,$id_przed,$id_kl)
  {
	global $mysqli;
	
	if($this->result = $mysqli->query("SELECT * FROM oceny_cz_2 WHERE id_user='$id' AND id_przed='$id_przed' AND id_kl='$id_kl' ORDER BY poz"))
	{
	  while($row=$this->result->fetch_object())
	  {
		$oc[] = $row->poz.'; '.$row->oc.'; '.$row->data;	
	  }
	}
	if(isset($oc))
	{
	  return $oc; 	  
	}
  }	
}

class opisOcenyCzastkowej
{
  private $result;

  //Funkcja - Opis oceny cząstkowej
  function opis_oc($id_przed,$id_kl)
  {
	global $mysqli;
	
	if($this->result = $mysqli->query("SELECT poz,opis FROM oceny_op WHERE id_przed='$id_przed' AND id_kl='$id_kl' ORDER BY poz"))
	{
	  while($row=$this->result->fetch_object())
	  {
		$opis[] = $row->poz.'; '.$row->opis;	
	  }
	}
	if(isset($opis))
	{
	  return $opis;  
	}
  }	
}

class opisOcenyCzastkowejKon
{
  private $result;

  //Funkcja - Opis oceny cząstkowej sem II
  function opis_oc($id_przed,$id_kl)
  {
	global $mysqli;
	
	if($this->result = $mysqli->query("SELECT poz,opis FROM oceny_op_k WHERE id_przed='$id_przed' AND id_kl='$id_kl' ORDER BY poz"))
	{
	  while($row=$this->result->fetch_object())
	  {
		$opis[] = $row->poz.'; '.$row->opis;	
	  }
	}
	if(isset($opis))
	{
	  return $opis;  
	}
  }	
}

?>