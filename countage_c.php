<?php
    session_start();
    header("Content-Type: text/html; charset=iso-8859-1");

    //reception des variables
    $_SESSION['name'] = $_POST['name'];

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


    //on entre dans la table "utilisateur" pour obtenir actuel
                                            $ronic = $bdd->prepare('SELECT actuel FROM utilisateur WHERE name = :nom');
                                            $ronic->execute(array('nom' => $_SESSION['name']));
                                            $donic = $ronic->fetch();
                                            $_SESSION['actuel'] = $donic['actuel'];
                                            $ronic->closeCursor();

    //On entre dans la table "Carine_message" pour obtenir le contenu du champ "nombre" de "actuel"
    //pour obtenir le nombre de commentaire envoyé à carine par evelin.
    $req = $bdd->prepare('SELECT nombre FROM ' . $_SESSION['name'] . '_messages WHERE name = :nom');
    $req->execute(array('nom' => $_SESSION['actuel']));
    $dount = $req->fetch();

    if( $dount == false )
    echo '';
    else
    {
        if($dount['nombre'] == 1)
            echo '<span id="receptacle_content" onclick="flash_sonic();">' . $dount['nombre'] . ' nouveau message</span>';
        else
            echo '<span id="receptacle_content" onclick="flash_sonic();">' . $dount['nombre'] . ' nouveaux messages</span>';
    }

    $req->closeCursor();
?>
