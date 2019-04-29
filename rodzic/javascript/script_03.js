$(document).ready(function()
{

$("#user1").load("poczta_nap.php");
$("#user2").load("poczta_pok.php");

//Aktualizacja zakładek
  $("a.zaj").click(function()
  {
	  $(".aktywna").removeClass("aktywna");
	  $(this).addClass("aktywna");
	  $(".zawartosc").hide();
	  var widok = $(this).attr("title");
	  $("#"+widok).show();
  });

//Wybór przedmiotu
  $(".min-7").click(function()
  {
	 id_st = $(this).val();
	 if(id_st != "x")
	 {
	  var adr = "poczta_wyb.php?id_st=";
	  adr += id_st;
	  
	  $.get(adr,function(data)
	  {
		$("#view").show();
		$("#zestaw").html(data);
		$("#zestaw").show();
	  });
	 } else {
	  $("#view").hide();
	  $("#zestaw").hide(); 
	 }
  });

//Zapisanie listu
  $("#zapisz-list").click(function(event)
  {
	  var dane = $("#form").serialize();
	  var adr = $("#form").attr("action");
	  
	  $.post(adr, dane, function(data)
	  {
		$("#user1").html(data);
		$("#tytul").val("");
		$("#tresc").val("");
		$("#user").load("poczta_nap.php");
	  });
	  event.stopImmediatePropagation();
  });
//Odpowiedź na list
  $("#odp-list").click(function(event)
  {
	  var dane = $("#form").serialize();
	  var adr = $("#form").attr("action");
	  var link = "poczta.php";
	  
	  $.post(adr, dane, function(data)
	  {
		$("#user1").html(data);
		$("#tytul").val("");
		$("#tresc").val("");
		$(location).attr('href',link);
	  });
	  event.stopImmediatePropagation();
  });
});