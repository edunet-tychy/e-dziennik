$(document).ready(function()
{

  var url = $("form").attr("action");
  var poz = url.indexOf('id_kl=');
  var res = url.substring(poz, 50);
  var adr = 'uwagi_pok.php?';
  adr += res;
  $("#user").load(adr);

//Dodanie uwagi
  $("#zapiszInformacje").click(function()
  {
	  var dane = $("form").serialize();
	  var url = $("form").attr("action");
	  var poz = url.indexOf('id_kl=');
	  var res = url.substring(poz, 50);
	  var adr = 'uwagi.php?';
	  adr += res;

	  $.post(url, dane, function()
	  {
		$(location).attr('href',adr);
	  });
  });

//Poprawianie uwagi
  $("#poprawInformacje").click(function()
  {
	  var dane = $("form").serialize();
	  var url = $("form").attr("action");
	  var poz = url.indexOf('id_kl=');
	  var res = url.substring(poz, 50);
	  var adr = 'uwagi.php?';
	  adr += res;

	  $.post(url, dane, function()
	  {
		$(location).attr('href',adr);
	  });
  });
});