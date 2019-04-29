<?php
class ocenyUczniowie
{
  private $id_us='';
  private $prop=''; 
  private $sem='';
  private $result;
  private $result2;
  private $result3;
  private $result4;
  private $row;
  private $row2;
  private $row3;
  private $row4;

//Funkcja - Uczniowie
  function uczniowie($id_kl,$ile,$oceny,$mysqli,$nr,$id_zaj,$aktywny)
  {
	if($this->result = $mysqli->query("SELECT id_user FROM uczen WHERE id_kl='$id_kl'"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($this->row=$this->result->fetch_object())
		{
		  $id_user = $this->row->id_user;
		  
		  if($this->result2 = $mysqli->query("SELECT nazwisko, imie FROM users WHERE id='$id_user'"))
		  {
			if($this->result2->num_rows > 0)
			{
			  while($this->row2=$this->result2->fetch_object())
			  {
				$nazwisko = $this->row2->nazwisko;
				
				// Polskie znaki - zmiana
				$search = array('Ś','Ł','Ź');
				$replace = array('Szz','Lzz','Nzz');
				$nazwisko = str_replace($search, $replace,$nazwisko);
				
				$imie = $this->row2->imie;
				
				$uczniowie[] = $nazwisko.'; '.$imie.'; '.$id_user;
			  }
			}else {
			  echo 'Brak rekordów';
			}
		  }
		}
	  }
	}
  
  //Sortowanie wyników
  if(isset($uczniowie))
  {
	sort($uczniowie);
	
	  foreach($uczniowie as $uczen)
	  {
		$uczen = explode('; ', $uczen);
		$nr++;
		
		// Polskie znaki - zmiana
		$search = array('Szz','Lzz','Nzz');
		$replace = array('Ś','Ł','Ź');
		$uczen[0] = str_replace($search, $replace, $uczen[0]);
		
		$nazwisko = $uczen[0];
		$imie = $uczen[1];
		$id_user = $uczen[2];
	  
		  if ($nr == 6 || $nr == 11 || $nr == 16 || $nr == 21 || $nr == 26 || $nr == 31)
		  {
			//Identyfikator ucznia
			echo '<tr><td class="nr'.$nr.'" id="'.$id_user.'">'.$nr.'</td><td class="ucz-traf">'.$nazwisko.' '.$imie.'</td>';
			//Formularz - id_user
			echo '<input type="hidden" name="id_user-'.$nr.'" value="'.$id_user.'">';
			
			//Pola ocen cząstkowych
			  for($i=0; $i<25 ; $i++)
			  {
				$ocena = $id_user.'-'.$i;
				//Formularz - pozycja oceny
				echo '<input type="hidden" name="poz-'.$nr.'-'.$i.'" value="'.$ocena.'">';
				echo '<td class="traf">';	
				
			  //Ocena
			  echo '<input class="for-oc" type="text" name="ocena-'.$nr.'-'.$i.'" id="'.$ocena.'" maxlength="2"';
			  
				for($j=0; $j < $ile; $j++)
				{
				  $oceny_dz = explode(';', $oceny[$j]);
				  $poz = $oceny_dz[0];
				  $oc = $oceny_dz[1];
				  $data = $oceny_dz[2];
				  $this->id_us = $oceny_dz[3];
				  
				  if($id_user.'-'.$i == $poz)
				  {
					echo 'value="'.$oc.'"';
				  }
				}
				 if($aktywny==0)
				 {
					 echo 'disabled>';
				 } else {
					 echo '>';
				 }
				echo '</td>';
			  }
			
			  //Propozycje semestralne
			  if($this->result3 = $mysqli->query("SELECT prop FROM ocen_prop_sem WHERE id_kl='$id_kl' AND id_user='$id_user' AND poz='$nr' AND id_przed='$id_zaj'"))
			  {
				if($this->result3->num_rows == 1)
				{
				  while($this->row3=$this->result3->fetch_object())
				  {
					$this->prop = $this->row3->prop;
				  }
				} else {
				  $this->prop='';
				}
			  }	
			
			  //Oceny semestralne
			  if($this->result4 = $mysqli->query("SELECT sem FROM ocen_sem WHERE id_kl='$id_kl' AND id_user='$id_user' AND poz='$nr' AND id_przed='$id_zaj'"))
			  {
				if($this->result4->num_rows == 1)
				{
				  while($this->row4=$this->result4->fetch_object())
				  {
					$this->sem = $this->row4->sem;
				  }
				} else {
				  $this->sem='';
				}
			  }	
			
				if($aktywny==0)
				 {
					echo '<td class="srw-traf"><div id="sr'.$nr.'"></div></td>';
					echo '<td class="prop-traf"><input class="for-oc-bra" type="text" name="prop_'.$nr.'" id="" maxlength="1" value="'.$this->prop.'" disabled></td>';
					echo '<td class="kon-traf"><input class="for-oc-bra" type="text" name="sem_'.$nr.'" id="" maxlength="1" value="'.$this->sem.'" disabled></td></tr>';
				 } else {
					echo '<td class="srw-traf"><div id="sr'.$nr.'"></div></td>';
					echo '<td class="prop-traf"><input class="for-oc-bra" type="text" name="prop_'.$nr.'" id="" maxlength="1" value="'.$this->prop.'"></td>';
					echo '<td class="kon-traf"><input class="for-oc-bra" type="text" name="sem_'.$nr.'" id="" maxlength="1" value="'.$this->sem.'"></td></tr>';
				 }		  
		  
		  } else {

			//Identyfikator ucznia
			echo '<tr><td class="nr'.$nr.'" id="'.$id_user.'">'.$nr.'</td><td class="ucz">'.$nazwisko.' '.$imie.'</td>';
			//Formularz - id_user
			echo '<input type="hidden" name="id_user-'.$nr.'" value="'.$id_user.'">';
			
			//Pola ocen cząstkowych
			  for($i=0; $i<25 ; $i++)
			  {
				$ocena = $id_user.'-'.$i;
				//Formularz - pozycja oceny
				echo '<input type="hidden" name="poz-'.$nr.'-'.$i.'" value="'.$ocena.'">';
				echo '<td>';		
				
			  //Ocena
			  echo '<input class="for-oc" type="text" name="ocena-'.$nr.'-'.$i.'" id="'.$ocena.'" maxlength="2"';
			  
				for($j=0; $j < $ile; $j++)
				{
				  $oceny_dz = explode(';', $oceny[$j]);
				  $poz = $oceny_dz[0];
				  $oc = $oceny_dz[1];
				  $data = $oceny_dz[2];
				  $this->id_us = $oceny_dz[3];
				  
				  if($id_user.'-'.$i == $poz)
				  {
					echo 'value="'.$oc.'"';
				  }
				}
			  
				 if($aktywny==0)
				 {
					 echo 'disabled>';
				 } else {
					 echo '>';
				 }
				echo '</td>';
			  }
			
			  //Propozycje semestralne
			  if($this->result3 = $mysqli->query("SELECT prop FROM ocen_prop_sem WHERE id_kl='$id_kl' AND id_user='$id_user' AND poz='$nr' AND id_przed='$id_zaj'"))
			  {
				if($this->result3->num_rows == 1)
				{
				  while($this->row3=$this->result3->fetch_object())
				  {
					$this->prop = $this->row3->prop;
				  }
				} else {
				  $this->prop='';
				}
			  }	
			
			  //Oceny semestralne
			  if($this->result4 = $mysqli->query("SELECT sem FROM ocen_sem WHERE id_kl='$id_kl' AND id_user='$id_user' AND poz='$nr' AND id_przed='$id_zaj'"))
			  {
				if($this->result4->num_rows == 1)
				{
				  while($this->row4=$this->result4->fetch_object())
				  {
					$this->sem = $this->row4->sem;
				  }
				} else {
				  $this->sem='';
				}
			  }	
			  
				if($aktywny==0)
				 {
					echo '<td class="srw"><div id="sr'.$nr.'"></div></td>';
					echo '<td class="sem"><input class="for-oc-bra" type="text" name="prop_'.$nr.'" id="" maxlength="1" value="'.$this->prop.'" disabled></td>';
					echo '<td class="kon"><input class="for-oc-bra" type="text" name="sem_'.$nr.'" id="" maxlength="1" value="'.$this->sem.'" disabled></td></tr>';
				 } else {
					echo '<td class="srw"><div id="sr'.$nr.'"></div></td>';
					echo '<td class="sem"><input class="for-oc-bra" type="text" name="prop_'.$nr.'" id="" maxlength="1" value="'.$this->prop.'"></td>';
					echo '<td class="kon"><input class="for-oc-bra" type="text" name="sem_'.$nr.'" id="" maxlength="1" value="'.$this->sem.'"></td></tr>';
				 }				  
			  
		  }
	  
		}
					  		
	  }
  
	//Formularz - ilość uczniów w klasie
	echo '<input type="hidden" name="l_ucz" value="'.$nr.'">';	
	?>
	<script type="text/javascript">nr = "<?=$nr;?>";</script>
	<?php
  }	
}
?>