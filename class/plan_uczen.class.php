<?php
class planUcznia
{
  private $result;

  //Funkcja - plan
  function plan($gr)
  {
	global $ile;
	global $mysqli;
	global $id_kl;
	$pln='';
	if($result = $mysqli->query("SELECT id_pl, dzien, nr_godz, id_przed, gr FROM plan_zajec WHERE id_kl='$id_kl' AND gr='$gr'"))
	{
	  if($result->num_rows > 0)
	  {
		while($row=$result->fetch_object())
		{
		  $pln[0][] = $row->id_pl;
		  $pln[1][] = $row->dzien;
		  $pln[2][] = $row->nr_godz;
		  $pln[3][] = $row->id_przed;
		  $pln[4][] = $row->gr;
		  $ile++;
		}
	  }
	}
	return $pln;
  }
}
?>