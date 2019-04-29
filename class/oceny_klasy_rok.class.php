<?php
class ocenyKlasy
{
   private $result;
   private $row;
   private $poz;
   private $oc;
   private $data;
   private $id_usr;
   private $id_kl;
   private $id_zaj;
   private $mysqli;  
   public $tab_oc;

  //Funkcja - Oceny
  public function oceny($id_kl,$id_zaj,$mysqli)
  {
	$this->id_kl = $id_kl;
	$this->id_zaj = $id_zaj;
	$this->mysqli = $mysqli;
	
	if($this->result = $mysqli->query("SELECT * FROM oceny_cz_2 WHERE id_kl='$this->id_kl' AND id_przed='$this->id_zaj'"))
	{
	  if($this->result->num_rows > 0)
	  {
		  
		while($this->row=$this->result->fetch_object())
		{
		  $this->poz=$this->row->poz;
		  $this->oc=$this->row->oc;
		  $this->data=$this->row->data;
		  $this->id_user=$this->row->id_user;
		  
		  $this->tab_oc[] = $this->poz.';'.$this->oc.';'.$this->data.';'.$this->id_user;
		  
		}
	  }
	}
	if(isset($this->tab_oc))
	return $this->tab_oc;
  }
}
?>