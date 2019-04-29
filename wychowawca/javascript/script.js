$(document).ready(function()
{
//Zakładki
	$("a.zakladki").click(function()
	{
		$(".aktywna").removeClass("aktywna");
		$(this).addClass("aktywna");
		$(".zawartosc").hide();
		var otwartaZakladka = $(this).attr("title");
		$("#"+otwartaZakladka).show();
	});

//Domyślne nazwisko dla rodziców
  $("#nazwisko").blur(function()
  {
	var nazwiskoRodzica = $("#nazwisko").val();
	$("#nazwiskoR").attr("value", nazwiskoRodzica);
  });
 
//Sprawdzenie, czy podane imię jest żeńskie
 $("#imie").blur(function()
 {
	var nazwa = $("#imie").val();
	var ostZnak = nazwa.slice(-1);
	
	if(ostZnak == 'a')
	{
	  $("#plec option[value=k]").attr("selected", "selected");
	} else {
	  $("#plec option[value=m]").attr("selected", "selected");
	}
 });

//Generowanie loginu
	$("#genHas").click(function()
	{
  		var passwd = '';
  		var chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@';
  		for (i=0;i<=8;i++)
		{
    	 var c = Math.floor(Math.random()*chars.length + 1);
    	 passwd += chars.charAt(c)
		}
		$("#passwd").val(passwd);
		$("#passwdPow").val(passwd);
		alert(passwd);
	});

//Generowanie hasła
	$("#genLog").click(function()
	{
  		var logon = '';
  		var chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  		for (i=0;i<=8;i++)
		{
    	 var c = Math.floor(Math.random()*chars.length + 1);
    	 logon += chars.charAt(c)
		}
		$("#login").val(logon);
	});

//Dodanie ucznia do klasy	
	$("#dodajUcznia").click(function()
	{

	  if(($("#nazwisko").val()=='') || ($("#imie").val()=='') || ($("#login").val()=='') || ($("#passwd").val()=='') || ($("#passwdPow").val()=='') || ($("#nrEwiden").val()=='') || ($("#dataUrodz").val()=='') || ($("#miejsceUrodz").val()=='') || ($("#imieMatki").val()=='') || ($("#imieOjca").val()=='') || ($("#ulica").val()=='') || ($("#miasto").val()=='') || ($("#lokal").val()=='') || ($("#woj").val()=='') || ($("#kod").val()=='') || ($("#lokal").val()=='') || ($("#telefon").val()==''))
	  {
		alert("Uzupełnij wszystkie pola oznaczone gwiazdką");
	  } else {
		var dane = $("form").serialize();
		var url1 = $("form").attr("action");
		$.post(url1, dane, function()
		{
		  var adr='db_uczen.php';
		  $(location).attr('href',adr);
		});		
	  }

	});

//Poprawa danych ucznia
	$("#poprawDaneUcznia").click(function()
	{
		var dane2 = $("form").serialize();
		var url2 = $("form").attr("action");
		var url3 = 'db_uczen_dane.php?id=';
		var id = $("#id").val();
		url3 += id;
		$.post(url2, dane2, function()
		{  
			$(location).attr('href',url3);
		});
	});

function clear()
{
		$("#nazwisko").val("");
		$("#imie").val("");
		$("#email").val("");
		$("#login").val("");
		$("#passwd").val("");
		$("#passwdPow").val("");
		$("#nrEwiden").val("");
		$("#pesel").val("");
		$("#dataUrodz").val("");
		$("#miejsceUrodz").val("");
		$("#imieMatki").val("");
		$("#imieOjca").val("");
		$("#nazwiskoOjca").val("");
		$("#ulica").val("");
		$("#miasto").val("");
		$("#lokal").val("");
		$("#woj").val("");
		$("#kod").val("");
		$("#lokal").val("");
		$("#emailRodzic").val("");
		$("#telefon").val("");	
};

//Dodanie przedmiotu do klasy	
	$("#dodajPrzedmiot").click(function()
	{
		var dane4 = $("form").serialize();
		var url4 = $("form").attr("action");
		var url5 = 'db_przedmiot_pok.php';
		$.post(url4, dane4, function()
		{
		  $("#pokazPrzedmioty").load(url5);
		  $("#przedmiot").val("x");
		  $("#nauczyciel1").val("x");
		  $("#nauczyciel2").val("x");
		});

	});

//Poprawa danych przedmiotu
	$("#poprawPrzedmiot").click(function()
	{
		var dane7 = $("form").serialize();
		var url7 = $("form").attr("action");
		var url8 = 'db_przedmioty.php';
		$.post(url7, dane7, function()
		{  
			$(location).attr('href',url8);
		});
	});

//Dodaj samorząd
	$("#dodajSam").click(function()
	{
		var dane9 = $("form").serialize();
		var url9 = $("form").attr("action");
		var url10 = 'db_samorzad.php';
		$.post(url9, dane9, function()
		{  
			$(location).attr('href',url10);
		});
	});

//Poprawa wydarzenia	
	$("#poprawWydarzenie").click(function()
	{
		var dane = $("form").serialize();
		var url = $("form").attr("action");
		var adr = 'db_wydarzenia_dane.php';
		$.post(url, dane, function()
		{
		  $(location).attr('href',adr);
		});

	});
});