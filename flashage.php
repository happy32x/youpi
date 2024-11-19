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

                  //On recupere actuel
                  $requva = $bdd->prepare('SELECT * FROM utilisateur WHERE name = :user_name');
                  $requva->execute(array('user_name' => $_SESSION['name']));
                  $datuva = $requva->fetch();
                  $requva->closeCursor();
                  $_SESSION['actuel'] = $datuva['actuel'];

    //On selectionne le dernier id pour limiter notre action
    $robocop = $bdd->prepare('SELECT id FROM ' . $_SESSION['name'] . '_messages WHERE nouveau = :new ORDER BY id DESC');
    $robocop->execute(array('new' => 1));

    //On obtiend la limite qui est $domotik['id']
    $domotik = $robocop->fetch();

    //On selectionne tous les elements nouveau de la table
    $resus = $bdd->prepare('SELECT * FROM ' . $_SESSION['name'] . '_messages WHERE nouveau = :new AND name != :nom ORDER BY id DESC');
    $resus->execute(array('new' => 1, 'nom' => $_SESSION['actuel']));

    //On fait l'écho
    while ($donus = $resus->fetch())
    {
        //On vérifie la limite
        if($donus['id'] <= $domotik['id'])
        {
            $reticulum = $bdd->prepare('SELECT * FROM utilisateur WHERE name = :nom');
            $reticulum->execute(array('nom' => $donus['name']));
            $datebayo = $reticulum->fetch();

            //On etablie le genre de actuel
            if($datebayo['genre'] == 1)
            $_SESSION['a_g'] = 'male';
            else
            $_SESSION['a_g'] = 'femelle';

            if($datebayo['status'] == 1)
            {
                echo '<div id="haut_nkam" class="images_nouveau_arrivant" onclick="message_nouveau_arrivant(this);">
			                    <img title="' . $donus['name'] . '" src="utilisateur/' . $donus['name'] . '/' . $donus['name'] . '.jpg" class="images_nouveau_arrivant_inset"/>
                          <img class="genre_affichage_de_personnes_comment" src="images/'.$_SESSION['a_g'].'.png"/>
                      </div>';
            }
            else
            {
                echo '<div id="haut_nkam" class="images_nouveau_arrivant_offline"  onclick="message_nouveau_arrivant(this);">
			                    <img title="' . $donus['name'] . '" src="utilisateur/' . $donus['name'] . '/' . $donus['name'] . '.jpg" class="images_nouveau_arrivant_inset"/>
                          <img class="genre_affichage_de_personnes_comment" src="images/'.$_SESSION['a_g'].'.png"/>
                      </div>';
            }

            $reticulum->closeCursor();
        }
    }

    $resus->closeCursor();
    $robocop->closeCursor();

    //On remet tout les champs nouveau à 0
    $albator = $bdd->prepare('UPDATE ' . $_SESSION['name'] . '_messages SET nouveau = :new_nombre WHERE id <= :limit AND nouveau = :nouveau AND name != :nom');
	  $albator->execute(array('new_nombre' => 0, 'limit' => $domotik['id'], 'nouveau' => 1, 'nom' => $_SESSION['actuel']));
    $albator->closeCursor();
?>
