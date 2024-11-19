<?php
    session_start();
    header("Content-Type: text/html; charset=iso-8859-1");

    //reception des variables
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['actuel'] = $_POST['actuel'];
    $_SESSION['origine'] = $_POST['origine'];

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

    $good = 0;
    if($_SESSION['origine'] == "haut_nkam")
    {
        //On recupere le nom des recepteurs de la table "carine_message" dont nouveau = 0
        $req = $bdd->prepare('SELECT name FROM ' . $_SESSION['name'] . '_messages WHERE nouveau = :old');
        $req->execute(array('old' => 0));

        while( $dat = $req->fetch() AND $good == 0 )
        {
            if( $dat['name'] == $_SESSION['actuel'] )
            $good = 1;
        }

        //fermeture
        $req->closeCursor();
    }
    else
    $good = 1;

    //Si on a le droit de continuer
    if( $good == 1 )
    echo 'no';
    else
    echo 'yes';
?>
