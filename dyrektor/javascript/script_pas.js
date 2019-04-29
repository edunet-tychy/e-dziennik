$(document).ready(function()
{
//wyświetlanie danych
	var kto = $("#st").attr("value");
	var url1 = "db_user_pok.php?st=" + kto;
	$("#user").load(url1);

//Zmiana hasła
	$("#zmien").click(function()
	{
		var url5 = $("#formUpr").attr("action");
		var id = $("#id").val();
		var st = $("#st").val();
		var logon = $("#logon").val();
		var passwdStary = $("#passwdStary").val();
		var passwd = $("#passwd").val();
		var passwdPow = $("#passwdPow").val();
		var email = $("#email").val();
		url5 += "?id=" + id + "&st=" + st + "&logon=" + logon + "&passwdStary=" + passwdStary + "&passwd=" + passwd + "&passwdPow=" + passwdPow + "&email=" + email;
		
		if(logon != '' && passwdStary != '' && passwd != '' && passwdPow != '')
		{
			if(passwd != passwdPow)
			{
			  alert("Hasła są różne!");
			} else {
			  $.get(url5, function()
			  {
				  $("#konDanych").load(url5);
			  });				
			}
			
		} else {
		  alert("Uzupełnij wymagane pola!");
		}

	});

//Walidacja forumularza
	var ostNazwisko = 0;
	var ostImie = 0;
	var ostPasswd = 0;
	var ostPasswdPow = 0;
	var ostLogin = 0;
	var	ostPasswdStary = 0;
	var sprPasswd = 0;

//Walidacja - puste nazwisko	
	$("#nazwisko").bind("blur", function()
	{
		if($(this).val() == "" && ostNazwisko == 0)
		{
			$("#konNazw").append("<p class='kontrola' id='wpisNazw'>Podaj Nazwisko</p>");
			ostNazwisko = 1;
		}
		
		if($(this).val() != "" && ostNazwisko == 1)
		{
			$("#konNazw").html("<p class='kontrola' id='wpisNazw'></p>")
			ostNazwisko = 0;
		}
	});

//Walidacja - puste imię	
	$("#imie").bind("blur", function()
	{
		if($(this).val() == "" && ostImie == 0)
		{
			$("#konImie").append("<p class='kontrola' id='wpisImie'>Podaj imię</p>");
			ostImie = 1;
		}
		
		if($(this).val() != "" && ostImie == 1)
		{
			$("#konImie").html("<p class='kontrola' id='wpisImie'></p>")
			ostImie = 0;
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
			$("#konLoginu").load(url3);
		});
	});

//Walidacja - sprawdzenie długości hasła
	$("#passwd").bind("blur", function()
	{
		if($(this).val().length < 8)
		{
			if(ostPasswd != 1)
			{
				$("#konPasswd").append("<p class='kontrola' id='wpisPasswd'>Hasło musi zawierać minimum 8 znaków.</p>");
			}
			ostPasswd = 1;
		} else {
			$("#konPasswd").html("<p class='kontrola' id='wpisPasswd'> </p>")
			ostPasswd = 0;		
		}
	});

//Walidajca - pusty login	
	$("#logon").bind("blur", function()
	{
		if($(this).val() == "" && ostLogin == 0)
		{
			$("#konLogin").append("<p class='kontrola' id='wpisKonLogin'>Wprowadź login</p>");
			ostLogin = 1;
		}
		
		if($(this).val() != "" && ostLogin == 1)
		{
			$("#konLogin").html("<p class='kontrola' id='wpisKonLogin'></p>")
			ostLogin = 0;
		}
	});

//Walidajca - puste hasło	
	$("#passwdStary").bind("blur", function()
	{
		if($(this).val() == "" && ostPasswdStary == 0)
		{
			$("#konPasswdStary").append("<p class='kontrola' id='wpisKonPassSt'>Wprowadź hasło</p>");
			ostPasswdStary = 1;
		}
		
		if($(this).val() != "" && ostPasswdStary == 1)
		{
			$("#konPasswdStary").html("<p class='kontrola' id='wpisKonPassSt'></p>")
			ostPasswdStary = 0;
		}
	});
	
});