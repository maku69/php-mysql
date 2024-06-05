<?php
$server = 'localhost';
$dbuser = 'root';
$dbpass = '';
$db = 'muusikapood';

$yhendus = mysqli_connect($server, $dbuser, $dbpass, $db);
if (!$yhendus) {
    die('Probleem andmebaasiga: ' . mysqli_connect_error());
}
?>
