<?php
class tematEdycja
{
  private $result;
  private $row;

  //Funkcja - Temat
  function temat($id_tem,$mysqli)
  {
	if($result = $mysqli->query("SELECT temat FROM rozklad_realiz WHERE id_tem='$id_tem'"))
	{
	  if($result->num_rows > 0)
	  {
		while($row=$result->fetch_object())
		{
		  $tem = $row->temat;
		}
	  }
	}
  return $tem;
  }
}
?>