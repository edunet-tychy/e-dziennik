$(document).ready(function()
{
  var url = $("form").attr("action");
  var poz = url.indexOf('id_kl=');
  var res = url.substring(poz, 50);
  var adr = 'podrecznik_pok.php?';
  adr += res;
  $("#user").load(adr);

//Przypisanie podrecznika
  $("#przypiszPodrecznik").click(function()
  {
	  var dane = $("form").serialize();
	  var url = $("form").attr("action");
	  var poz = url.indexOf('id_kl=');
	  var res = url.substring(poz, 50);
	  var adr = 'podrecznik.php?';
	  adr += res;

	  $.post(url, dane, function()
	  {
		$(location).attr('href',adr);
	  });
  });
 
//Dodanie podrecznika
  $("#dodajPodrecznik").click(function()
  {
	  var dane = $("form").serialize();
	  var url = $("form").attr("action");
	  var poz = url.indexOf('id_kl=');
	  var res = url.substring(poz, 50);
	  var adr = 'podrecznik.php?';
	  adr += res;

	  $.post(url, dane, function()
	  {
		$(location).attr('href',adr);
	  });
  });

//Poprawa podrecznika
  $("#poprawPodrecznik").click(function()
  {
	  var dane = $("form").serialize();
	  var url = $("form").attr("action");
	  var poz = url.indexOf('id_kl=');
	  var res = url.substring(poz, 50);
	  var adr = 'podrecznik.php?';
	  adr += res;

	  $.post(url, dane, function()
	  {
		$(location).attr('href',adr);
	  });
  });
});