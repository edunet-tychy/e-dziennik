<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Scholium</title>
<link href="styl.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="javascript/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="javascript/script.js"></script>
</head>
<body>
<div>
<div id="logo">
<img src="image/logo.png" alt="Logo">
<p class="opis">- DOSTĘPNY Z KAŻDEGO MIEJSCA NA ŚWIECIE -</p>
</div>
  <form action = "login.php" method = "POST" id="login">
    <fieldset id="logowanie">
      <legend>LOGOWANIE</legend>
      <div id="pl_user"> </div>
      <label>Login: </label><input type="text" name="user" id="user">
      <div id="pl_haslo"> </div>
      <label>Hasło: </label><input type="password" name="haslo" id="haslo">
      <div id="info"> </div>
      <input type="submit" value="Zaloguj!" id="submit"  title="<?php if(isset($_GET['log'])) echo $_GET['log'] ?>"/>
    </fieldset>
  </form>
  <p class="info">WSTI 2014/2015 - &copy; GS</p>
</div>
</body>
</html>
