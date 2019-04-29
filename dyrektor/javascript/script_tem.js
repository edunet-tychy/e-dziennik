$(document).ready(function()
{
//Aktualizacja zakładek
  $("a.zaj").click(function()
  {
	  $(".aktywna").removeClass("aktywna");
	  $(this).addClass("aktywna");
	  $(".zawartosc").hide();
	  var widok = $(this).attr("title");
	  $("#"+widok).show();
  });

//Aktywowanie pól wyboru
$("#ob").click(function()
{
	$(".opcja1").prop("checked", true);
	$(".opcja2").prop("checked", false);
	$(".opcja3").prop("checked", false);
});

$("#nb").click(function()
{
	$(".opcja1").prop("checked", false);
	$(".opcja2").prop("checked", true);
	$(".opcja3").prop("checked", false);
});

$("#sp").click(function()
{
	$(".opcja1").prop("checked", false);
	$(".opcja2").prop("checked", false);
	$(".opcja3").prop("checked", true);
});

//Wybór przedmiotu
  $(".min-8").click(function()
  {
	 id_przed = $(this).val();
	 if(id_przed != "x")
	 {
	   var adr = "tematy_wyb.php?id_przed=";
	   adr += id_przed;
	   adr += $(".adres").attr("id").valueOf();

	   var url = "tematy_pok.php?";
	   url += $(".adres").attr("id").valueOf() + "&id_przed=" + id_przed;
	   
		$.get(adr,function(data)
		{
		  $("#view").show();
		  $("#zestaw").html(data);
		  $("#user").load(url);
		});
	 }
  });

//Zapisanie obecności
  $("#zapis-ob").click(function(event)
  {
	var dane = $("#form").serialize();
	var adr = $("#form").attr("action");
	
	$.post(adr, dane, function()
	{

	});
	
	$("#zapis-ob").prop("disabled", true);
	event.stopImmediatePropagation();
  });

//Dodanie tematu
  $("#zapis-tem").click(function(event)
  {
	  var dane = $("#tem_zaj").serialize();
	  var adr = $("#tem_zaj").attr("action");
	  var blok = $(".adres").attr("id");
	  adr += blok;
	  
	  var url = "tematy_pok.php?";
	  url += $(".adres").attr("id").valueOf() + "&id_przed=" + id_przed;
	  
	  $.post(adr, dane, function()
	  {
		$("#user").load(url);
	  });
	  event.stopImmediatePropagation();
  });

//Popraw temat
  $("#zmien-tem").click(function(event)
  {
	  var dane = $("#tem_pop").serialize();
	  var adr = $("#tem_pop").attr("action");
	  
	  var url = "tematy.php?";
	  url += $(".adres").attr("id").valueOf() + "&id_przed=" + id_przed;
	  
	  $.post(adr, dane, function()
	  {
		$(location).attr('href',url);
	  });
	  
	  event.stopImmediatePropagation();
  });
  
  $(".min-7").change(function()
  {
	  var godz = $(this).val();
	  $(".min-7a").val(godz);
  });
});