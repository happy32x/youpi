<?php
    session_start();
    header("Content-Type: text/html; charset=iso-8859-1");

    //réception des donnees
    $_SESSION['id'] = $_POST['id'];
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['status'] = $_POST['status'];
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

    //On va vérifier si l'élément cliqué est dans la table "carine_mesage" et qu'il a le champ "nouveau" à 0
    $repo = $bdd->prepare('SELECT * FROM ' . $_SESSION['name'] . '_messages WHERE name = :actuel AND nouveau = :old');
    $repo->execute(array('actuel' => $_SESSION['actuel'], 'old' => 0));

    //Si l'element cliqué est dans la table "carine_mesage" et qu'il a le champ nouveau à 0
    if( $repo->fetch() )
    {
        //On met le champs "nouveau" de l'entrée "mr happy" dans la table "Carine_message" à 1
        $req = $bdd->prepare('UPDATE ' . $_SESSION['name'] . '_messages SET nouveau = :new WHERE name = :nom');
        $req->execute(array('new' => 1, 'nom' => $_SESSION['actuel']));
        $req->closeCursor();
    }
    $repo->closeCursor();

    //Si l'élément n'est pas présent dans la table, ou alors il y est présent mais avec le champ "nouveau" à 1, on continu

    //changement du champ actuel de carine par "mr happy"
    $demande = $bdd->prepare('UPDATE utilisateur SET actuel = :new_actuel WHERE name = :user_name');
    $demande->execute(array('new_actuel' => $_SESSION['actuel'], 'user_name' => $_SESSION['name']));
    $demande->closeCursor();

    //récupération du status de "mr happy"
    $reponse = $bdd->prepare('SELECT * FROM utilisateur WHERE name = :actuel');
    $reponse->execute(array('actuel' => $_SESSION['actuel']));

    //conservation de la donnée obtenue
    $donnees = $reponse->fetch();

    //On établi le genre de evelin
    if($donnees['genre'] == 1)
    $_SESSION['a_g'] = 'male';
    else
    $_SESSION['a_g'] = 'femelle';

    echo '<img class="lumiere_bloc_recepteur_actuel" src="images/mini_light.gif"/>';

    if($donnees['status'] == 1)
    {
        echo '<img class="photo_bloc_recepteur_actuel" src="utilisateur/'.$_SESSION['actuel'].'/'.$_SESSION['actuel'].'.jpg"/>
              <img class="genre_affichage_de_personnes_recepteur" src="images/'.$_SESSION['a_g'].'.png"/>';
    }
    else
    {
        echo '<img class="photo_bloc_recepteur_actuel_offline" src="utilisateur/'.$_SESSION['actuel'].'/'.$_SESSION['actuel'].'.jpg"/>
              <img class="genre_affichage_de_personnes_recepteur" src="images/'.$_SESSION['a_g'].'.png"/>';
    }

    $reponse->closeCursor();
?>
