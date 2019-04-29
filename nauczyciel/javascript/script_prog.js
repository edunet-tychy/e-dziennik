$(document).ready(function()
{
  var url = $("form").attr("action");
  var poz = url.indexOf('id_kl=');
  var res = url.substring(poz, 50);
  var adr = 'program_pok.php?';
  adr += res;
  $("#user").load(adr);

//Przypisanie podrecznika
  $("#przypiszProgram").click(function()
  {
	  var dane = $("form").serialize();
	  var url = $("form").attr("action");
	  var poz = url.indexOf('id_kl=');
	  var res = url.substring(poz, 50);
	  var adr = 'program.php?';
	  adr += res;

	  $.post(url, dane, function()
	  {
		$(location).attr('href',adr);
	  });
  });
 
//Dodanie programu
  $("#dodajProgram").click(function()
  {
	  var dane = $("form").serialize();
	  var url = $("form").attr("action");
	  var poz = url.indexOf('id_kl=');
	  var res = url.substring(poz, 50);
	  var adr = 'program.php?';
	  adr += res;

	  $.post(url, dane, function()
	  {
		$(location).attr('href',adr);
	  });
  });

//Poprawa program
  $("#poprawProgram").click(function()
  {
	  var dane = $("form").serialize();
	  var url = $("form").attr("action");
	  var poz = url.indexOf('id_kl=');
	  var res = url.substring(poz, 50);
	  var adr = 'program.php?';
	  adr += res;

	  $.post(url, dane, function()
	  {
		$(location).attr('href',adr);
	  });
  });
});