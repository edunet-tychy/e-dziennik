$(document).ready(function()
{

//Zmiana hasła
	$("#zmien").click(function()
	{
		var url5 = $("#formUpr").attr("action");
		var id = $("#id").val();
		var login = $("#login").val();
		var passwd = $("#passwd").val();
		var kto = $("#wpis").val();
		url5 += "?id=" + id + "&login=" + login + "&passwd=" + passwd;
		
		if(login != '' || passwd != '')
		{
			if(login != '')
			{
			  if($("#login").val().length < 8)
			  {
				$("#Login_kon").html("<p class='kontrola' id='Login_kon'>Login musi mieć 8 znaków!</p>"); 
			  }
			} else {
			  alert("Brak Loginu!");				
			}

			if(passwd != '')
			{
			  if($("#passwd").val().length < 8)
			  {
				$("#Passwd_kon").html("<p class='kontrola' id='Passwd_kon'>Hasła musi mieć 8 znaków!</p>"); 
			  } else {
				$.get(url5, function()
				{
				 $("#konDanych").load(url5);
				 if(kto == 'u') {
				  $(location).attr("href","db_info_uczen.php");
				 } else if (kto == 'r') {
				  $(location).attr("href","db_info_rodzic.php");
				 }
				});				  
			  }
			} else {
			  alert("Brak hasła!");				
			}
		} else {
		  alert("Uzupełnij wymagane pola!");
		}
	});

//Sprawdzenie, czy w bazie istnieje login o takiej samej nazwie	
	$("#login").bind("blur", function()
	{
		var url3="db_login.php";
		var login=$("#login").val();
		url3 += "?login=" +login;
		$.get(url3, function()
		{
			$("#Login_kon").load(url3);
		});
	});
});