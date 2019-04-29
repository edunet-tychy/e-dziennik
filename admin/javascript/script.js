$(document).ready(function()
{
//wyświetlanie danych
	var kto = $("#st").attr("value");
	var url1 = "db_user_pok.php?st=" + kto;
	$("#user").load(url1);

//Dodanie użtykownika	
	$("#dodaj").click(function()
	{
	  var nazwisko = $("#nazwisko").val();
	  var imie = $("#imie").val();
	  var email = $("#email").val();
	  var login = $("#login").val();
	  var Haslo = $("#passwd").val();
	  var powHaslo = $("#passwdPow").val();
	  
	  if(nazwisko == '' || imie == '' || login == '')
	  {
		  alert("Wypełnij wszystkie pola!");
	  } else if (Haslo != powHaslo)
	  {
		 $("#konPasswd").html("<p class='kontrola' id='wpisPasswd'>Hasła są różne!</p>"); 
	  } else if (Haslo.length < 8)
	  {
		 $("#konPasswd").html("<p class='kontrola' id='wpisPasswd'>Hasło musi mieć minimum 8 znaków!</p>");
	  } else {
		
		var dane = $("#form").serialize();
		var url2 = $("#form").attr("action");
		
		$.post(url2, dane, function()
		{
		  $("#user").load(url1);
		});
		
		//Czyszczenie pól formularz
		$("#nazwisko").val("");
		$("#imie").val("");
		$("#email").val("");
		$("#login").val("");
		$("#passwd").val("");	
		$("#passwdPow").val("");		  
	  }
	});

//Poprawa danych użytkownika
	$("#popraw").click(function()
	{
		var dane4 = $("#formUp").serialize();
		var url4 = $("#formUp").attr("action");
		var adr = "db_user.php?st=" + kto;
		$.post(url4, dane4, function()
		{
			$(location).attr('href',adr);
		});	
	});

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

//Generowanie loginu
	$("#genHas").click(function()
	{
  		var passwd = '';
  		var chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@';
  		for (i=0;i<8;i++)
		{
    	 var c = Math.floor(Math.random()*chars.length + 1);
    	 passwd += chars.charAt(c)
		}
		alert(passwd);
		$("#passwd").val(passwd);
		$("#passwdPow").val(passwd);
	});

//Generowanie hasła
	$("#genLog").click(function()
	{
  		var logon = '';
  		var chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  		for (i=0;i<8;i++)
		{
    	 var c = Math.floor(Math.random()*chars.length + 1);
    	 logon += chars.charAt(c)
		}
		$("#login").val(logon);
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
			$("#konNazw").append("<p class='kontrola' id='wpisNazw'>Podaj nazwisko</p>");
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
			$("#konPasswd").html("<p class='kontrola' id='wpisPasswd'></p>")
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