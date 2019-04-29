$(document).ready(function()
{
//ustawienie przedmiotu	
  $("a.zajecia").click(function()
  {
	  $(".aktywna").removeClass("aktywna");
	  $(this).addClass("aktywna");
	  var adr = "oceny.php?id_zaj=";
	  adr += $(this).attr("id").valueOf();
	  $(location).attr('href',adr);
	  $("#view").show();
  });
  
  $(".for-oc-br").blur(function()
  {
	  for(var i=0; i < 22; i++)
	  {
		  var wpis = $("#op-"+i).val();
		  $("#opk-"+i).val(wpis);
	  }
  });

});