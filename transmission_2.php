<?php
    session_start();
    header("Content-Type: text/html; charset=utf-8");

    //réception des donnees
    $_SESSION['id'] = $_POST['id'];
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['actuel'] = $_POST['actuel'];
    $_SESSION['genre'] = $_POST['genre'];

    //On etabli le genre de carine
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


                                    //apres avoir obtenu $_SESSION['name'] et $_SESSION['actuel'], on les fixe
                                    $nom1 = $_SESSION['name'];
                                    $nom2 = $_SESSION['actuel'];


//Si même après avoir lu et relu votre code source truffé de commentaire, et
//que malgré tout vous ne parvené pas à en ressortir le sens,
//JETER LE TOUT !!!


                                        //ETAPE SPECIALE
                                        //on entre dans la b2d pour obtenir le status et le genre d'actuel
                                        $reebook = $bdd->prepare('SELECT * FROM utilisateur WHERE name = :actuel');
                                        $reebook->execute(array('actuel' => $_SESSION['actuel']));

                                        $deep = $reebook->fetch();
                                        $_SESSION['actuel_status'] = $deep['status'];

                                        //on eteblie le genre de evelin
                                        if($deep['genre'] == 1)
                                        $_SESSION['a_g'] = 'male';
                                        else
                                        $_SESSION['a_g'] = 'femelle';

                                        //Fermeture
                                        $reebook->closeCursor();

//Si même après avoir lu et relu votre code source truffé de commentaire, et
//que malgré tout vous ne parvené pas à en ressortir le sens,
//JETER LE TOUT !!!



                                    $req = $bdd->prepare('SELECT id FROM utilisateur WHERE name = :nom');
                                    $req->execute(array('nom' => $_SESSION['actuel']));

                                    $dat = $req->fetch();
                                    $req->closeCursor();

                                    if($_SESSION['id'] < $dat['id'])
									                      $comment = $nom1.'_'.$nom2;
                                    else
                                        $comment = $nom2.'_'.$nom1;

                                    $reponse = $bdd->prepare('SELECT * FROM ' . $comment . ' WHERE nom = :user_name OR nouveau = :old ORDER BY id DESC');
                                    $reponse->execute(array('user_name' => $_SESSION['name'], 'old' => 0));

									                  while ($donnees = $reponse->fetch())
									                  {
                                             if($donnees['nom'] == $_SESSION['name'])
                                             {

                                                 echo '<div class="cadre_des_reponses">
                                                           <div class="reponse_contener_image">
                                                               <img src="utilisateur/' . $_SESSION['name'] . '/' . $_SESSION['name'] . '.jpg" class="reponse_portrait_user_connect" />
                                                               <img class="genre_affichage_de_personnes_comment" src="images/'.$_SESSION['g'].'.png"/>
                                                           </div>

                                                           <div class="reponse_portrait_user_connect_fond">
                                                               <img src="images/reponse_triangle_gris.gif" class="reponse_triangle_gris"/>
                                                               <div class="reponse_dialog">'

                                                                      . nl2br(htmlspecialchars($donnees['commentaires'])) .

                                                               '</div>
                                                           </div>
                                                       </div>';
                                              }
                                              else
                                              {
                                                   if($_SESSION['actuel_status'] == 1)
                                                   {
                                                        echo '<div class="cadre_des_reponses">
                                                                  <div class="reponse_portrait_user_connect_fond_destinataire">
                                                                      <img src="images/reponse_triangle_gris_destinataire.gif" class="reponse_triangle_gris_destinataire"/>
                                                                      <div class="reponse_dialog_destinataire">'

                                                                             . nl2br(htmlspecialchars($donnees['commentaires'])) .

                                                                      '</div>
                                                                  </div>

                                                                  <div class="reponse_contener_image_destinataire">
                                                                       <img src="utilisateur/' . $_SESSION['actuel'] . '/' . $_SESSION['actuel'] . '.jpg" class="reponse_portrait_destinataire_connect"/>
                                                                       <img class="genre_affichage_de_personnes_comment" src="images/'.$_SESSION['a_g'].'.png"/>
                                                                  </div>
                                                              </div>';
                                                   }
                                                   else
                                                   {
                                                        echo '<div class="cadre_des_reponses">
                                                                  <div class="reponse_portrait_user_connect_fond_destinataire">
                                                                      <img src="images/reponse_triangle_gris_destinataire.gif" class="reponse_triangle_gris_destinataire"/>
                                                                      <div class="reponse_dialog_destinataire">'

                                                                             . nl2br(htmlspecialchars($donnees['commentaires'])) .

                                                                      '</div>
                                                                  </div>

                                                                  <div class="reponse_contener_image_destinataire">
                                                                       <img src="utilisateur/' . $_SESSION['actuel'] . '/' . $_SESSION['actuel'] . '.jpg" class="reponse_portrait_destinataire_connect_logout"/>
                                                                       <img class="genre_affichage_de_personnes_comment" src="images/'.$_SESSION['a_g'].'.png"/>
                                                                  </div>
                                                              </div>';
                                                   }
                                              }
									                  }

                                    $reponse->closeCursor();
                                    ?>
