<?php
class konto
{
  //Zmienne
  private $log;
  private $ile;
  private $el;
  private $data;
  private $godz;
  private $nazwisko;
  private $imie;
  private $poczta;
  private $status;
  private $result;

  //Funkcja - Logowania
  public function list_log($id)
  {
	global $mysqli;
	if($this->result = $mysqli->query("SELECT data, godz FROM logowania WHERE id_user='$id' ORDER BY id_log"))
	{
	  if($this->result->num_rows > 0)
	  {
		while($row=$this->result->fetch_object())
		{
		  $this->data = $row->data;
		  $this->godz = $row->godz;
	  
		  $this->log[] = $this->data.', godz.: '.$this->godz;
		}
	  }
	}
  return $this->log;
  }

  //Funkcja - Ostatnie logowanie
  public function ost_log($id)
  {
	$this->lista = $this->list_log($id);
	$this->ile = count($this->lista);
	
	if($this->ile > 1)
	{
	  $this->el = count($this->lista)-2;
	} else {
	  $this->el = count($this->lista)-1;	  
	}
	
	if(isset($this->lista[$this->el])) return $this->lista[$this->el];
  }

  //Funkcja - Ilość logowań
  public function ile_log($id)
  {
	global $mysqli;
	
	if($this->result = $mysqli->query("SELECT COUNT(data) AS ile FROM logowania WHERE id_user='$id'"))
	{
	  $row = mysqli_fetch_object($this->result);
	  $this->ile = $row->ile;
	}
	return $this->ile;
  }

  //Funkcja - Interfejs użytkownika
  public function interfejsUsera($kto,$id)
  {
  global $mysqli;
  
	if($this->result = $mysqli->query("SELECT * FROM users WHERE login='$kto'"))
	{
	  if($this->result->num_rows > 0)
	  {
		echo'<table id="center-tabela-szkola">';
		
		while($row=$this->result->fetch_object())
		{
			$this->nazwisko = $row->nazwisko;
			$this->imie = $row->imie;
			$this->poczta = $row->email;
			$this->status = $_SESSION['kto'];
			$this->ost_log = $this->ost_log($id);
			$this->ile_log = $this->ile_log($id);
			
			echo'<tr><td class="prawy">NAZWISKO:</td><td class="lewy">'.$this->nazwisko.'</td></tr>';
			echo'<tr><td class="prawy">IMIĘ:</td><td class="lewy">'.$this->imie.'</td></tr>';
			echo'<tr><td class="prawy">POCZTA:</td><td class="lewy">'.$this->poczta.'</td></tr>';		
			echo'<tr><td class="prawy">STATUS:</td><td class="lewy">'.$this->status.'</td></tr>';
			echo'<tr><td class="prawy">OSTATNIE LOGOWANIE:</td><td class="lewy">'.$this->ost_log.'</td></tr>';
			echo'<tr><td class="prawy">ILOŚĆ LOGOWAŃ:</td><td class="lewy">'.$this->ile_log.'</td></tr>';
		}
		
		echo'</table>';
	  }else {
		echo 'Brak rekordów';
	  }
	} else {
	echo 'Błąd: ' . $mysqli->error;
	}
  }

}
?>