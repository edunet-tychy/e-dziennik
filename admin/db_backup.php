﻿<?php
include_once('status.php');
//Nawiązanie połączenia serwerem MySQL.
include_once('db_connect.php');
//Zmienne
$username = "root";
$password = "";
$hostname = "localhost";
$dbname   = "zs6_tychy";
 
//W przypadku braku zmiennej systemowej dostępu do programu MYSQLDUMP podajemy pełną ścieżkę dostępu 
//W innym przypadku wystarczy podać "mysqldump --add-drop-table ..."
//$command = "mysqldump --add-drop-table --host=$hostname --user=$username ";
$dumpfname = $dbname . "_" . date("Y-m-d_H-i-s").".sql";
$command = "C:\\xampp\\mysql\\bin\\mysqldump --add-drop-table --host=$hostname --user=$username ";
if ($password)
$command.= "--password=". $password ." ";
$command.= $dbname;
$command.= " > " . $dumpfname;
system($command);
 
// Kompresja pliku z archiwum
$zipfname = $dbname . "_" . date("Y-m-d_H-i-s").".zip";
$zip = new ZipArchive();
if($zip->open($zipfname,ZIPARCHIVE::CREATE))
{
   $zip->addFile($dumpfname,$dumpfname);
   $zip->close();
}
 
// Zapis skompresowanego pliku
if (file_exists($zipfname)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($zipfname));
    flush();
    readfile($zipfname);
    exit;
}
?>