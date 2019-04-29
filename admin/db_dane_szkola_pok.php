<?php
include_once('status.php');

//Nawiązanie połączenia serwerem MySQL.
include_once('db_connect.php');

//Sprawdzenie połączenia z serwerem MySQL.
if($mysqli->connect_errno){
   echo 'Wystąpił błąd podczas próby połączenia z serwerem MySQL';
   echo $mysqli->connect_error;
}

if($result = $mysqli->query("SELECT * FROM dane_szkoly"))
{

  //Sprawdzenie, czy rekordów jest więcej niż 0
  if($result->num_rows > 0)
  {
	  echo'<table id="center-tabela-szkola">';
				  
	  //Tworzenie wierszy
	  while($row=$result->fetch_object())
	  {
		  echo'<tr><td class="prawy">NAZWA SZKOŁY:</td><td class="lewy">'. $row->opis .'</td></tr>';
		  echo'<tr><td class="prawy">ADRES:</td><td class="lewy">'. $row->ulica .', '. $row->kod .' '. $row->miasto .'</td></tr>';
		  echo'<tr><td class="prawy">TELEFON:</td><td class="lewy">'. $row->telefon .'</td></tr>';
		  echo'<tr><td class="prawy">POCZTA:</td><td class="lewy">'. $row->email .'</td></tr>';		
		  echo'<tr><td class="prawy">NIP:</td><td class="lewy">'. $row->nip .'</td></tr>';
		  echo'<tr><td class="prawy">REGON:</td><td class="lewy">'. $row->regon .'</td></tr>';
	  }
	  echo'</table>';
	  echo'<div id="informacje">';
	  echo'<p>* - w tym polu dane są obowiązkowe</p>';
	  echo'</div>';
	  
  }else {
  echo 'Brak rekordów';
  }
}else {
echo 'Błąd: ' . $mysqli->error;
}
?>