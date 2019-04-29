$(document).ready(function()
{
//Średnia ocen
for(var i=1; i <= nr; i++)
{
  var oc=0;
  var il=0;
  var sr=0;
  for(var j=0; j < 25; j++)
  {
	var nr_oc = $(".nr"+i).attr("id").valueOf()+"-"+j;
	var pr_oc = $("#"+nr_oc).val();
	var res = pr_oc.substring(0, 1);

	switch(pr_oc)
	{
	  case 'zw' :
		pr_oc = '';
		break;
	  case 'np' :
		pr_oc = '';
		break;
	  case 'nb' :
		pr_oc = '';
		break;
	  case '0' :
		il++;
		break;
	  case '1' :
		pr_oc = 1;
		break;
	  case '1+' :
		pr_oc = 1.5;
		break;
	  case '2-' :
		pr_oc = 1.75;
		break;
	  case '2' :
		pr_oc = 2;
		break;
	  case '2+' :
		pr_oc = 2.5;
		break;
	  case '3-' :
		pr_oc = 2.75;
		break;
	  case '3' :
		pr_oc = 3;
		break;
	  case '3+' :
		pr_oc = 3.5;
		break;
	  case '4-' :
		pr_oc = 3.75;
		break;
	  case '4' :
		pr_oc = 4;
		break;
	  case '4+' :
		pr_oc = 4.5;
		break;
	  case '5-' :
		pr_oc = 4.75;
		break;
	  case '5' :
		pr_oc = 5;
		break;
	  case '5+' :
		pr_oc = 5.5;
		break;
	  case '6-' :
		pr_oc = 5.75;
		break;
	  case '6' :
		pr_oc = 6;
		break;
	  default :
	  pr_oc = pr_oc;
	}
	
	if((pr_oc < 0) || (pr_oc > 6) || (res == '+'))
	{
	   $("#"+nr_oc).val("");
	   $("#sr"+i).html("");
	   break;
	}
	
	if(parseFloat(pr_oc))
	{
	  oc += parseFloat(pr_oc);
	  il++;
	}
  }
  var sr=oc/il;
  if(parseInt(sr))
  {
	$("#sr"+i).html(sr.toFixed(2));  
  }
}

//Ustawienie przedmiotu jako aktywny	
	$("a.zajecia").click(function()
	{
		$(".aktywna").removeClass("aktywna");
		$(this).addClass("aktywna");
		var adr = "oceny_k.php?id_zaj=";
		adr += $(this).attr("id").valueOf();
		$(location).attr('href',adr);
	});
	
	
	$(".for-oc-br").blur(function()
	{
		for(var i=0; i < 25; i++)
		{
			var wpis = $("#op-"+i).val();
			$("#opk-"+i).val(wpis);
		}
	});

//Obliczenie średniej po kliknięciu
$(".for-oc").blur(function()
{
  
  for(var i=1; i <= nr; i++)
  {
	var oc=0;
	var il=0;
	var sr=0;
	for(var j=0; j < 25; j++)
	{
	  var nr_oc = $(".nr"+i).attr("id").valueOf()+"-"+j;
	  var pr_oc = $("#"+nr_oc).val();
	  var res = pr_oc.substring(0, 1);

	  switch(pr_oc)
	  {
		case 'zw' :
		  pr_oc = '';
		  break;
		case 'np' :
		  pr_oc = '';
		  break;
		case 'nb' :
		  pr_oc = '';
		  break;
		case '0' :
		  il++;
		  break;
		case '1' :
		  pr_oc = 1;
		  break;
		case '1+' :
		  pr_oc = 1.5;
		  break;
		case '2-' :
		  pr_oc = 1.75;
		  break;
		case '2' :
		  pr_oc = 2;
		  break;
		case '2+' :
		  pr_oc = 2.5;
		  break;
		case '3-' :
		  pr_oc = 2.75;
		  break;
		case '3' :
		  pr_oc = 3;
		  break;
		case '3+' :
		  pr_oc = 3.5;
		  break;
		case '4-' :
		  pr_oc = 3.75;
		  break;
		case '4' :
		  pr_oc = 4;
		  break;
		case '4+' :
		  pr_oc = 4.5;
		  break;
		case '5-' :
		  pr_oc = 4.75;
		  break;
		case '5' :
		  pr_oc = 5;
		  break;
		case '5+' :
		  pr_oc = 5.5;
		  break;
		case '6-' :
		  pr_oc = 5.75;
		  break;
		case '6' :
		  pr_oc = 6;
		  break;
		default :
		pr_oc = pr_oc;
	  }
	  
	  if((pr_oc < 0) || (pr_oc > 6) || (res == '+'))
	  {
		 $("#"+nr_oc).val("");
		 $("#sr"+i).html("");
		 break;
	  }
	  
	  var znaki = /^[a-zA-Z]+$/;
      var wynik = znaki.test(pr_oc);

      if(wynik)
	  {
		 $("#"+nr_oc).val("");
		 $("#sr"+i).html("");		  
	  }
	 
	  if(parseFloat(pr_oc))
	  {
		oc += parseFloat(pr_oc);
		il++;
	  }
	}
	var sr=oc/il;
	if(parseInt(sr))
	{
	  $("#sr"+i).html(sr.toFixed(2));  
	}
  }	
});

//Zazanaczenie oceny cząstkowej
$(".for-oc").focus(function()
{
  $(this).select();
  $("#view").hide();
});

$(".for-oc-br").focus(function()
{
  $(this).select();
  //Odczytanie wartosci z identyfikatora
  var poz = $(this).attr("id").valueOf();
  //Przypisanie wartosci do indentyfikatora
  var wpis1 = 'new_';
  wpis1 += poz;
  $("#widok_opis").attr("name",wpis1);
  var wpis2 = 'sk_';
  wpis2 += poz;
  $("#widok_sk").attr("name",wpis2);
  
  var iden = $(".for-oc-br-3").attr("name").valueOf();
  var wynik = iden.substring(7, 9);
  var efekt1=tab_sk[wynik];
  var efekt2=tab_opis[wynik];

  $("#widok_sk").attr('disabled','disabled');
  $("#widok_sk").val(efekt1);
  $("#widok_opis").val(efekt2);
  
  if(efekt1 == '')
  {
	$("#view").hide();	  
  } else {
	$("#view").show();		  
  }
});

//Zapis oceny sem 2	
$("#zapisOcen_k").click(function()
{
	var dane = $("form").serialize();
	var url = $("form").attr("action");
	var adr = "oceny_k.php?id_kl=" + id_kl;
	adr += "&id=" + id;
	adr += "&id_zaj=";
	adr += $("#id_przed").val();
	var opis = "db_oceny_k.php";
	$.post(url, dane, function()
	{
	 $(location).attr('href',adr);
	});

});

});