<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

$host = $_SESSION['host'];
$dbname = $_SESSION['dbname'];
$root = $_SESSION['root'];
$pass = $_SESSION['pass'];

//Ouverture de la base de donnees
try
{
    $bdd = new PDO("mysql:host=$host;dbname=$dbname", $root, $pass);
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

$r_connect = $bdd->query('SELECT connect FROM connect_to_youpi');
$d_connect = $r_connect->fetch();
$r_connect->closeCursor();

echo  $d_connect['connect'];

?>
