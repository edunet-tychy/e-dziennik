$(document).ready(function()
{
//wyświetlanie danych
	var url = "db_przedmiot_pok.php";
	$("#pokazPrzedmioty").load(url);
	$("#klasaEdycja").prop('disabled', true);
	$("#zawodEdycja").prop('disabled', true);

//Dodanie przedmiotu	
	$("#dodajPrzedmiot").click(function()
	{
		var dane = $("form").serialize();
		var url2 = $("form").attr("action");
		
		if(($("#przedmiot").val() == "") || ($("#skrot").val() == ""))
		{
		  alert("Uzupełnij wymagane pola!");
		}else{
		  $.post(url2, dane, function()
		  {
			  $("#pokazPrzedmioty").load(url);
		  });	
		}
		
		//Czyszczenie pól formularz
		$("#przedmiot").val("");
		$("#skrot").val("");
	});

//Poprawa przedmiotu
	$("#poprawPrzedmiot").click(function()
	{
		var dane = $("form").serialize();
		var url3 = $("form").attr("action");
		var adr = "db_przedmioty.php";
		
		if(($("#przedEdycja").val() == "") || ($("#skrotEdycja").val() == ""))
		{
		  alert("Uzupełnij wymagane pola!");
		}else{
		  $.post(url3, dane, function()
		  {
			  $(location).attr('href',adr);
		  });
		}	
	});

//Dodanie szkoły	
	$("#dodajSzkole").click(function()
	{
		var pole1 = $("#nazwaSzkoly").val();
		var pole2 = $("#symbolSzkoly").val();
		var pole3 = $("#typSzkoly").val();

		if(pole1 == '' || pole2 == '' || pole3 == 'x')
		{
		  alert("Uzupełnij wszystkie pola!");
		} else {
		  var dane_sz = $("form").serialize();
		  var url4 = $("form").attr("action");
		  var url5 = "db_szkola_pok.php";
		  $.post(url4, dane_sz, function()
		  {
			  $("#pokazSzkola").load(url5);
		  });
		  
		  //Czyszczenie pól formularz
		  $("#nazwaSzkoly").val("");
		  $("#symbolSzkoly").val("");
		}

	});

//Poprawa szkoła
	$("#poprawSzkola").click(function()
	{
		var dane_psz = $("form").serialize();
		var url6 = $("form").attr("action");
		var adr = "db_szkoly.php";
		$.post(url6, dane_psz, function()
		{
			$(location).attr('href',adr);
		});
		
		//Czyszczenie pól formularz
		$("#nazwaSzkoly").val("");
		$("#symbolSzkoly").val("");	
	});

//Dodanie klasy	
	$("#dodajKlase").click(function()
	{
		var dane_kl = $("form").serialize();
		var url8 = $("form").attr("action");
		var id_sz = $("#id_sz").val();
		var url9 = "db_klasa_pok.php?id_sz=" + id_sz;
		
		if(($("#nauczyciele").val() == "xx") || ($("#zawod").val() == "x") || ($("#klasa").val() == ""))
		{
		  alert("Wypełnij wszystkie wymagane pola!");
		} else {
		  $.post(url8, dane_kl, function()
		  {
			  $("#pokazKlas").load(url9);
			  //Czyszczenie pól formularz
			  $("#klasa").val("");
		  });  			
		}
	});
	
//Poprawa klasy
	$("#poprawKlasa").click(function()
	{
		var dane_pk = $("form").serialize();
		var url10 = $("form").attr("action");
		var id_sz = $("#id_sz").val();
		var link = "db_klasa.php?id_sz=" + id_sz;
		$.post(url10, dane_pk, function()
		{
			$(location).attr('href',link);
		});
	});

//Dodaj dane zespołu szkół
	$("#dodajDaneSzkola").click(function()
	{
		var pole1 = $("#pelnaNazwaSzkolyEdycja").val();
		var pole2 = $("#ulicaSzkolyEdycja").val();
		var pole3 = $("#kodSzkolyEdycja").val();
		var pole4 = $("#miastoSzkolyEdycja").val();
		var pole5 = $("#telefonSzkolyEdycja").val();
		var pole6 = $("#emailSzkolyEdycja").val();
		var pole7 = $("#nipSzkolyEdycja").val();
		var pole8 = $("#regonSzkolyEdycja").val();
		
		if(pole1 == '' || pole2 == '' || pole3 == '' || pole4 == '' || pole5 == '' || pole6 == '' || pole7 == '' || pole8 == '')
		{
			alert("Wszystkie pola muszą być uzupełnione!");
		} else {
		  
		  var dane_sz = $("form").serialize();
		  var url_sz = $("form").attr("action");
		  var adr = "db_dane_szkola.php";
		  
		  $.post(url_sz, dane_sz, function()
		  {
			$(location).attr('href',adr);
		  });
		}
	});

//Poprawa danych szkoły
	$("#poprawDaneSzkola").click(function()
	{
		var pole1 = $("#pelnaNazwaSzkolyEdycja").val();
		var pole2 = $("#ulicaSzkolyEdycja").val();
		var pole3 = $("#kodSzkolyEdycja").val();
		var pole4 = $("#miastoSzkolyEdycja").val();
		var pole5 = $("#telefonSzkolyEdycja").val();
		var pole6 = $("#emailSzkolyEdycja").val();
		var pole7 = $("#nipSzkolyEdycja").val();
		var pole8 = $("#regonSzkolyEdycja").val();
		
		if(pole1 == '' || pole2 == '' || pole3 == '' || pole4 == '' || pole5 == '' || pole6 == '' || pole7 == '' || pole8 == '')
		{
			alert("Wszystkie pola muszą być uzupełnione!");
		} else {
		  var dane_pdsz = $("form").serialize();
		  var url12 = $("form").attr("action");
		  var url13 = "db_dane_szkola_pok.php";
		  $.post(url12, dane_pdsz, function()
		  {
			$("#pokazDaneSzkola").load(url13);
			$("#poprawDaneSzkola").attr('disabled','disabled');
			$("#informacjaEdycja").html('<p class="kontrola-center">Dane zostały wprowadzone!</p>');
			setTimeout(function () {$("#informacjaEdycja").html('<p class="kontrola-center"></p>'); $("#poprawDaneSzkola").removeAttr('disabled')}, 1000);
		  });
			
		}
	});

//Czyszczenie pola - dane szkoły
	$("#pelnaNazwaSzkolyEdycja").focus(function(){$("#informacjaEdycja").html('');});
	$("#ulicaSzkolyEdycja").focus(function(){$("#informacjaEdycja").html('');});
	$("#kodSzkolyEdycja").focus(function(){$("#informacjaEdycja").html('');});
	$("#miastoSzkolyEdycja").focus(function(){$("#informacjaEdycja").html('');});
	$("#telefonSzkolyEdycja").focus(function(){$("#informacjaEdycja").html('');});
	$("#emailSzkolyEdycja").focus(function(){$("#informacjaEdycja").html('');});
	$("#nipSzkolyEdycja").focus(function(){$("#informacjaEdycja").html('');});
	$("#regonSzkolyEdycja").focus(function(){$("#informacjaEdycja").html('');});
	
//Poprawa danych - dzwonki
	$("#poprawDzwonki").click(function()
	{
		var dane_pddz = $("form").serialize();
		var url14 = $("form").attr("action");
		var url15 = "db_dzwonki.php";
		
		$("#poprawDzwonki").attr('disabled','disabled');
		$.post(url14, dane_pddz, function()
		{	
			$("#konWpis").html('<p class="kontrola-center">Zmiany zostały wprowadzone!</p>');
			setTimeout(function () {$("#konWpis").html('<p class="kontrola-center"></p>'); $("#poprawDzwonki").removeAttr('disabled')}, 1000);
		});
	})

//Poprawa danych - Organizacja Roku Szkolnego
	$("#poprawOrgRok").click(function()
	{
		var dane_org = $("form").serialize();
		var url16 = $("form").attr("action");
		var adr = "db_org_roku.php";
		$.post(url16, dane_org, function()
		{
		  $("#poprawOrgRok").attr('disabled','disabled');
		  $("#konWpis").html('<p class="kontrola-center">Zmiany zostały wprowadzone!</p>');
		  setTimeout(function () {$("#konWpis").html('<p class="kontrola-center"></p>'); $("#poprawOrgRok").removeAttr('disabled'); $(location).attr('href',adr);}, 1000);
		});
	})

//Dodanie wydarzenia do kalendarza	
	$("#dodajWydarzenieKal").click(function()
	{
		var dane_wk = $("form").serialize();
		var url18 = $("form").attr("action");
		var url19 = "db_kalendarz_pok.php";
		$.post(url18, dane_wk, function()
		{
			$("#pokazKalendarz").load(url19);
		});
		
		//Czyszczenie pól formularz
		$("#odKal").val("");
		$("#doKal").val("");
		$("#wydarzenieKal").val("");
	});

//Poprawa wydarzenia w kalendarzu
	$("#poprawWydarzenieKal").click(function()
	{
		var dane_pwsz = $("form").serialize();
		var url20 = $("form").attr("action");
		var url25 = "db_kalendarz.php";
		$.post(url20, dane_pwsz, function()
		{
			$(location).attr('href',url25);
		});
		
		//Czyszczenie pól formularz
		$("#odKal").val("");
		$("#doKal").val("");
		$("#wydarzenieKal").val("");
		
	});

//Dodanie News'a	
	$("#dodajNews").click(function()
	{
		var dane_wk = $("form").serialize();
		var url18 = $("form").attr("action");
		var url19 = "db_news_pok.php";
		$.post(url18, dane_wk, function()
		{
			$("#pokazNews").load(url19);
		});
		
		//Czyszczenie pól formularz
		$("#news").val("");
		$("#wydarzenieNews").val("");
		$("#odbiorca").val("");
	});

//Poprawa News'a
	$("#poprawNews").click(function()
	{
		var dane_pwsz = $("form").serialize();
		var url20 = $("form").attr("action");
		var adr = "db_news.php";
		$.post(url20, dane_pwsz, function()
		{
			$(location).attr('href',adr);
		});
	});
});

