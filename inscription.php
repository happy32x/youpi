<div class="inscription_strong_process">
    <div class="inscription_shadow_process"></div>
    <div class="inscription_charging_process">
        <img class="inscription_charging_process_image" src="images/wait.gif"></img>
        Enregistrement de vos paramètres personnelles...
    </div>
    <div class="inscription_over_process">
      <!-- Title Text -->
      <div class="inscription_over_process_title">Choisisser votre avatar (facultatif)</div>
      <!-- formulaire select image -->
      <div class="inscription_over_process_image_1">
          <form id="uploadimage" action="index.php" method="post" enctype="multipart/form-data" name="formulaire_cache">
              <div class="formulaire_inscription_photo_image" />
                  <div class="formulaire_inscription_photo_profil">Votre photo de profil (125px*125px)</div>
                  <img class="formulaire_inscription_photo_profil_avatar" src="images/profil_avatar.jpg" onclick="file_avatar();"/>
              </div>
              <img class="formulaire_inscription_photo_loading" src="images/wait.gif" />
              <input name="pseudo" type="hidden">
              <input name="password" type="hidden">
              <input type="file" name="file" id="file" class="formulaire_inscription_photo" />
              <input type="submit" value="Connectez-vous avec cet avatar" class="inscription_over_process_submit_1">
              <div class="inscription_over_process_image_1_text"></div>
          </form>
      </div>
      <!-- la barre de séparation vertivale et la bulle ou -->
      <div class="inscription_over_process_vertical_bar"></div>
      <div class="inscription_over_process_bulle_ou"><p>OU</p></div>
      <!-- formulaire WebCam image -->
      <div class="inscription_over_process_image_2">

          <!-- La camera de capture d'image -->
          <video id="avatar_camera" class="inscription_over_process_image_2_webcam"></video>
          <img id="startbutton_camera" class="inscription_over_process_image_2_snap" src="images/snap.png"/>
          <canvas id="canvas_camera"></canvas>
          <img id="photo_camera" class="inscription_over_process_image_2_avatar" src="images/profil_avatar.jpg"/>

          <!-- Le formulaire d'envoi -->
          <form action="index.php" method="post" name="formulaire_camera">
              <input name="pseudo" type="hidden">
              <input name="password" type="hidden">
              <input name="capture" type="hidden" value="0"><!-- la capture de la camera -->
              <input type="submit" value="Connectez-vous avec cet avatar" class="inscription_over_process_submit_2">
          </form>

      </div>

      <img class="inscription_over_process_close" src="images/cross_inscription_green.png" onclick="cacher_cadre_validation();">
      <img class="inscription_over_process_juste" src="images/formulaire_inscription_info_bulle_bon.png">
      <div class="inscription_over_process_text">
        Compte crée avec succes
      </div>
      <!-- <form class="inscription_over_process_form" name="formulaire_cache" method="post" action="index.php">
          <input name="pseudo" type="hidden">
          <input name="password" type="hidden">
          <input class="inscription_over_process_submit" value="Connectez-vous" type="submit">
      </form> -->
    </div>
</div>

<div class="back_shadow_content">
    <div class="back_shadow_1" onclick="cacher_cadre_inscription();"></div>

    <div class="back_shadow_2">
        <div class="cadre_inscription">
            <div class="cadre_inscription_barre"><img src="images/cross_inscription.png" class="cadre_inscription_barre_close" onclick="cacher_cadre_inscription();"/></div>

            <form class="formulaire_inscription" name="formulaire">
                <div class="formulaire_inscription_nom_info_bulle_doublon">
                    <img class="formulaire_inscription_nom_info_bulle_doublon_fleche" src="images/formulaire_inscription_nom_info_bulle_fleche.png"/>
                    Ce pseudo est déja pris par un autre
                    utilisateur.
                </div>

                <img class="formulaire_inscription_nom_info_bulle_bon" src="images/formulaire_inscription_info_bulle_bon.png"/>
                <img class="formulaire_inscription_nom_info_bulle_faux" src="images/formulaire_inscription_info_bulle_faux.png"/>
                <div class="formulaire_inscription_nom_info_bulle">
                    <img class="formulaire_inscription_nom_info_bulle_fleche" src="images/formulaire_inscription_nom_info_bulle_fleche.png"/>
                    Votre pseudo devra disposer d'au moins 4 caractères.
                    Les espaces, les Metacaractères et autres caractères génériques sont interdits.
                    Seule les caractères alphanumériques, l'underscore
                    et le tiret sont permis.
                </div>

                <img class="formulaire_inscription_pass_info_eye" src="images/formulaire_inscription_eye.png"/>
                <img class="formulaire_inscription_pass_info_bulle_bon" src="images/formulaire_inscription_info_bulle_bon.png"/>
                <img class="formulaire_inscription_pass_info_bulle_faux" src="images/formulaire_inscription_info_bulle_faux.png"/>
                <div class="formulaire_inscription_pass_info_bulle">
                    <img class="formulaire_inscription_pass_info_bulle_fleche" src="images/formulaire_inscription_pass_info_bulle_fleche.png"/>
                    Le mot de passe doit contenir au moins 8 caractères.
                    Les Metacaractères ! ^ $ ( ) [ ] { } ? + * . / \ | sont interdits.
                </div>


                <input type="text" class="formulaire_inscription_nom" placeholder="Votre Pseudo" maxlength="40"/>
                <input type="password" class="formulaire_inscription_pass" placeholder="Votre mot de passe" maxlength="40"/>

                <div class="formulaire_inscription_other">
                    <label for="select_label">Classe</label>
                    <select class="formulaire_inscription_classe" id="select_label">
                        <option value="GL1">GL1</option>
                        <option value="SR1">SR1</option>
                        <option value="GL2">GL2</option>
                        <option value="SR2">SR2</option>
                    </select>

                    <div class="formulaire_inscription_genre">
                        <input type="radio" name="genre" value="1" id="Homme" checked><label for="Homme">Homme</label><br>
                        <input type="radio" name="genre" value="0" id="Femme"><label for="Femme">Femme</label><br>
                    </div>
                </div>

                <div class="formulaire_inscription_button_info_bulle">
                    <img class="formulaire_inscription_button_info_bulle_fleche" src="images/formulaire_inscription_nom_info_bulle_fleche.png"/>
                    Le Pseudo et le mot de passe sont obligatoires.
                </div>
                <input type="button" class="formulaire_inscription_button" value="s'inscrire" />

            </form>
        </div>
    </div>
</div>

<?php include 'auto_inscription.js.php'; ?>

<script>
     function file_avatar(){
       $(".formulaire_inscription_photo").click();
     }
     function cacher_cadre_inscription(){
       $(".back_shadow_content").hide();
     }
     function cacher_cadre_validation(){
       $(".inscription_strong_process").hide();
     }
     function montrer_cadre_inscription(){
       $(".back_shadow_content").show();
     }
</script>
