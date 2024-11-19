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


    //on recupère actuel dans la table utilisateur
    $requ = $bdd->prepare('SELECT actuel FROM utilisateur WHERE name = :user_name');
    $requ->execute(array('user_name' => $_SESSION['name']));

    //conservation de la doonnée
    $datu = $requ->fetch();
    $_SESSION['actuel'] = $datu['actuel'];

    //fermeture
    $requ->closeCursor();

    //On selectionne tous ceux qui ont le champs nouveau à 1
    $req = $bdd->prepare('SELECT * FROM ' . $_SESSION['name'] . '_messages WHERE nouveau = :new AND name != :nom');
    $req->execute(array('new' => 1, 'nom' => $_SESSION['actuel']));

    //On les comptes
    $count = 0;
    while( $dat = $req->fetch() )
    {
        $count++;
    }

    //fermeture
    $req->closeCursor();

    //On fait echo
    if($count == 0)
    echo '';
    else
    echo '<span id="receptacle_floral_content" onclick="flash_gordon();">' . $count . ' nms</span>';

?>
