<?php
class wpisOceny
{
  private $result;
  private $row;
  private $poz;
  private $oc;
  private $data;
  private $id_user;
  
  //Funkcja - Oceny
  function oceny($id_kl,$id_zaj,$mysqli)
  {
	if($this->result = $mysqli->query("SELECT * FROM oceny_cz_2 WHERE id_kl='$id_kl' AND id_przed='$id_zaj'"))
	{
	  if($this->result->num_rows > 0)
	  {
		  
		while($this->row=$this->result->fetch_object())
		{
		  $this->poz=$this->row->poz;
		  $this->oc=$this->row->oc;
		  $this->data=$this->row->data;
		  $this->id_user=$this->row->id_user;
		  
		  $tab_oc[] = $this->poz.';'.$this->oc.';'.$this->data.';'.$this->id_user;
		  
		}
	  }
	}
	if(isset($tab_oc))
	return $tab_oc;
  }	
}
?>