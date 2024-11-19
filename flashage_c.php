<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");

    //reception des variables
    $_SESSION['id'] = $_POST['id'];
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

                  $req = $bdd->prepare('DELETE FROM ' . $_SESSION['name'] . '_messages WHERE name = :actuel');
                  $req->execute(array('actuel' => $_SESSION['actuel']));
                  $req->closeCursor();

                                        //on entre dans la b2d pour obtenir actuel
                                        $rollrois = $bdd->prepare('SELECT actuel FROM utilisateur WHERE name = :nom');
                                        $rollrois->execute(array('nom' => $_SESSION['name']));
                                        $dollrois = $rollrois->fetch();
                                        $_SESSION['actuel'] = $dollrois['actuel'];
                                        $rollrois->closeCursor();


    //apres avoir obtenu $_SESSION['name'] et $_SESSION['actuel'], on les fixe
    $nom1 = $_SESSION['name'];
    $nom2 = $_SESSION['actuel'];

    //On recupere le status et le genre de evelin
    $ray_blu = $bdd->prepare('SELECT * FROM utilisateur WHERE name = :actuel');
    $ray_blu->execute(array('actuel' => $_SESSION['actuel']));
    $day_blu = $ray_blu->fetch();
    $ray_blu->closeCursor();

    $_SESSION['actuel_status'] = $day_blu['status'];

    //on eteblie le genre de evelin
    if($day_blu['genre'] == 1)
    $_SESSION['a_g'] = 'male';
    else
    $_SESSION['a_g'] = 'femelle';

    //On etablie dans quel table on va travailler
    $req_cf = $bdd->prepare('SELECT id FROM utilisateur WHERE name = :nom');
    $req_cf->execute(array('nom' => $_SESSION['actuel']));
    $dat_cf = $req_cf->fetch();
    $req_cf->closeCursor();

    //On va dans la table Carine_Evelin
    if($_SESSION['id'] < $dat_cf['id'])
    $comment = $nom1.'_'.$nom2;
    else
    $comment = $nom2.'_'.$nom1;

        //On établi une limite
        $rage = $bdd->prepare('SELECT id FROM ' . $comment . ' WHERE nouveau = :new AND nom != :name ORDER BY id DESC');
        $rage->execute(array('new' => 1, 'name' => $_SESSION['name']));
        $dage = $rage->fetch();
        $rage->closeCursor();

        //On recupere les evelin dont nouveau = 1 à partir de la limite
        $rage_2 = $bdd->prepare('SELECT commentaires FROM ' . $comment . ' WHERE nouveau = :new AND nom != :name AND id <= :new_id ORDER BY id DESC');
        $rage_2->execute(array('new' => 1, 'name' => $_SESSION['name'], 'new_id' => $dage['id']));

        //On fait les echo
        if($_SESSION['actuel_status'] == 1)
        {
            while( $dage_2 = $rage_2->fetch() )
            {
                 echo '<div class="cadre_des_reponses">
                           <div class="reponse_portrait_user_connect_fond_destinataire">
                               <img src="images/reponse_triangle_gris_destinataire.gif" class="reponse_triangle_gris_destinataire"/>
                               <div class="reponse_dialog_destinataire">'

                                     . nl2br(htmlspecialchars($dage_2['commentaires'])) .

                               '</div>
                           </div>

                           <div class="reponse_contener_image_destinataire">
                               <img src="utilisateur/' . $_SESSION['actuel'] . '/' . $_SESSION['actuel'] .'.jpg" class="reponse_portrait_destinataire_connect"/>
                               <img class="genre_affichage_de_personnes_comment" src="images/'.$_SESSION['a_g'].'.png"/>
                           </div>
                       </div>';
            }
        }
        else
        {
            while( $dage_2 = $rage_2->fetch() )
            {
                 echo '<div class="cadre_des_reponses">
                           <div class="reponse_portrait_user_connect_fond_destinataire">
                               <img src="images/reponse_triangle_gris_destinataire.gif" class="reponse_triangle_gris_destinataire"/>
                               <div class="reponse_dialog_destinataire">'

                                     . nl2br(htmlspecialchars($dage_2['commentaires'])) .

                               '</div>
                           </div>

                           <div class="reponse_contener_image_destinataire">
                               <img src="utilisateur/' . $_SESSION['actuel'] . '/' . $_SESSION['actuel'] . '.jpg" class="reponse_portrait_destinataire_connect_logout"/>
                               <img class="genre_affichage_de_personnes_comment" src="images/'.$_SESSION['a_g'].'.png"/>
                           </div>
                       </div>';
            }
        }

        //Fermeture
        $rage_2->closeCursor();

        //On met les evelin nouveau à 0 à partir de la limite
        $vega_punk_hazard = $bdd->prepare('UPDATE ' . $comment . ' SET nouveau = :new_nombre WHERE nom != :user_name AND nouveau = :nombre AND id <= :new_id');
	      $vega_punk_hazard->execute(array('new_nombre' => 0, 'user_name' => $_SESSION['name'], 'nombre' => 1, 'new_id' => $dage['id']));
        $vega_punk_hazard->closeCursor();
?>
