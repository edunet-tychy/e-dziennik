$(document).ready(function()
{
  var id_kl = $(".center-2").attr("id");
  var url = 'uwagi_pok.php?id_kl=' + id_kl;
  $("#user").load(url);
});