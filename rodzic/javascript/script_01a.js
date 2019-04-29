$(document).ready(function()
{
  var info = $(".min-7a").val();
  $("#user").load('obecnosc_pok.php?msc=' + info);
  


  $(".min-7a").change(function()
  {
	  var info = $(this).val();
	  $("#user").load('obecnosc_pok.php?msc=' + info);
  });

});