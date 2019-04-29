$(document).ready(function()
{
  var data = new Date();
  var msc = data.getMonth();
  var sem = "";
  
  if (msc > 0 && msc < 8) {
	sem = "oceny_k.php?id_ucz=";
  } else {
	sem = "oceny.php?id_ucz=";
  }
  
  //Panel
  var ucz = $(".aktywna").attr("id").valueOf();
  
  var str = sem + ucz;
  $(".ocena").attr("href", str);
 
  var str = "obecnosc.php?id_ucz=" + ucz;
  $(".obecnosc").attr("href", str);

  var str = "uwagi.php?id_ucz=" + ucz;
  $(".uwaga").attr("href", str);

  var str = "podreczniki.php?id_ucz=" + ucz;
  $(".podrecznik").attr("href", str);
  
  var str = "plan_zajec.php?id_ucz=" + ucz;
  $(".plan").attr("href", str);
  
  var str = "nauczyciele.php?id_ucz=" + ucz;
  $(".nauczyciele").attr("href", str);

//ustawienie przedmiotu	
  $("a.zaj").click(function()
  {
	  $(".aktywna").removeClass("aktywna");
	  $(this).addClass("aktywna");

	  var ucz = $(".aktywna").attr("id").valueOf();

	  var str = "oceny.php?id_ucz=" + ucz;
	  $(".ocena").attr("href", str);
	 
	  var str = "obecnosc.php?id_ucz=" + ucz;
	  $(".obecnosc").attr("href", str);
	
	  var str = "uwagi.php?id_ucz=" + ucz;
	  $(".uwaga").attr("href", str);
	
	  var str = "podreczniki.php?id_ucz=" + ucz;
	  $(".podrecznik").attr("href", str);
	  
	  var str = "plan_zajec.php?id_ucz=" + ucz;
	  $(".plan").attr("href", str);

  });

});