$(document).ready(function()
{
  var adr = $('.aktywna').attr("id").valueOf();
  var poz = adr.indexOf('id_kl=');
  $("#user").load(adr);

  var res = adr.substring(poz, 50);
  var dod = "rozklad_form.php?";
  dod += res;
  $("#Zagadnienie").attr("href",dod);
  
//Ustawienie przedmiotu
  $("a.zajecia").click(function()
  {
	  $(".aktywna").removeClass("aktywna");
	  $(this).addClass("aktywna");
	  
	  var adr = $(this).attr("id").valueOf();
	  var poz = adr.indexOf('id_kl=');
	  $("#user").load(adr);

      var res = adr.substring(poz, 50);
	  var dod = "rozklad_form.php?";
	  dod += res;
	  $("#Zagadnienie").attr("href",dod);

  });
  
});