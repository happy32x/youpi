<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");

//réception des donnees
    $_SESSION['tape_word'] = $_POST['tape_word'];

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

//On recupère le nom de tous les utilisateurs dans la table "utilisateur"
$req = $bdd->prepare('SELECT name FROM utilisateur WHERE name = :nom');
$req->execute(array('nom' => $_SESSION['tape_word']));

//On vérifie si le pseudo est déja occupé par un autre utilisateur
if( $req->fetch() )
echo 'yes';
else
echo 'no';
?>
