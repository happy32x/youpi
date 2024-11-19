<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");

    //réception des donnees
    $_POST['namePreviousValue'];
    $_POST['valeur_classe'];
    $_POST['valeur_genre'];

    //Hashage du mot de passe
    $_POST['passPreviousValue'] = MD5($_POST['passPreviousValue']);

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

    //On vérifie s'il est déjà inscrit
    $reponse = $bdd->query('SELECT * FROM utilisateur');
    $deja = 0;

    while ($donnees = $reponse->fetch() AND $deja == 0)
    {
       if( $_POST['namePreviousValue'] == $donnees['name'] )
       {
           $deja = 1;
       }
    }
    $reponse->closeCursor();

    //S'il n'est pas encore inscrit
    if( $deja == 0 )
    {
    //On crée l'entrée newUser dans la table utilisateur
    $req_inscript = $bdd->prepare('INSERT INTO utilisateur (name, password, status, actuel, genre, classe) VALUES(:name, :password, :status, :actuel, :genre, :classe)');
    $req_inscript->execute(array('name' => $_POST['namePreviousValue'], 'password' => $_POST['passPreviousValue'], 'status' => 0, 'actuel' => 'youpi', 'genre' => $_POST['valeur_genre'], 'classe' => $_POST['valeur_classe']));
    $req_inscript->closeCursor();

    //On rend lisible $messageUser
    $messageUser = $_POST['namePreviousValue'];
    $messageUser = $messageUser.'_messages';

    //On crée la table newUser_messages
    $sql_messages = "CREATE TABLE IF NOT EXISTS $messageUser (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                nombre INT(30) NOT NULL,
                nouveau tinyint(1) NOT NULL
            )";
    $bdd->exec($sql_messages);

    //On rend lisible $youpiUser
    $youpiUser = $_POST['namePreviousValue'];
    $youpiUser = 'youpi_'.$youpiUser;

    //On crée la table youpi_newUser
    $sql_youpi = "CREATE TABLE IF NOT EXISTS $youpiUser (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nom VARCHAR(255) NOT NULL,
                commentaires text NOT NULL,
                nouveau tinyint(1) NOT NULL
            )";
    $bdd->exec($sql_youpi);

    //On rend lisible $nameUser
    $nameUser = $_POST['namePreviousValue'];

    //On création le dossier utilisateur/new_User
    mkdir("utilisateur/".$nameUser);

    //On insère l'image "aucun.jpg"
    copy("utilisateur/aucun.jpg","utilisateur/".$nameUser."/".$nameUser.".jpg");

    //On établi le genre de new_User pour Mr ou Mme
    if($_POST['valeur_genre'] != 0)
    $commentaire_genre = 'Mr';
    else
    $commentaire_genre = 'Mme';

    //On rend lisible $commentaire_bienvenue
    $commentaire_bienvenue = $commentaire_genre . " " . $_POST['namePreviousValue'] . ", l'équipe youpi
                             ainsi que tous ses utilisateurs vous souhaitent la bienvenue.";

    //On envoi un message au nouvel utilisateur de la part de youpi
    $req_comment = $bdd->prepare('INSERT INTO youpi_' . $_POST['namePreviousValue'] . '(nom, commentaires, nouveau) VALUES(:nom, :commentaires, :nouveau)');
    $req_comment->execute(array('nom' => 'youpi', 'commentaires' => $commentaire_bienvenue, 'nouveau' => 1));
    $req_comment->closeCursor();
    $req_message = $bdd->prepare('INSERT INTO ' . $_POST['namePreviousValue'] . '_messages(name, nombre, nouveau) VALUES(:name, :nombre, :nouveau)');
    $req_message->execute(array('name' => 'youpi','nombre' => 1,'nouveau' => 1));
    $req_message->closeCursor();
    }
?>
