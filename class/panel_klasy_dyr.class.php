<?php
class klasyPanel
{
  private $result;
  private $result2;

  //Funkcja - Panel_klasy
  function klasy_panel()
  {
   global $id;
   global $mysqli;
   
	if($this->result = $mysqli->query("SELECT id_kp FROM klasy_nauczyciele"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($row=$this->result->fetch_object())
		{
		  $id_kp = $row->id_kp;
		   
		 if($this->result2 = $mysqli->query("SELECT id_kl FROM klasy_przedmioty WHERE id_kp='$id_kp'"))
		  {
			if($this->result2->num_rows > 0)
			{
			  while($row2=$this->result2->fetch_object())
			  {
				$id_kl = $row2->id_kl;
				$tab_kl[] = $row2->id_kl;
				
				$kl = "SELECT klasa, sb FROM vklasy WHERE id_kl='$id_kl'";
			   
				 if(!$zapytanie = $mysqli->query($kl)){
					echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
					$mysqli->close();
				 }
			   
				  $wynik = $zapytanie->fetch_row();
				  $klasa = $wynik[0];	
				  $sb = $wynik[1];
  
				  $tab[] = $klasa .';'. $sb. ';'.$id_kl;
			  }
			}
		  }
		}
		
		sort($tab);
  
		$tab_n = array_unique($tab);
		$tab_n = array_values($tab_n);
		
		$ile = count($tab_n);
		
		for($i=0; $i < $ile; $i++)
		{
			$tab_dz = explode(';', $tab_n[$i]);
			if($i ==0)
			{
			  echo' <li><a href="#" title="klasa" class="zakladki aktywna" id="'.$tab_dz[2].'&id='.$id.'">' .$tab_dz[0]. ' '.$tab_dz[1].'</a></li>';
			} else {
			  echo' <li><a href="#" title="klasa" class="zakladki" id="'.$tab_dz[2].'&id='.$id.'">' .$tab_dz[0]. ' '.$tab_dz[1].'</a></li>';
			}
	  
		}
	  }
	}
  }
}
?>