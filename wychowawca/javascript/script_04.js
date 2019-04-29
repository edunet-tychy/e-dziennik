$(document).ready(function()
{
//Zakładki
	$("a.zakladki").click(function()
	{
		$(".aktywna").removeClass("aktywna");
		$(this).addClass("aktywna");
		var otwartaZakladka = $(this).attr("title");
		$("#"+otwartaZakladka).show();
	});

//Zapisanie zmian  - zachowanie	
	$("#zapiszZachowanie1").click(function()
	{
		var dane = $("form").serialize();
		var url = $("form").attr("action");
		var adr = 'db_zachowanie_sem.php';
		
		$.post(url, dane, function()
		{
		  $(location).attr('href',adr);
		});
		
	var data= "Dane są zapisywane! <img src='image/ajax-loader.gif' id='loader'>";
	$("#zapis-2").html(data);
	$("#zapiszZachowanie1").attr('disabled','disabled');

	});

//Zapisanie zmian  - zachowanie	
	$("#zapiszZachowanie2").click(function()
	{
		var dane = $("form").serialize();
		var url = $("form").attr("action");
		var adr = 'db_zachowanie_kon.php';
		
		$.post(url, dane, function()
		{
		  $(location).attr('href',adr);
		});

	var data= "Dane są zapisywane! <img src='image/ajax-loader.gif' id='loader'>";
	$("#zapis-2").html(data);
	$("#zapiszZachowanie2").attr('disabled','disabled');

	});

});