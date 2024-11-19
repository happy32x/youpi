




<!--------------------------------------- preleminaires --------------------------------------------->
<?php

  	session_start();
    header('Content-Type: text/html; charset=utf-8');

    $host = $_SESSION['host'] = 'localhost';      //sql304.byethost10.com
    $dbname = $_SESSION['dbname'] = 'quick_chat'; //b10_17727520_quick_chat
    $root = $_SESSION['root'] = 'root';           //b10_17727520
    $pass = $_SESSION['pass'] = '';               //BLAStoise32x

    //Ouverture de la base de donnees
    try
		{
			  $bdd = new PDO("mysql:host=$host;dbname=$dbname", $root, $pass);
		}
		catch (Exception $e)
		{
			  die('Erreur : ' . $e->getMessage());
		}

    if( isset($_POST) )
    {
	    if( isset($_POST['pseudo']) AND isset($_POST['password']) )
	    {
		    $reponse = $bdd->query('SELECT * FROM utilisateur');
        $scan = 0;
        $first = 0;

		    while ($donnees = $reponse->fetch() AND $scan == 0)
		    {
          // vérification du pseudo
			    if ( strtolower(htmlspecialchars($_POST['pseudo'])) == strtolower($donnees['name']) )
			    {
				    $tape_pseudo = $donnees['name'];
				    $temoin_pseudo = 'temoin_vrai';
				    $scan++;
            $first++;
			    }
			    else
			    {
				    $temoin_pseudo = 'temoin_faux';
			    }

          // vérification du password
			    if ( htmlspecialchars(MD5($_POST['password'])) == $donnees['password'] AND $first > 0)
			    {
				    $tape_password = $donnees['password'];
				    $temoin_password = 'temoin_vrai';
				    $scan++;
			    }
			    else
			    {
				    $temoin_password = 'temoin_faux';
			    }

			    if( $scan == 2 )
			    {
				    // A ce niveau, on va vérifier si l'utilisateur s'est déjà connecté, pour eviter la double connection
				    if($donnees['status'] == 1)
				    {
					      $conflit_de_connection = 1;
				    }
				    else
				    {
					      $req = $bdd->prepare('UPDATE utilisateur SET status = :new_status WHERE name = :user_name');
					      $req->execute(array('new_status' => 1, 'user_name' => $donnees['name']));
                $req->closeCursor();

                //On récupère les infos sur carine
                $_SESSION['id'] = $donnees['id'];
					      $_SESSION['name'] = $donnees['name'];
                $_SESSION['status'] = 1;
                $_SESSION['actuel'] = $donnees['actuel'];
                $_SESSION['genre'] = $donnees['genre'];
                $_SESSION['classe'] = $donnees['classe'];

                //On configure l'avatar de New_User si le fichier image est envoyé
                if(isset($_FILES["file"]["type"]))
                {
                    $validextensions = array("jpeg", "jpg");
                    $temporary = explode(".", $_FILES["file"]["name"]);
                    $file_extension = end($temporary);
                    if ((($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && in_array($file_extension, $validextensions))
                    {
                      if ($_FILES["file"]["error"] <= 0)
                      {
                          //if(file_exists("utilisateur/" . $_SESSION['name'] . "/" . $_SESSION['name'] . ".jpg"))
                          unlink("utilisateur/" . $_SESSION['name'] . "/" .  $_SESSION['name'] . ".jpg");

                          $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
                          $targetPath = "utilisateur/" . $_SESSION['name'] . "/" .  $_SESSION['name'] . ".jpg"; // Target path where file is to be stored
                          move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
                      }
                    }
                }

                //On configure l'avatar de New_User si le cliché est envoyé
                if(isset($_POST["capture"]) AND $_POST["capture"] != "0")
                {
                    //On prépare la fonction de convertion
                    function base64_to_jpeg($base64_string, $output_file)
                    {
                        $ifp = fopen($output_file, "wb");
                        $data = explode(',', $base64_string);
                        fwrite($ifp, base64_decode($data[1]));
                        fclose($ifp);

                        return $output_file;
                    }

                    //On a acces à session
                    //$_SESSION['name'];

                    //On récupére le fichier brut
                    $base64_string = $_POST["capture"];

                    //On supprime le fichier image existant
                    //if(file_exists("utilisateur/" . $_SESSION['name'] . "/" . $_SESSION['name'] . ".jpg"))
                    unlink("utilisateur/" . $_SESSION['name'] . "/" .  $_SESSION['name'] . ".jpg");

                    $myfile_PATH = "utilisateur/" . $_SESSION['name'] . "/" . $_SESSION['name'] . ".jpg";
                    $myfile = fopen( $myfile_PATH , "w");

                    //On appel la fonction de convertion
                    $myfile = base64_to_jpeg($base64_string , $myfile_PATH);
                }

                //Vous êtes à présent connecté , on incrémente la table connect_to_youpi
                $r_connect = $bdd->query('SELECT connect FROM connect_to_youpi');
                $d_connect = $r_connect->fetch();
                $d_connect['connect']++;
                $r_connect->closeCursor();

                $r_connect_send = $bdd->prepare('UPDATE connect_to_youpi SET connect = :new');
        	      $r_connect_send->execute(array('new' => $d_connect['connect']));
                $r_connect_send->closeCursor();

                //On recupère des infos sur evelin
                $recept = $bdd->prepare('SELECT * FROM utilisateur WHERE name = :actual_name');
                $recept->execute(array('actual_name' => $_SESSION['actuel']));
                $decept = $recept->fetch();
                $recept->closeCursor();

                $_SESSION['actuel_id'] = $decept['id'];
					      $_SESSION['actuel_name'] = $decept['name'];
                $_SESSION['actuel_status'] = $decept['status'];
                $_SESSION['actuel_actuel'] = $decept['actuel'];
                $_SESSION['actuel_genre'] = $decept['genre'];
                $_SESSION['actuel_classe'] = $decept['classe'];

                //Variable utile qui indique que "Carine" n'est pas
                //connecté ailleur sur une autre machine.
                $conflit_de_connection = 0;
					   }
     		   }
		    }
        $reponse->closeCursor();

        if($scan <= 1)
        {
            $conflit_de_connection = 0;
            $_SESSION['status'] = 0;
        }
	  	}

      if( isset($_POST['deconnection']) && $_POST['deconnection'] == 1 )
      {
          $reqon = $bdd->prepare('UPDATE utilisateur SET status = :new_status WHERE name = :user_name');
			    $reqon->execute(array('new_status' => 0, 'user_name' => $_SESSION['name']));
          $reqon->closeCursor();

          //Vous êtes à présent déconnecté , on décrémente la table connect_to_youpi
          $r_connect = $bdd->query('SELECT connect FROM connect_to_youpi');
          $d_connect = $r_connect->fetch();
          $d_connect['connect']--;
          $r_connect->closeCursor();

          $r_connect_send = $bdd->prepare('UPDATE connect_to_youpi SET connect = :new');
          $r_connect_send->execute(array('new' => $d_connect['connect']));
          $r_connect_send->closeCursor();

          //On réinitialise les variables
          $scan = 0;
          $_SESSION['status'] = 0;
			    $conflit_de_connection = 0;
          $_SESSION['name'] = 'aucun';
      }
    }

?>

<!--------------------------------------- preleminaires --------------------------------------------->


    <?php
    if( isset($_SESSION['status']) && $_SESSION['status'] == 1 )
    {
    ?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

    <div id="html">
		<head>
		<title>YouPi!</title>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />

    <link rel="icon" type="image/bmp" href="images/ico_quick_chat_logo.bmp" />
    <!-- <link rel="shortcut icon" type="image/x-icon" href="images/ico_quick_chat_logo.png" /> -->

    <link rel="stylesheet" href="css/pub.css" />
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/orange.css" />
		<link rel="stylesheet" href="css/content.css" />
		<link rel="stylesheet" href="css/reponse.css" />
		<link rel="stylesheet" href="css/portail.css" />
		<link rel="stylesheet" href="css/listeur.css" />
    <link rel="stylesheet" href="css/sub_html.css" />
    <link rel="stylesheet" href="css/selector.css" />
		<link rel="stylesheet" href="css/footer.css" />
	</head>

	<body onload="load_thunder();">
		<header>
            <img src="images/sun_set.bmp" alt="sun_set" class="sun_set" />
            <img src="images/header_background.bmp" alt="Chat_City" class="chat_city" />

            <div id="language_button">
                <strong>Fr</strong>
            </div>

            <div class="header_mini">
			   <div class="banniere">
				   <a href="#"><img src="images/quick_chat_logo.bmp" alt="Logo du site" class="bulles"></a>
				   <a href="#"><img src="images/quick_chat_name.bmp" alt="Titre du site" class="titre"></a>
			   </div>

               <div class="banniere_menu">

             <div class="admin_content">
                 <div class="admin_content_text">
                    Votre nouveau mot de passe<br>
                    <input type="PASSWORD"><br>

                    <label for="select_label">Votre nouvelle classe<br></label>
                    <select class="formulaire_inscription_classe" id="select_label">
                        <option value="GL1">GL1</option>
                        <option value="SR1">SR1</option>
                        <option value="GL2">GL2</option>
                        <option value="SR2">SR2</option>
                    </select><br>

                    <input type="button" class="admin_content_submit" value="Modifier">
                    <p class="alert_no_finish">Fonctionnalités Indisponibles</p>
                 </div>
                 <div class="admin_content_avatar"></div>
             </div>
			       <div class="admin">
               <img class="roue_parametre" src="images/roue_parametre.png" />
				       <span title="Modifier vos paramètres">Paramètres</span>
			       </div>

                   <div class="message_d_acceuil" title="Visiter votre mur">
                       <div class="cadre_des_illusions"></div>

                       <!-- chargement de la mini bannière -->
                       <img class="mini_banniere_d_acceuil" src="utilisateur/mini_banniere.jpg" />

                       <div class="fond_transparent_message_d_acceuil">Bienvenue, <strong><?php echo $_SESSION['name'] ?></strong></div>
                   </div>

                   <form method="post" action="index.php" class="contener_bouton_eclair">
                       <input type="hidden" name="deconnection" value="1"/>
                       <input type="submit" title="fermer votre session" value="" class="bouton_eclair"/>
                   </form>

                </div>
			</div>
		</header>
		<section class="principal">
			<div class="horizontal"></div>

			<div class="fond_des_fond">
                <div id="Mega_search_result"></div>

                <div id="Mega_search">
                    <form method="post" action="index.php" id="Mega_search_form">
                       <input type="text" placeholder="Chercher quelqu'un ..." id="Mega_search_input" autocomplete="off"/>
                       <input type="button" value="" id="Mega_search_bouton" />
                    </form>
                </div>

				       <div class="vertical_gauche">
                   <!--<img src="images/lumiere_vertical_gauche.gif" class="lumiere_vertical_gauche"/>
                   <div class="background_pub_contener_vertical_gauche">
                       <div class="up_pub_contener_vertical_gauche"></div>

                       <div id="pub_contener_vertical_gauche">
                           <div id="pub_actuel" style="clip: rect( 0px , 145px , 600px , 0px);">
                               <div class="pub1"></div>
                               <div class="pub2"></div>
                               <div class="pub3"></div>
                               <div class="pub4"></div>
                               <div class="pub5"></div>
                               <div class="pub6"></div>
                           </div>

                           <img id="go_to_top" style="clip: rect( 0px , 45px , 0px , 0px);" src="images/go_to_top_gd.bmp"/>
                           <img id="go_to_menu" style="clip: rect( 0px , 0px , 145px , 0px);" src="images/go_to_menu_gd.bmp"/>
                           <img id="go_to_bottom" style="clip: rect( 0px , 45px , 0px , 0px);" src="images/go_to_bottom_gd.bmp"/>
                       </div>

                       <div class="down_pub_contener_vertical_gauche"></div>
                   </div>-->
                </div>

				<div class="bloc_du_milieu_2">

					<div class="bloc_haut_bloc_haut">
                      <div class="background_pub_contener_bloc_haut_bloc_haut">
                          <div class="left_bloc_haut_bloc_haut"></div>

                          <div id="pub_contener_bloc_haut_bloc_haut">
                              <div id="pub_actuel_3" style="clip: rect( 0px , 780px , 135px , 0px);">
                                  <img class="pub_middle_1" src="images/1.jpg"></img><img class="pub_middle_2" src="images/2.jpg"></img><img class="pub_middle_3" src="images/3.jpg"></img><img class="pub_middle_4" src="images/4.jpg"></img><img class="pub_middle_5" src="images/5.jpg"></img><img class="pub_middle_6" src="images/6.jpg"></img>
                              </div>

                              <img id="go_to_top_3" style="clip: rect( 0px , 45px , 45px , 45px);" src="images/go_to_top_middle.bmp">
                              <img id="go_to_menu_3" style="clip: rect( 0px , 145px , 0px , 0px);" src="images/go_to_menu_middle.bmp">
                              <img id="go_to_bottom_3" style="clip: rect( 0px , 0px , 45px , 0px);" src="images/go_to_bottom_middle.bmp">
                          </div>

                          <div class="right_bloc_haut_bloc_haut"></div>
                      </div>
                    </div>

<!-- barre de transition -->   <div class="barre_sombre_pub_contener_bloc_haut_bloc_haut"></div>






<!-- -------------------------------------section dassault--------------------------------------- -->

					<div class="les_recepteurs">

						<div id="bloc_recepteur_actuel">
<!--1-->
                            <?php
                            //On met à jour les états de actuel(debut)
                            $recep = $bdd->prepare('SELECT actuel FROM utilisateur WHERE name = :nom');
                            $recep->execute(array('nom' => $_SESSION['name']));
                            $decep = $recep->fetch();
                            $recep->closeCursor();

                            $recepto = $bdd->prepare('SELECT * FROM utilisateur WHERE name = :actual_name');
                            $recepto->execute(array('actual_name' => $decep['actuel']));
                            $decepto = $recepto->fetch();
                            $recepto->closeCursor();

                            $_SESSION['actuel_id'] = $decepto['id'];
            					      $_SESSION['actuel_name'] = $decepto['name'];
                            $_SESSION['actuel_status'] = $decepto['status'];
                            $_SESSION['actuel_actuel'] = $decepto['actuel'];
                            $_SESSION['actuel_genre'] = $decepto['genre'];
                            $_SESSION['actuel_classe'] = $decepto['classe'];
                            //On met à jour les états de actuel(debut)

                            if($_SESSION['actuel_name'] != 'aucun')
                            {
                                ?>

                                <img title="<?php echo $_SESSION['actuel_name'] ?>" class="<?php if($_SESSION['actuel_status'] == 1){ ?>photo_bloc_recepteur_actuel<?php }else{ ?>photo_bloc_recepteur_actuel_offline<?php } ?>" src="utilisateur/<?php echo $_SESSION['actuel_name'] ?>/<?php echo $_SESSION['actuel_name'] ?>.jpg"/>
                                <img class="genre_affichage_de_personnes_recepteur" src="images/<?php if($_SESSION['actuel_genre'] == 1){ ?>male<?php }else{ ?>femelle<?php } ?>.png"/>

                                <?php
                            }
                            else
                            {
                            ?>
                                <img class="photo_bloc_recepteur_actuel" src="utilisateur/aucun.jpg"/>
                            <?php
                            }
                            ?>

						</div>

                        <div class="bloc_nouveaux_messages_des_recepteurs">
                            <img src="images/letter.gif" class="letter_message_number"/>

                            <div class="bloc_nombre_messages_des_recepteurs">
                                  <strong id="message_number">
<!--2-->
                                      <?php
                                          if($_SESSION['actuel_name'] != 'aucun')
                                          {
                                              $req = $bdd->prepare('DELETE * FROM ' . $_SESSION['name'] . '_messages WHERE name = :actuel');
								                              $req->execute(array('actuel' => $_SESSION['actuel_name']));
                                              $req->closeCursor();
                                          }

									                        $reponse = $bdd->query('SELECT * FROM ' . $_SESSION['name'] . '_messages');
                                          $_SESSION['messages'] = 0;

									      while ($donnees = $reponse->fetch())
									      {
                                              if($donnees['nouveau'] == 0)
                                              $_SESSION['messages']++;
									      }

									      $reponse->closeCursor();

                                          echo $_SESSION['messages'];
                                      ?>

                                  </strong>
                           </div>

                           <div id="receptacle_floral">
                                <!-- <span id="receptacle_floral_content">3 nms</span> -->
                           </div>

                           <div class="nouveau_arrivant_contener">
                               <div id="nouveau_arrivant">
<!--3-->
                               <?php
                                    //$reponse = $bdd->query('SELECT * FROM ' . $_SESSION['name'] . '_messages ORDER BY id DESC');

                                    $reponse = $bdd->prepare('SELECT * FROM ' . $_SESSION['name'] . '_messages WHERE nouveau = :new ORDER BY id DESC');
                                    $reponse->execute(array('new' => 0));

                                    while ($donnees = $reponse->fetch())
								                    {
                                        /*if($donnees['nouveau'] == 0)
                                        {*/
                                        $req = $bdd->prepare('SELECT * FROM utilisateur WHERE name = :nom');
                                        $req->execute(array('nom' => $donnees['name']));

                                        $dat = $req->fetch();
                                        ?>

                                        <div id="haut_nkam" class="<?php if($dat['status'] == 1){ ?>images_nouveau_arrivant<?php }else{ ?>images_nouveau_arrivant_offline<?php } ?>"  onclick="message_nouveau_arrivant(this);">
						 	                              <img title="<?php echo $donnees['name'] ?>" src="utilisateur/<?php echo $donnees['name'] ?>/<?php echo $donnees['name'] ?>.jpg" class="images_nouveau_arrivant_inset"/>
                                            <img class="genre_affichage_de_personnes_comment" src="images/<?php if($dat['genre'] == 1){ ?>male<?php }else{ ?>femelle<?php } ?>.png"/>
                                        </div>

                                        <?php
                                        $req->closeCursor();
                                        //}
                                    }
                                    $reponse->closeCursor();
                                ?>

                                </div>
                           </div>
                        </div>

					</div>

					<div class="bloc_con">

						<div class="centre">

							<div class="encore_content_2">

								<div class="utilisateur">
                                    <div class="user_separator_bar"></div>

                                    <img title="<?php echo $_SESSION['name'] ?>" src="utilisateur/<?php echo $_SESSION['name'] ?>/<?php echo $_SESSION['name'] ?>.jpg" alt="portrait" class="portrait_user_connect" />
                                    <img class="genre_affichage_de_personnes_emetteur" src="images/<?php if($_SESSION['genre'] == 1){ ?>male<?php }else{ ?>femelle<?php } ?>.png"/>
                                    <!-- Le formulaire -->
                                    <div class="formulaire_contener">
                                       <div class="form">
<!--local-->
											   <textarea name="dialog" id="dialog" placeholder="Ecrire un message." onkeydown="dialog_area(event); if(event.keyCode == 13)return false;"></textarea>

											   <div id="button" onclick="dialog();">
											      	<input type="submit" value="" id="put_nick" />
										       </div>
									   </div>

                                       <div class="formulaire_fond">
                                           <img src="images/lumiere_sur_formulaire.gif" class="lumiere_sur_formulaire">
                                           <img src="images/triangle_gris.gif" alt="triangle_gris" class="triangle_gris_form"/>
									   </div>
                                    </div>

								</div>

						       	<div id="receptacle">
                                    <!-- <span id="receptacle_content">3 nouveaux commentaires</span> -->
                                </div>

								<div id="reponse">
<!--4-->

                                <?php
                                if($_SESSION['actuel_name'] != 'aucun')
                                {
                                    if($_SESSION['id'] < $_SESSION['actuel_id'])
                                    $comment = $_SESSION['name'].'_'.$_SESSION['actuel_name'];
                                    else
                                    $comment = $_SESSION['actuel_name'].'_'.$_SESSION['name'];

                                    $reponse = $bdd->prepare('SELECT * FROM ' . $comment . ' WHERE nom = :user_name OR nouveau = :old ORDER BY id DESC');
                                    $reponse->execute(array('user_name' => $_SESSION['name'], 'old' => 0));

									                  while ($donnees = $reponse->fetch())
									                  {
                                        if( $donnees['nom'] == $_SESSION['name'])
                                        {
                                        ?>

                                           <div class="cadre_des_reponses">
                                               <div class="reponse_contener_image">
                                                   <img title="<?php echo $_SESSION['name'] ?>" src="utilisateur/<?php echo $_SESSION['name'] ?>/<?php echo $_SESSION['name'] ?>.jpg" class="reponse_portrait_user_connect" />
                                                   <img class="genre_affichage_de_personnes_comment" src="images/<?php if($_SESSION['genre'] == 1){ ?>male<?php }else{ ?>femelle<?php } ?>.png"/>
                                               </div>

                                               <div class="reponse_portrait_user_connect_fond">
                                                    <img src="images/reponse_triangle_gris.gif" class="reponse_triangle_gris"/>
                                                    <div class="reponse_dialog">

                                                    <?php
                                                         echo nl2br(htmlspecialchars($donnees['commentaires']));
                                                    ?>

                                                    </div>
                                               </div>
                                           </div>

                                        <?php
                                        }
                                        else
                                        {
                                        ?>

                                            <div class="cadre_des_reponses">
                                                <div class="reponse_portrait_user_connect_fond_destinataire">
                                                    <img src="images/reponse_triangle_gris_destinataire.gif" class="reponse_triangle_gris_destinataire"/>
                                                    <div class="reponse_dialog_destinataire">

                                                        <?php
                                                            echo nl2br(htmlspecialchars($donnees['commentaires']));
                                                        ?>

                                                    </div>
                                                </div>

                                                <div class="reponse_contener_image_destinataire">
                                                    <img title="<?php echo $_SESSION['actuel_name'] ?>" src="utilisateur/<?php echo $_SESSION['actuel_name'] ?>/<?php echo $_SESSION['actuel_name'] ?>.jpg" class="<?php if($_SESSION['actuel_status'] == 1){ ?>reponse_portrait_destinataire_connect<?php }else{ ?>reponse_portrait_destinataire_connect_logout<?php } ?>"/>
                                                    <img class="genre_affichage_de_personnes_comment" src="images/<?php if($_SESSION['actuel_genre'] == 1){ ?>male<?php }else{ ?>femelle<?php } ?>.png"/>
                                                </div>
                                            </div>

                                        <?php
                                        }
									}

									$reponse->closeCursor();
						        }
                                ?>

								</div>
							</div>
						</div>
					</div>
				</div>

<!---------------------------------------section dassault----------------------------------------->





				<div class="vertical_droit">
                   <!--<img src="images/lumiere_vertical_droite.gif" class="lumiere_vertical_droite"/>
                   <div class="background_pub_contener_vertical_droit">
                       <div class="up_pub_contener_vertical_droit"></div>

                       <div id="pub_contener_vertical_droit">
                           <div id="pub_actuel_2" style="clip: rect( 0px , 145px , 600px , 0px);">
                               <div class="pub1"></div>
                               <div class="pub2"></div>
                               <div class="pub3"></div>
                               <div class="pub4"></div>
                               <div class="pub5"></div>
                               <div class="pub6"></div>
                           </div>

                           <img id="go_to_top_2" style="clip: rect( 0px , 45px , 0px , 0px);" src="images/go_to_top_gd.bmp">
                           <img id="go_to_menu_2" style="clip: rect( 0px , 45px , 145px , 45px);" src="images/go_to_menu_gd.bmp">
                           <img id="go_to_bottom_2" style="clip: rect( 0px , 45px , 0px , 0px);" src="images/go_to_bottom_gd.bmp">
                       </div>

                       <div class="down_pub_contener_vertical_droit"></div>
                   </div>-->
                </div>


                <div class="contener_selector_ultra">
                   <img src="images/contener_selector_ultra_up.png" class="contener_selector_ultra_up"/>
                   <div class="selector_ultra"></div>
                   <div class="filter_ultra">
                       <ul class="filter_ultra_content">
                          <li class="filter_ultra_content_liste"><p>Liste</p></li>
                          <li class="filter_ultra_content_filtre"><p>Filtre</p></li>
                       </ul>
                       <div class="filter_ultra_content_liste_content">
                         <div class="filter_ultra_content_liste_content_bouton">Actualiser la liste des utilisateurs</div>
                         <div class="filter_ultra_content_liste_content_wait">
                            <img class="filter_ultra_content_liste_content_wait_img" src="images/wait.gif"/>
                            Chargement ...
                         </div>
                         <div class="filter_ultra_content_liste_content_bas">
                           <!--<div class="filter_ultra_content_liste_content_element" onclick="message_nouveau_arrivant(this);">
                             <img class="filter_ultra_content_liste_content_element_snap" title="ponou" src="utilisateur/ponou/ponou.jpg"/>
                             <img class="filter_ultra_content_liste_content_element_snap_genre" src="images/femelle.png">
                             <p class="filter_ultra_content_liste_content_element_name">0123456789012345678901234567890123456789<br><strong>GL1</strong></p>
                           </div>-->
                         </div>
                       </div>
                       <div class="filter_ultra_content_filtre_content">
                          <form name="filter" class="filter_form">
                             <fieldset class="filter_field_1">
                                <legend class="filter_legend_1">Classe</legend>
                                <input type="checkbox" name="GL1" id="GL1" value="GL1"><label for="GL1">GL1</label><br>
                                <input type="checkbox" name="SR1" id="SR1" value="SR1"><label for="SR1">SR1</label><br>
                                <input type="checkbox" name="GL2" id="GL2" value="GL2"><label for="GL2">GL2</label><br>
                                <input type="checkbox" name="SR2" id="SR2" value="SR2"><label for="SR2">SR2</label><br>
                             </fieldset>

                             <fieldset class="filter_field_2">
                                <legend class="filter_legend_2">Genre</legend>
                                <input type="checkbox" name="Homme" id="Homme" value="1"><label for="Homme">Homme</label><br>
                                <input type="checkbox" name="Femme" id="Femme" value="0"><label for="Femme">Femme</label><br>
                             </fieldset>
                             <input type="button" value="Filter" class="filter_button" onclick="big_filter();">
                             <script>
                                  function big_filter()
                                  {

                                      //document.filter_form.
                                  }
                             </script>
                          </form>
                       </div>
                     </div>
                   </div>
                </div>


			<div class="bloc_du_listeur">
          <img src="images/bloc_du_listeur_fleche_indice.gif" class="bloc_du_listeur_fleche_indice"/>

				  <div class="affichage_de_personnes"></div>

          <div id="conteneur_affichage_de_personnes">
               <ul id="conteneur_affichage_de_personnes_defil">

                     <?php
                     $repo = $bdd->prepare('SELECT * FROM utilisateur WHERE name != :user_name');
                     $repo->execute(array('user_name' => $_SESSION['name']));

                     while ($dono = $repo->fetch())
                     {
                     ?>
                         <li id="bas_nkam" class="<?php if($dono['status'] == 0){ ?>form_align_offline<?php }else{ ?>form_align<?php } ?>"  onclick="message_nouveau_arrivant(this);">
                             <img title="<?php echo $dono['name'] ?>" src="utilisateur/<?php echo $dono['name'] ?>/<?php echo $dono['name'] ?>.jpg" class="photo_affichage_de_personnes"/>
                             <img class="genre_affichage_de_personnes" src="images/<?php if($dono['genre'] == 1){ ?>male<?php }else{ ?>femelle<?php } ?>.png"/>
                         </li>
                     <?php
                     }
                     ?>
               </ul>

              <!-- <img id="go_to_top_4"  style="clip: rect( 0px , 45px , 45px , 45px);" src="images/go_to_top_middle.bmp" />           -->
              <!--  <img id="go_to_menu_4" style="clip: rect( 0px , 145px , 0px , 0px);" src="images/go_to_menu_middle.bmp">            -->
              <!--  <img id="go_to_bottom_4" style="clip: rect( 0px , 0px , 45px , 0px);" src="images/go_to_bottom_middle.bmp" />        -->
           </div>
			</div>

			<!--<div class="bloc_du_footer">
                <div class="bloc_footer_contener">

                   <div class="bloc_du_footer_1">

                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">sds</span>
                           <span class="element_du_mini_bloc_du_footer">element 2</span>
                           <span class="element_du_mini_bloc_du_footer">koikoukou</span>
                           <span class="element_du_mini_bloc_du_footer">hord jeu</span>
                       </div>

                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">soyez les bienvenus !!!</span>
                           <span class="element_du_mini_bloc_du_footer">element 2</span>
                           <span class="element_du_mini_bloc_du_footer">bye</span>
                       </div>

                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">www.kifeurou.achat_en_ligne.fr</span>
                           <span class="element_du_mini_bloc_du_footer">nerf 9</span>
                       </div>

                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">www.WiseComputerService.SAV.cm</span>
                           <span class="element_du_mini_bloc_du_footer">K</span>
                       </div>

                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">Reparation de laptop gratuit</span>
                           <span class="element_du_mini_bloc_du_footer">Click here</span>
                       </div>

                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">Portail wise en ligne</span>
                           <span class="element_du_mini_bloc_du_footer">Samsung Galaxy</span>
                       </div>

                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">SataAvarage</span>
                           <span class="element_du_mini_bloc_du_footer">slim 2.4 hd</span>
                           <span class="element_du_mini_bloc_du_footer">satellite c+</span>
                       </div>
                   </div>

                        <img class="intersection_bloc_footer" src="images/vertical_graphic_footer.bmp">

                   <div class="bloc_du_footer_2">
                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">sds</span>
                           <span class="element_du_mini_bloc_du_footer">element 2</span>
                           <span class="element_du_mini_bloc_du_footer">koikoukou</span>
                           <span class="element_du_mini_bloc_du_footer">hord jeu</span>
                       </div>

                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">soyez les bienvenus !!!</span>
                           <span class="element_du_mini_bloc_du_footer">element 2</span>
                           <span class="element_du_mini_bloc_du_footer">bye</span>
                       </div>

                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">www.kifeurou.achat_en_ligne.fr</span>
                           <span class="element_du_mini_bloc_du_footer">nerf 7</span>
                       </div>

                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">www.WiseComputerService.SAV.cm</span>
                           <span class="element_du_mini_bloc_du_footer">K</span>
                       </div>

                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">Reparation de laptop gratuit</span>
                           <span class="element_du_mini_bloc_du_footer">Click here</span>
                       </div>

                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">Portail wise en ligne</span>
                           <span class="element_du_mini_bloc_du_footer">Samsung Galaxy</span>
                       </div>

                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">SataAvarage</span>
                           <span class="element_du_mini_bloc_du_footer">slim 2.4 hd</span>
                           <span class="element_du_mini_bloc_du_footer">satellite c+</span>
                       </div>
                   </div>

                        <img class="intersection_bloc_footer" src="images/vertical_graphic_footer.bmp">

                   <div class="bloc_du_footer_3">


                       <div class="mini_bloc_du_footer_4"></div>


                       <div class="mini_bloc_du_footer">
                            <span class="element_du_mini_bloc_du_footer">koikoukou</span>
                            <span class="element_du_mini_bloc_du_footer">element 2</span>
                            <span class="element_du_mini_bloc_du_footer">sds</span>
                            <span class="element_du_mini_bloc_du_footer">PS4</span>
                       </div>
                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">sds</span>
                           <span class="element_du_mini_bloc_du_footer">element 2</span>
                           <span class="element_du_mini_bloc_du_footer">koikoukou</span>
                           <span class="element_du_mini_bloc_du_footer">PS3</span>
                       </div>
                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">football manager</span>
                           <span class="element_du_mini_bloc_du_footer">anzi-shop</span>
                           <span class="element_du_mini_bloc_du_footer">F16</span>
                       </div>
                            <div class="mini_bloc_du_footer">
                            <span class="element_du_mini_bloc_du_footer">koikoukou</span>
                            <span class="element_du_mini_bloc_du_footer">element 2</span>
                            <span class="element_du_mini_bloc_du_footer">sds</span>
                            <span class="element_du_mini_bloc_du_footer">PS4</span>
                       </div>
                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">sds</span>
                           <span class="element_du_mini_bloc_du_footer">element 2</span>
                           <span class="element_du_mini_bloc_du_footer">koikoukou</span>
                           <span class="element_du_mini_bloc_du_footer">PS3</span>
                       </div>
                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">football manager</span>
                           <span class="element_du_mini_bloc_du_footer">anzi-shop</span>
                           <span class="element_du_mini_bloc_du_footer">F16</span>
                       </div>
                       <div class="mini_bloc_du_footer">
                           <span class="element_du_mini_bloc_du_footer">participer aux anchères en ligne</span>
                           <span class="element_du_mini_bloc_du_footer">Z</span>
                       </div>
                   </div>

                        <img class="intersection_bloc_footer" src="images/vertical_graphic_footer.bmp">


                   <div class="bloc_du_footer_4">
                   </div>
                   <img src="images/lumiere_bloc_du_footer_4.gif" class="lumiere_bloc_du_footer_4" />


                </div>
			</div>-->

            <div class="dedicace">
              <?php //Pour obtenir le nombre de user connecté actuellement
                  $r_connect = $bdd->query('SELECT connect FROM connect_to_youpi');
                  $d_connect = $r_connect->fetch();
                  $r_connect->closeCursor();
              ?>
                <span class="nombre_d_utilisateurs_connectes">connection : <span id="person_actual_connect_number"><?php echo $d_connect['connect']; ?></span></span>
                <div class="mise_a_jour">copyright©Octobre_2016</div>
                <span class="creator_of_website">powered by Happy & RaidGhost</span>
			</div>

		</section>
	</body>

  <!-- <script type="text/JavaScript" src="scripts/langue.js"></script>
  <script type="text/JavaScript" src="scripts/pub_gauche.js"></script>
  <script type="text/JavaScript" src="scripts/pub_droit.js"></script> -->

  <script type="text/JavaScript" src="scripts/pub_middle.js"></script>
  <!-- <script type="text/JavaScript" src="scripts/list_bouton.js"></script> -->
  <script type="text/JavaScript" src="jquery.js"></script>
  <script type="text/JavaScript" src="jquery.nicescroll.js"></script>

  <script>//JQuery
      $(document).ready(function() {

         //Scroll des differents elements de l'écran
         $("html").niceScroll(
           {
             cursorcolor:"rgb(189, 189, 189)",
             background:"#FFF",
             cursorwidth: 10,
             cursorborder: "2px solid transparent",
             cursorborderradius: "100px"
          });
          $("#reponse").niceScroll(
            {
              cursorcolor:"rgb(189, 189, 189",//"#FF8000",
              cursorwidth: 10,
              cursorborder: "2px solid transparent",
              cursorborderradius: "100px"
           });
           $("#conteneur_affichage_de_personnes_defil").niceScroll(
             {
               cursorcolor:"rgb(255, 180, 0)",
               cursorwidth: 10,
               cursorborder: "2px solid transparent",
               cursorborderradius: "100px"
            });
            $("#nouveau_arrivant").niceScroll(
              {
                cursorcolor:"rgb(189, 189, 189)",
                cursorwidth: 10,
                cursorborder: "2px solid transparent",
                cursorborderradius: "100px"
             });
             $("#dialog").niceScroll(
               {
                 cursorcolor:"rgb(255, 180, 0)",
                 cursorwidth: 10,
                 cursorborder: "2px solid transparent",
                 cursorborderradius: "100px"
              });
             //scroll des listes
             /*$(".filter_ultra_content_liste_content").niceScroll(
               {
                 cursorcolor:"#FF8000",
                 cursorwidth: 10,
                 cursorborder: "2px solid transparent",
                 cursorborderradius: "100px"
              });*/

            //Apparition et disparition du filtre
            var contener_selector_ultra_up = 0;
            $(".contener_selector_ultra_up").click(function(){
                if(contener_selector_ultra_up == 0){
                   contener_selector_ultra_up = 1;
                   $(".contener_selector_ultra").animate({top: "-565px"});
                   $(".contener_selector_ultra_up").attr("src", "images/contener_selector_ultra_down.png");
                }
                else{
                   contener_selector_ultra_up = 0;
                   $(".contener_selector_ultra").animate({top: "0px"});
                   $(".contener_selector_ultra_up").attr("src", "images/contener_selector_ultra_up.png");
                }
            });

            //gestion des onglets du filtre
            var listAlwayActive = 1,
                filterAlwayActive = 0;
            $(".filter_ultra_content_liste").click(function(){
                if(listAlwayActive == 0){
                    listAlwayActive = 1;
                    filterAlwayActive = 0;
                    $(".filter_ultra_content_liste").css({ "background-color":"white" , "color":"black" });
                    $(".filter_ultra_content_filtre").css({ "background-color":"black" , "color":"white" });
                    $(".filter_ultra_content_liste_content").animate({width: "100%"});
                }
            });
            $(".filter_ultra_content_filtre").click(function(){
                if(filterAlwayActive == 0){
                    filterAlwayActive = 1;
                    listAlwayActive = 0;
                    $(".filter_ultra_content_filtre").css({ "background-color":"#952a2a" , "color":"white" });
                    $(".filter_ultra_content_liste").css({ "background-color":"black" , "color":"white" });
                    $(".filter_ultra_content_liste_content").animate({width: "0%"});
                }
            });


            var paramAlwayActive = 0,
                paramAlwayActive2 = 1;
            $(".admin").click(function(){
                if(paramAlwayActive == 0){
                    paramAlwayActive = 1;
                    $(".admin_content").animate({height: "197px"}).animate({width: "935px"}, function(){paramAlwayActive2 = 0;});
                }
                else if(paramAlwayActive2 == 0){
                    paramAlwayActive2 = 1;
                    $(".admin_content").animate({width: "207px"}).animate({height: "20px"}, function(){paramAlwayActive = 0;});
                }
            });
      });
  </script>

  <?php include 'auto_completion.js.php'; ?>
  <?php include 'JsCore.php'; ?>
  <?php include 'liste.js.php'; ?>
  <?php include 'total_connect_refresh.js.php'; ?>

</div>
</html>

    <?php
	  }
    else
    {
    ?>

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" id="html_acceuil">

	        <head>
		        <title>YouPi!</title>
		        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
            <link rel="icon" type="image/bmp" href="images/ico_quick_chat_logo.bmp" />
            <link rel="stylesheet" href="css/connect.css" />
            <link rel="stylesheet" href="css/inscription.css" />
	        </head>

	        <body id="body_acceuil">

               <!-- <div id="language_button_acceuil">
                     <strong>Fr</strong>
               </div> -->

		           <header id="entete_acceuil">
                   <div class="banniere_acceuil">
                       <a href="#"><img src="images/sun_set.bmp" alt="sun_set" class="sun_set_acceuil" /></a>
				               <a href="#"><img src="images/quick_chat_logo.bmp" alt="Logo du site" class="bulles_acceuil"></a>
				               <a href="#"><img src="images/quick_chat_name.bmp" alt="Titre du site" class="titre_acceuil"></a>
			             </div>
                   <div id="entete_acceuil_vertical_bar"></div>
               </header>

               <div class="zone_de_connection_acceuil">

                  <div id="gauche_acceuil">
                      <div class="slogan_acceuil">
                          <p class="text_slogan_acceuil">Dialoguer avec vos proches de maniere<br>
                                                         simple et rapide partout<br>
                                                         dans le monde !
                          </p>

                          <div id="carte_du_monde">
                              <?php //Pour obtenir le nombre de user connecté actuellement
                                  $r_connect = $bdd->query('SELECT connect FROM connect_to_youpi');
                                  $d_connect = $r_connect->fetch();
                                  $r_connect->closeCursor();
                              ?>
                              <div id="person_actual_connect"><span id="person_actual_connect_number"><?php echo $d_connect['connect']; ?></span> connecté(s)</div>
                          </div>
                      </div>
                  </div>

                  <div id="droite_acceuil">
                       <div id="inscription_acceuil" onclick="montrer_cadre_inscription();"></div>

			           <div class="identification">
				           <div class="titre_name">
				     	       <div class="text_connectez">Connectez - vous</div>
						       <form method="post" action="index.php" class="form_bas">

						 	     <!-- Verification du pseudo -->
							     <div>
								     <?php
									     if( isset($temoin_pseudo) AND $conflit_de_connection == 0)
									     {
									     ?>
										      <img src="images/<?php echo $temoin_pseudo ?>.bmp" alt="vrai" class="temoin_pseudo"/>
									     <?php
									     }
									     else
									     {
									     ?>
										      <div class="temoin_pseudo"></div>
									     <?php
									     }
									     ?>
									     <input type="text" name="pseudo" id="pseudo" autocomplete="off" placeholder="Entrer pseudo" value="<?php if( (isset($temoin_pseudo) && $temoin_pseudo == 'temoin_vrai') AND $conflit_de_connection == 0) { echo $tape_pseudo; } ?>"/>
							     </div>

							     <!-- Verification du mot de passe -->
							     <div>
								    <?php
								   	     if( isset($temoin_password) AND $conflit_de_connection == 0 )
									     {
									     ?>
										      <img src="images/temoin_faux.bmp" alt="faux" class="temoin_password"/>
									     <?php
									     }
									     else
									     {
									     ?>
										      <div class="temoin_password"></div>
									     <?php
									     }
									     ?>
									     <input type="password" name="password" id="password" placeholder="Entrer Mot de passe"/>
							    </div>

							    <input type="submit" class="connection" value="Connection" />
						     </form>
					      </div>
				      </div>



                <!--------------------------------------------------------------------------------------------------------------->



              <?php
              if( isset($conflit_de_connection) && $conflit_de_connection == 1 )
				      {
				      ?>
					      <div class="encadreur_message_d_alerte_bloc">
						      <div class="message_d_alerte_bloc">
							      <img src="images/alert_bad.gif" alt="alert" class="alert_logo"/>
							      <div class="message_d_alerte">
								      <p class="alert_text">
									      Le compte <strong><?php echo $tape_pseudo ?></strong>, auquel vous souhaitez
									      acceder est actuellement ouvert sur une autre machine.
								      </p>

								      <form method="post" action="index.php">
									      <input type="hidden" name="tape_pseudo" value="<?php echo $tape_pseudo; ?>" />
									      <input type="hidden" name="tape_password" value="<?php echo $tape_password; ?>" />
									      <input type="submit" class="deconnection_a_distance" value="Déconnexion à distance" name="deconnection_a_distance" />
								      </form>
							      </div>
						      </div>
					      </div>
				      <?php
				      }
				      if( isset($_POST['deconnection_a_distance']) )
				      {
					      // On entre dans la base grace aux variables $_POST['tape_pseudo'] et $_POST['tape_password']
					      $scan = 0;
					      $reponse = $bdd->query('SELECT * FROM utilisateur');

					      while ($donnees = $reponse->fetch() AND $scan == 0)
					      {
						      if( strtolower(htmlspecialchars($_POST['tape_pseudo'])) == strtolower($donnees['name']) AND htmlspecialchars($_POST['tape_password']) == $donnees['password'] )
						      {
							      $req = $bdd->prepare('UPDATE utilisateur SET status = :new_status WHERE name = :user_name');
							      $req->execute(array('new_status' => 0, 'user_name' => $donnees['name']));
                    $req->closeCursor();
							      $scan = 1;
						      }
					      }

					      $reponse->closeCursor();

					      if($scan == 1)
					      {
					      ?>
					           <div class="encadreur_message_d_alerte_bloc">
					               <div class="message_de_confirmation">
						               <img src="images/alert_good.gif" alt="confirmation" class="confirmaion_logo"/>
							           <p class="confirmation_text">
                                           Le compte <strong><?php echo $_POST['tape_pseudo'] ?></strong> a bien été déconnecté à distance.
							           </p>
							       </div>
					           </div>
					      <?php
					      }
					      else
					      {
					      ?>
					           <div class="encadreur_message_d_alerte_bloc">
					               <div class="message_d_alerte_bloc">
						               <img src="images/alert_bad.gif" alt="confirmation" class="alert_logo"/>
						               <p class="alert_text_pirate">
							               Le mot de passe du compte <?php $_POST['tape_pseudo'] ?> vient d'etre changé par soucis de securité.
							               Ce compte vient d'etre automatiquement deconnecté par la strategie de securité actuellement en vigueur.
						               </p>
					               </div>
			                   </div>
			              <?php
					      }
				      }
				    ?>
                    </div>
                 </div>

                 <div class="liens_sociaux">
                      <a href="#" id="index_icon" class="icon"><img src="images/icon_facebook.bmp" title="facebook"/></a>
                      <a href="#" class="icon"><img src="images/icon_twitter.bmp" title="twitter"/></a>
                      <a href="#" class="icon"><img src="images/icon_rss.bmp" title="rss"/></a>
                      <a href="#" class="icon"><img src="images/icon_viao.bmp" title="viao"/></a>
                      <a href="#" class="icon"><img src="images/icon_youtube.bmp" title="youtube"/></a>
                      <a href="#" class="icon"><img src="images/icon_skype.bmp" title="skype"/></a>
                      <a href="#" class="icon"><img src="images/icon_linkdin.bmp" title="linkdin"/></a>
                      <a href="#" class="icon"><img src="images/icon_google+.bmp" title="google+"/></a>
                      <a href="#" class="icon"><img src="images/icon_amazon.bmp" title="amazon"/></a>
                      <a href="#" class="icon"><img src="images/icon_ebay.bmp" title="ebay"/></a>
                      <a href="#" class="icon"><img src="images/icon_histagram.bmp" title="histagram"/></a>
                      <a href="#" class="icon"><img src="images/icon_yahoo.bmp" title="yahoo"/></a>
                 </div>

                 <div id="footer_acceuil_mer_de_lor">
                     <p class="update_acceuil">Octobre 2016</p>
                     <p class="editor_acceuil">by happy & RaidGhost</p>
                 </div>

                 <script type="text/JavaScript" src="jquery.js"></script>
                 <script type="text/JavaScript" src="jquery.nicescroll.js"></script>
                 <script type="text/JavaScript" src="webcam/webcam.js"></script>
                 <script>//JQuery
                     $(document).ready(function() {
                        //Scroll de l'ecran d'acceuil
                        $("html").niceScroll(
                          {
                              cursorcolor:"#FF8000",
                              background:"transparent",
                              cursorwidth: 10,
                              cursorborder: "2px solid transparent",
                              cursorborderradius: "100px"
                          });
                     });
                 </script>
                 <?php include 'inscription.php'; ?>
                 <?php include 'total_connect_refresh.js.php'; ?>
             </body>
         </html>
     <?php
     }
     ?>
