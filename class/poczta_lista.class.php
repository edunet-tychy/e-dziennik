<?php
class pocztaUczenRodzic
{
  private $result;
  private $result2;

  //Funkcja - Uczeń_Rodzic
  function uczen_rodzic($id)
  {
	 global $mysqli;
	 
	  if($this->result = $mysqli->query("SELECT id_kp FROM klasy_nauczyciele WHERE id_naucz='$id'"))
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
				 
				  $kl = "SELECT klasa, sb FROM vklasy WHERE id_kl='$id_kl'";
				 
				   if(!$zapytanie = $mysqli->query($kl)){
					  echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
					  $mysqli->close();
				   }
				 
					$wynik = $zapytanie->fetch_row();
					$klasa = $wynik[0];	
					$sb = $wynik[1];
					
					$tab[] = $klasa .' '. $sb . ' ' . $id_kl;
				}
			  }
			}
		  }
		  
		  sort($tab);
		  $tab_n = array_unique($tab);
		  $ile = count($tab);
		  
		  for($i=0; $i < $ile; $i++)
		  {
			  if(isset($tab_n[$i]))
			  {
				$tab_menu = explode(' ', $tab_n[$i]);
				echo'<option value="R'.$tab_menu[2].'">'.$tab_menu[0].' '.$tab_menu[1].' - Rodzice</option>';
				echo'<option value="U'.$tab_menu[2].'">'.$tab_menu[0].' '.$tab_menu[1].' - Uczniowie</option>';
			  }
		  }
		}
	  }
	}
}
?>