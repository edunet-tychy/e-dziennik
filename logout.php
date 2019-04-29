<?php
session_start();
if(!isset($_SESSION['zalogowany'])){
  $komunikat = "Nie jesteś zalogowany!";
}
else{
  unset($_SESSION['zalogowany']);
  if (isset($_COOKIE[session_name()])){
    setcookie(session_name(), '', time() - 3600);
  }
  $komunikat = "Wylogowanie prawidłowe!";
}
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="refresh" content="3; url=index.php">
<title>Scholium</title>
<link href="styl.css" rel="stylesheet" type="text/css">
</head>
<body>
  <form>
    <fieldset id="logowanie">
      <legend><?php echo $komunikat ?></legend>
	  <div id="end">
      	<img src="image/end.png" alt="E_Dziennik">
      </div>
      
    </fieldset>
  </form>
  <p class="info">WSTI 2014/2015 - &copy; GS</p>
</body>
</html>
