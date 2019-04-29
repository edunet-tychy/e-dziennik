<?php
class najlpSpUczniowie
{
  private $result;
  private $id_user;
  private $id_kl;
  private $row;
  private $query;
  private $nkl;
  private $nazwisko;
  private $imie;
  private $klasa;
  private $sb;
  private $sr;
  private $zm;
  private $form;
  public $tab_beznkl;
  
  //Funkcja - uczniowie bez nkl
  public function bez_nkl($sem,$zm)
  {
	global $mysqli;
	
	$this->zm = $zm;
	$baza = new zapytanie;
  
	if($this->result = $mysqli->query("SELECT id_user,id_kl FROM $sem ORDER BY id_user"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($this->row=$this->result->fetch_object())
		{
		  $this->id_user = $this->row->id_user;
		  $this->id_kl =  $this->row->id_kl;
		  
		  $this->query = "SELECT count(sem) FROM $sem WHERE id_user='$this->id_user' AND sem='N'";
		  $baza->pytanie($this->query);
		  
		  $this->nkl = $baza->tab[0];
		  
		  if($this->nkl == 0 )
		  {
			$this->query = "SELECT nazwisko,imie FROM users WHERE id='$this->id_user'";
			$baza->pytanie($this->query);
			
			$this->nazwisko = $baza->tab[0];
			$this->imie = $baza->tab[1];
			
			$this->query = "SELECT klasa,sb FROM vklasy WHERE id_kl='$this->id_kl'";
			$baza->pytanie($this->query);
			
			$this->klasa = $baza->tab[0];
			$this->sb = $baza->tab[1];
			
			$query = "SELECT avg(sem) FROM $sem WHERE id_user='$this->id_user'";
			$baza->pytanie($query);
			
			$this->sr = $baza->tab[0];
			$this->sr = number_format($this->sr, 2, '.', '');
			
			if($this->zm == 2)
			{
			  if($this->sr < $this->zm)
			  $this->tab_beznkl[] = $this->sr.'; '.$this->klasa.'; '.$this->sb.'; '.$this->nazwisko.'; '.$this->imie;
			} else {
			  if($this->sr > $this->zm)
			  $this->tab_beznkl[] = $this->sr.'; '.$this->klasa.'; '.$this->sb.'; '.$this->nazwisko.'; '.$this->imie;		
			}
			
		  }
		}
	  }
	}
	
	if(isset($this->tab_beznkl))
	{
	  $this->tab_beznkl = array_unique($this->tab_beznkl);
	  rsort($this->tab_beznkl);
	  return $this->tab_beznkl;
	}
  }	
}
?>