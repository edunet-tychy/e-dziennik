$(document).ready(function()
{
//Dodanie przedmiotu	
  $("#dodajZawod").click(function()
  {
	var pole_1 = $("#nazwaZawodu").val();
	var pole_2 = $("#symbolZawodu").val();
	var pole_3 = $("#skrotZawodu").val();
	
	if(pole_1 != '' && pole_2 != '' && pole_3 != '')
	{
	  var dane = $("form").serialize();
	  var url = $("form").attr("action");
	  var adr = "db_zawod_pok.php";
	  
	  $.post(url, dane, function()
	  {
		$("#pokazZawod").load(adr);
	  });
	  
	  //Czyszczenie pól formularz
		$("#nazwaZawodu").val("");
		$("#symbolZawodu").val("");
		$("#skrotZawodu").val("");	
	} else {
		alert("Uzupełnij wszystkie pola!");
	}

  });

//Poprawa zawodu
	$("#poprawZawod").click(function()
	{
	  var pole_1 = $("#nazwaZawoduEdycja").val();
	  var pole_2 = $("#symbolZawoduEdycja").val();
	  var pole_3 = $("#skrotZawoduEdycja").val();
	  
	  if(pole_1 != '' && pole_2 != '' && pole_3 != '')
	  {
		var dane = $("form").serialize();
		var url = $("form").attr("action");
		var adr = "db_zawod.php";
		
		$.post(url, dane, function()
		{
		  $(location).attr('href',adr);
		});
		
		//Czyszczenie pól formularz
		$("#nazwaZawoduEdycja").val("");
		$("#symbolZawoduEdycja").val("");
		$("#skrotZawoduEdycja").val("");		
	  } else {
		 alert("Uzupełnij wszystkie pola!");
	  }	
	});
});