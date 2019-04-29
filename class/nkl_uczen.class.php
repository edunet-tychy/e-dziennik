<?php
class uczniowieNieklasyfikowani
{
  private $result;
  private $id_user;
  private $id_przed;
  private $id_kl;
  private $row;
  private $query;
  private $nazwisko;
  private $imie;
  private $klasa;
  private $sb;
  private $przed;
  private $ile;
  private $sem;
  private $ocena;
  public $tab_nkl;
  
  //Funkcja - nieklasyfikowania
  function nkl($sem,$ocena)
  {
	global $mysqli;
	$baza = new zapytanie;
	
	$this->sem = $sem;
	$this->ocena = $ocena;
  
	if($this->result = $mysqli->query("SELECT id_user,id_przed,id_kl FROM $this->sem WHERE sem='$this->ocena'"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($this->row=$this->result->fetch_object())
		{
		  $this->id_user = $this->row->id_user;
		  $this->id_przed = $this->row->id_przed;
		  $this->id_kl =  $this->row->id_kl;
		  
		  $this->query = "SELECT nazwisko,imie FROM users WHERE id='$this->id_user'";
		  $baza->pytanie($this->query);
		  
		  $this->nazwisko = $baza->tab[0];
		  $this->imie = $baza->tab[1];
		  
		  $this->query = "SELECT klasa,sb FROM vklasy WHERE id_kl='$this->id_kl'";
		  $baza->pytanie($this->query);
		  
		  $this->klasa = $baza->tab[0];
		  $this->sb = $baza->tab[1];
		  
		  $this->query = "SELECT nazwa FROM przedmioty WHERE id_przed='$this->id_przed'";
		  $baza->pytanie($this->query);
		  
		  $this->przed = $baza->tab[0];
		  
		  $this->query = "SELECT count(sem) FROM $sem WHERE sem='$this->ocena' AND id_user='$this->id_user'";
		  $baza->pytanie($this->query);
		  
		  $this->ile = $baza->tab[0];
		  
		  $this->tab_nkl[] = $this->klasa.'; '.$this->sb.'; '.$this->nazwisko.'; '.$this->imie.'; '.$this->przed.'; '.$this->ile;
		}
	  }
	}
	if(isset($this->tab_nkl))
	{
	  sort($this->tab_nkl);
	  return $this->tab_nkl;
	}
  }	
}
?>