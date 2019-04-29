$(document).ready(function()
{  
$("#frek").load("db_frekwencja_akt.php");
//$(".ob:first").focus();

$(".pole-center").datepicker(
{dateFormat: 'yy-mm-dd',
  firstDay: 1,
  dayNamesMin: [
  'Nd', 
  'Pn', 
  'Wt', 
  'Śr', 
  'Cz', 
  'Pt', 
  'So'],
  monthNames: [
  'Styczeń',
  'Luty',
  'Marzec',
  'Kwiecień',
  'Maj',
  'Czerwiec',
  'Lipiec',
  'Sierpień',
  'Wrzesień',
  'Październik',
  'Listopad',
  'Grudzień']
});

//Przekazywanie daty
$("#data").change(function()
{
 var data = $(this).val();
 if(data!='')
 {
   var adr = 'db_frekwencja_edit.php?data=' + data;
   $(location).attr('href',adr);
 }
});

//Poprawa frekewncji	
	$("#zapiszFrek").click(function()
	{
		var data = $("#data").val();

		if(data != '')
		{	
		  var adr = 'db_frekwencja_edit.php?data=' + data;
		  var dane = $("form").serialize();
		  var url = $("form").attr("action");

		  $.post(url, dane, function()
		  {
		    $(location).attr('href',adr);		
		  });
		  
		  $("#zapisFrek").attr('disabled','disabled');	
		  var fk = "Dane zostały zapisane! <img src='image/ajax-loader.gif' id='loader'>";
		  $("#zapis").html(fk);
		  
		}
	});

  //Zaznaczenie obecności
  $(".ob").click(function()
  {
	$(this).select();
  });

  //Reakcja na błąd
  $(".ob").change(function()
  {
	$(this).select();
	
	var pole = $(this).val();
	
	switch (pole) {
		case 'O': $(this).val('o'); pole = $(this).val(); break;
		case 'U': $(this).val('u'); pole = $(this).val(); break;
		case 'N': $(this).val('n'); pole = $(this).val(); break;
		case 'S': $(this).val('s'); pole = $(this).val(); break;
	}
	
	if(pole != 'o' && pole != 'u' && pole != 'n' && pole != 's')
	{
		$(this).css({"background": "red", "color": "#FFF"});
	} else {
		$(this).css({"background": "#B0DEFF", "color": "#000"});
	}

  });

});