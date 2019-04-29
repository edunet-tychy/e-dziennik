$(document).ready(function()
{
//Dodanie zagadnień
  $("#dodajZagadnienie").click(function()
  {
	  var dane = $("form").serialize();
	  var url = $("form").attr("action");
	  var poz = url.indexOf('id_kl=');
	  var res = url.substring(poz, 50);
	  var adr = 'rozklad_dane.php?';
	  adr += res;

	  $.post(url, dane, function()
	  {
		$(location).attr('href',adr);
	  });
  });
  
//Popraw zagadnień
  $("#poprawZagadnienie").click(function()
  {
	  var dane = $("form").serialize();
	  var url = $("form").attr("action");
	  var poz = url.indexOf('id_kl=');
	  var res = url.substring(poz, 50);
	  var adr = 'rozklad_dane.php?';
	  adr += res;

	  $.post(url, dane, function()
	  {
		$(location).attr('href',adr);
	  });
  });
  
});