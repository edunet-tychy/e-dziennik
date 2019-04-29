<?php
class post
{
  private $query;
  private $result;
  private $odczyt;
  public $odbiorca;

  //Zapytanie do bazy - Poczta
  public function poczta($id_pocz)
  {
	global $mysqli;
	
	$bazaUs = new users;
	$bazaRola = new statusy;
	
	$this->query = "SELECT * FROM poczta WHERE id_pocz = '$id_pocz'";
  
	if(!$this->result = $mysqli->query($this->query))
	{
	 echo 'Wystąpił błąd: nieprawidłowe zapytanie...';
	 $mysqli->close();
	}
  
	if($this->result->num_rows > 0)
	{
	  
	  echo'<table id="center-tabela-pod-3">';	
	
	  while($row=$this->result->fetch_object())
	  {
		echo'<tr><td class="dane-3"><span class="list">Data: </span></td><td class="dane-3">'. $row->data .'</td></tr>';
		echo'<tr><td class="dane-3"><span class="list">Nadawca: </span></td><td class="dane-3">'. $bazaUs->user($row->nad) .' - '.$bazaRola->status($row->nad).'</td></tr>';
		echo'<tr><td class="dane-3"><span class="list">Tytuł i treść listu:</span></td><td class="dane-3">'. $row->tytul .'</td></tr>';
		echo'<tr><td class="dane-3" colspan="2">'. $row->tresc .'</td></tr>';
		
		$this->odczyt = $row->odczyt;
		
		if($this->odczyt == 1)
		{
		   $this->odczyt = 0;
		  
		  if($stmt = $mysqli->prepare("UPDATE poczta SET odczyt = ? WHERE id_pocz = ?"))
		  {
			$stmt->bind_param("ii",$this->odczyt,$id_pocz);
			$stmt->execute();
			$stmt->close();
		  } else {
			echo "Błąd zapytania";
		  }		  
		}
	  $this->odbiorca = $row->nad.'; '.$bazaUs->user($row->nad).'; '.$row->tytul;
	  }
	  echo'</table>';
	  
	} else {
	  echo '<img src="image/pytanie.png" alt="Brak rekordów">';
	  echo '<p id="baza">BRAK REKORDÓW W BAZIE</p>';
	}
	return $this->odbiorca;
  }	
}
?>