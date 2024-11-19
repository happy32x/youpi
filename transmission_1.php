<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");

//réception des donnees
    $_SESSION['id'] = $_POST['id'];
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['status'] = $_POST['status'];
    $_SESSION['dialog'] = $_POST['dialog'];
    $_SESSION['genre'] = $_POST['genre'];

    //On établi le genre de carine
    if($_SESSION['genre'] == 1)
    $_SESSION['g'] = 'male';
    else
    $_SESSION['g'] = 'femelle';

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

//Introduction de deux variables supplémentaires


//on entre dans la b2d pour obtenir actuel
                                               $rescousse = $bdd->prepare('SELECT actuel FROM utilisateur WHERE name = :nom');
                                               $rescousse->execute(array('nom' => $_SESSION['name']));

                                               $descousse = $rescousse->fetch();
                                               $_SESSION['actuel'] = $descousse['actuel'];
                                               $rescousse->closeCursor();

//apres avoir obtenu $_SESSION['name'] et $_SESSION['actuel'], on les fixe
                                               $nom1 = $_SESSION['name'];
                                               $nom2 = $_SESSION['actuel'];


//PHASE D'INSERTION

                                         //on recupère l'id de evelin
                                         $req_ii = $bdd->prepare('SELECT id FROM utilisateur WHERE name = :nom');
                                         $req_ii->execute(array('nom' => $_SESSION['actuel']));

                                         $dat_ii = $req_ii->fetch();

                                         if($_SESSION['id'] < $dat_ii['id'])
                                         $comment = $nom1.'_'.$nom2;
                                         else
                                         $comment = $nom2.'_'.$nom1;

                                         //On crée la table $comment si elle n'existe pas
                                         $sql_linkUser = "CREATE TABLE IF NOT EXISTS $comment (
                                                     id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                                     nom VARCHAR(255) NOT NULL,
                                                     commentaires text NOT NULL,
                                                     nouveau tinyint(1) NOT NULL
                                                 )";
                                         $bdd->exec($sql_linkUser);

                                         $req_dialog_ii = $bdd->prepare('INSERT INTO ' . $comment . '(nom, commentaires, nouveau) VALUES(:nom, :commentaires, :nouveau)');
                                         $req_dialog_ii->execute(array('nom' => $_SESSION['name'],'commentaires' => $_SESSION['dialog'],'nouveau' => 1));
                                         $req_dialog_ii->closeCursor();

                                         //On vérifie si carine est déjà présente dans la table evelin_message
                                         $requete_ii = $bdd->prepare('SELECT * FROM  ' . $_SESSION['actuel'] . '_messages WHERE name = :nom');
                                         $requete_ii->execute(array('nom' => $_SESSION['name']));
                                         $droid_ii = $requete_ii->fetch();

                                         //Si carine n'est pas présente dans la table on l'insere
                                         if($droid_ii['name'] != $_SESSION['name'])
                                         {
                                             $vandred_ii = $bdd->prepare('INSERT INTO ' . $_SESSION['actuel'] . '_messages(name, nombre, nouveau) VALUES(:name, :nombre, :nouveau)');
                                             $vandred_ii->execute(array('name' => $_SESSION['name'],  'nombre' => 1, 'nouveau' => 1));
                                             $vandred_ii->closeCursor();
                                         }
                                         else//si elle est dans la table, on incrémente la valeur de "nombre"
                                         {
                                             //On ajoute +1 au nombre de messages déja envoyé à evelin
                                             $droid_ii['nombre']++;

                                             //On met la table evelin_message à jour
                                             $demande = $bdd->prepare('UPDATE ' . $_SESSION['actuel'] . '_messages SET nombre = :new_number WHERE name = :user_name');
                                             $demande->execute(array('new_number' => $droid_ii['nombre'], 'user_name' => $_SESSION['name']));
                                             $demande->closeCursor();
                                         }

                                         $requete_ii->closeCursor();
                                         $req_ii->closeCursor();


//PHASE D'AFFICHAGE

                                         //Dans la table $comment, on choisi et affiche le nouveau commentaire
                                         $reponse = $bdd->prepare('SELECT commentaires FROM ' . $comment . ' WHERE nouveau = :new AND nom = :user_name ORDER BY id DESC');
                                         $reponse->execute(array('new' => 1, 'user_name' => $_SESSION['name']));

                                         $donnees = $reponse->fetch();

                                             echo '<div class="cadre_des_reponses">
                                                       <div class="reponse_contener_image">
                                                           <img src="utilisateur/' . $_SESSION['name'] . '/' . $_SESSION['name'] . '.jpg" class="reponse_portrait_user_connect" />
                                                           <img class="genre_affichage_de_personnes_comment" src="images/'.$_SESSION['g'].'.png">
                                                       </div>

                                                       <div class="reponse_portrait_user_connect_fond">
                                                           <img src="images/reponse_triangle_gris.gif" class="reponse_triangle_gris"/>
                                                           <div class="reponse_dialog">'

                                                                  . nl2br(htmlspecialchars($donnees['commentaires'])) .

                                                           '</div>
                                                       </div>
                                                   </div>';

                                         $reponse->closeCursor();
                                         ?>
