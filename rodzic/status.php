<?php
session_start();
//Sprawdzamy stan logowania
if(!isset($_SESSION['zalogowany'])){
  header('Location: ../login.php');
  exit();
}

//Sprawdzamy uprawnienia
if($_SESSION['kto'] != "Rodzic"){
  header('Location: ../logout.php');
  exit();
}
?>