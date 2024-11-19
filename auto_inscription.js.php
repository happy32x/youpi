<script>

(function(){

    var infoTimeFade = 200,
        pseudoContinueInscription = 0,
        passContinueInscription = 0,
        valeur_classe = 1,
        valeur_genre = 1;

    var inscriptionButton = document.getElementsByClassName('formulaire_inscription_button');

    var nameInputElement = document.getElementsByClassName('formulaire_inscription_nom'),
        namePreviousValue = nameInputElement[0].value,
        namePreviousRequest;

    var passInputElement = document.getElementsByClassName('formulaire_inscription_pass'),
        passPreviousValue = passInputElement[0].value,
        passPreviousRequest;

        function treat_name_word(tape_word)
        {
            $('.formulaire_inscription_button_info_bulle').fadeOut(infoTimeFade);
            if (/^[a-z0-9_-]{4,40}$/i.test(tape_word))
            {
                var xhr_name = new XMLHttpRequest();
                xhr_name.onreadystatechange = function()
                                              {
                                                  if (xhr_name.readyState == 4 && xhr_name.status == 200)
                                                  {
                                                      if(xhr_name.responseText == 'yes'){
                                                          //c mauvais
                                                          $('.formulaire_inscription_nom_info_bulle').fadeOut(infoTimeFade);
                                                          $('.formulaire_inscription_nom_info_bulle_doublon').fadeIn(infoTimeFade);
                                                          $('.formulaire_inscription_nom_info_bulle_faux').fadeIn(infoTimeFade);
                                                          $('.formulaire_inscription_nom_info_bulle_bon').fadeOut(infoTimeFade);
                                                          pseudoContinueInscription = 0;
                                                      }
                                                      else{
                                                          //c bon
                                                          $('.formulaire_inscription_nom_info_bulle').fadeOut(infoTimeFade);
                                                          $('.formulaire_inscription_nom_info_bulle_doublon').fadeOut(infoTimeFade);
                                                          $('.formulaire_inscription_nom_info_bulle_faux').fadeOut(infoTimeFade);
                                                          $('.formulaire_inscription_nom_info_bulle_bon').fadeIn(infoTimeFade);
                                                          pseudoContinueInscription = 1;
                                                      }
                                                  }
                                              };

                xhr_name.open("POST", "auto_inscription.php", true);
                xhr_name.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr_name.send("tape_word="+tape_word);

                return xhr_name;
            }
            else
            {
                $('.formulaire_inscription_nom_info_bulle').fadeIn(infoTimeFade);
                $('.formulaire_inscription_nom_info_bulle_doublon').fadeOut(infoTimeFade);
                $('.formulaire_inscription_nom_info_bulle_faux').fadeIn(infoTimeFade);
                $('.formulaire_inscription_nom_info_bulle_bon').fadeOut(infoTimeFade);
                pseudoContinueInscription = 0;
            }
        }

        function treat_pass_word(tape_pass)
        {
            $('.formulaire_inscription_button_info_bulle').fadeOut(infoTimeFade);
            if (/^[^\!\^\$\(\)\[\]\{\}\?\+\*\.\/\\\|<>]{8,40}$/i.test(tape_pass))
            {
                $('.formulaire_inscription_pass_info_bulle').fadeOut(infoTimeFade);
                $('.formulaire_inscription_pass_info_bulle_faux').fadeOut(infoTimeFade);
                $('.formulaire_inscription_pass_info_bulle_bon').fadeIn(infoTimeFade);
                passContinueInscription = 1;
            }
            else
            {
                $('.formulaire_inscription_pass_info_bulle').fadeIn(infoTimeFade);
                $('.formulaire_inscription_pass_info_bulle_faux').fadeIn(infoTimeFade);
                $('.formulaire_inscription_pass_info_eye').fadeIn(infoTimeFade);
                $('.formulaire_inscription_pass_info_bulle_bon').fadeOut(infoTimeFade);
                passContinueInscription = 0;
            }
        }

        //Ensemble d'evenements qui controle l'oeil du mot de passe
        $(".formulaire_inscription_pass_info_eye").mousedown(function(){
            $(".formulaire_inscription_pass").attr("type","text");
        });
        $(".formulaire_inscription_pass_info_eye").mouseup(function(){
            $(".formulaire_inscription_pass").attr("type","password");
        });
        $(".formulaire_inscription_pass_info_eye").mouseout(function(){
            $(".formulaire_inscription_pass").attr("type","password");
        });
        $(".formulaire_inscription_pass_info_eye").mouseleave(function(){
            $(".formulaire_inscription_pass").attr("type","password");
        });

        nameInputElement[0].addEventListener('keyup', function(e) //e.keyCode == 13
                                                {
                                                    if (nameInputElement[0].value != namePreviousValue)
                                                    {
                                                        namePreviousValue = nameInputElement[0].value;

                                                        if (namePreviousRequest && namePreviousRequest.readyState < 4)
                                                        namePreviousRequest.abort();

                                                        namePreviousRequest = treat_name_word(namePreviousValue);
                                                    }
                                                }, false);

        passInputElement[0].addEventListener('keyup', function(e) //e.keyCode == 13
                                                {
                                                    if (passInputElement[0].value != passPreviousValue)
                                                    {
                                                        passPreviousValue = passInputElement[0].value;

                                                        if (passPreviousRequest && passPreviousRequest.readyState < 4)
                                                        passPreviousRequest.abort();

                                                        passPreviousRequest = treat_pass_word(passPreviousValue);
                                                    }
                                                }, false);


                                                /*
                                                  Quand on clique sur inscription,

                                                  Si passContinueInscription != 0 && pseudoContinueInscription != 0
                                                  On execute la requete Ajax en envoyant
                                                  le contenu des champs Pseudo,
                                                  mot de passe, classe et genre

                                                  Sinon
                                                  On affiche le message suivant: "Le Pseudo et le Mot de passe"
                                                                                 "sont obligatoires"
                                                */

        inscriptionButton[0].addEventListener('click', function(e)
                                                {
                                                    if(passContinueInscription != 0 && pseudoContinueInscription != 0)
                                                    {
                                                        //On fait disparaitre La boite d'inscription
                                                        $('.back_shadow_content').fadeOut(infoTimeFade);
                                                        //On affiche le chargeur.
                                                        $('.inscription_strong_process').fadeIn(infoTimeFade);
                                                        $('.inscription_charging_process').fadeIn(infoTimeFade);

                                                        //On recupère tous les éléments
                                                        namePreviousValue = nameInputElement[0].value; //le nom
                                                        passPreviousValue = passInputElement[0].value; //Le mot de passe

                                                        valeur_classe = document.getElementsByClassName('formulaire_inscription_classe')[0].value; //La classe

                                                        for (i=0; i<document.formulaire.genre.length; i++) //Le genre
                                                        {
		                                                        if (document.formulaire.genre[i].checked) {
			                                                           valeur_genre = document.formulaire.genre[i].value;
		                                                        }
	                                                      }

                                                        var xhr_new = new XMLHttpRequest();
                                                        xhr_new.onreadystatechange = function()
                                                                                     {
                                                                                          if (xhr_new.readyState == 4 && xhr_new.status == 200)
                                                                                          {
                                                                                              //On efface le chargeur.
                                                                                              $('.inscription_charging_process').fadeOut(infoTimeFade);

                                                                                              //On rempli les formulaires automatiquement
                                                                                              document.formulaire_cache.pseudo.value = namePreviousValue;
                                                                                              document.formulaire_cache.password.value = passPreviousValue;

                                                                                              document.formulaire_camera.pseudo.value = namePreviousValue;
                                                                                              document.formulaire_camera.password.value = passPreviousValue;

                                                                                              //On affiche le formulaire automatique
                                                                                              $('.inscription_over_process').fadeIn(infoTimeFade);

                                                                                              //On active la camera
                                                                                              camera();
                                                                                          }
                                                                                     };

                                                        xhr_new.open("POST", "new_User.php", true);
                                                        xhr_new.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                        xhr_new.send("namePreviousValue="+namePreviousValue+"&passPreviousValue="+passPreviousValue+"&valeur_classe="+valeur_classe+"&valeur_genre="+valeur_genre);
                                                    }
                                                    else
                                                    {
                                                         $('.formulaire_inscription_button_info_bulle').fadeIn(infoTimeFade);
                                                    }
                                                }, false);

      /*
        On fait disparaitre La boite d'inscription
        On fait apparaitre le chargeur

        DU COTé PHP (en arrière plan)
        On hashe le mot de passe,
        On crée l'entrée newUser dans la table utilisateur
        On crée la table newUser_message
        On crée le dossier utilisateur/new_User
        On envoi un message de bienvenue au nouvel utilisateur

        DU COTé HTML (en avant plan)
        On affiche le message "Tout s'est bien passé avec
                              "le bouton"  //(ceci est un formulaire caché contenant le champ pseudo et mot de passe chargé)
                              "connection"

        NOTICE
        - Au départ, le newUser a pour recepteur youpi
        - Lorsque le newUser selectionne une photo, du côté php,
          on vérifie si la table newUser_recepteur ou recepteur_newUser existe.
              Si elle n'exista pas, on la crée,
              Sinon, on continue le processus.

      */

      //Avatar.js.php
      //Fonction qui se déclenche lorsqu'on upload l'image
      /*$("#uploadimage").on('submit',(function(e) {
          e.preventDefault();
          $(".inscription_over_process_image_1_text").empty();
          $('.formulaire_inscription_photo_loading').show();

          var xhr_avatar = new XMLHttpRequest();
          var formData = new FormData();
		      formData.append("img", file);
          xhr_avatar.onreadystatechange = function()
                                        {
                                            if (xhr_avatar.readyState == 4 && xhr_avatar.status == 200)
                                            {
                                                //On efface le chargeur.
                                                $('.inscription_charging_process').fadeOut(infoTimeFade);

                                                //On rempli le formulaire automatiquement
                                                document.formulaire_cache.pseudo.value = namePreviousValue;
                                                document.formulaire_cache.password.value = passPreviousValue;

                                                //On affiche le formulaire automatique
                                                $('.inscription_over_process').fadeIn(infoTimeFade);
                                            }
                                        };

          xhr_avatar.open("POST", "avatar.php", true);
          xhr_avatar.setRequestHeader("Content-Type", "multipart/form-data");
          xhr_avatar.send();
      }));*/

      //Fonction qui se déclenche lorsqu'on choisit l'image
      $("#file").change(function() {
          $(".inscription_over_process_image_1_text").empty(); // To remove the previous error message
          var file = this.files[0];
          var imagefile = file.type;
          var match= ["image/jpeg","image/jpg"];

          if(!((imagefile==match[0]) || (imagefile==match[1])))
          {
              $('.formulaire_inscription_photo_profil_avatar').attr('src','images/profil_avatar.jpg');
              $(".inscription_over_process_image_1_text").html("Seul le format d'image <strong>JPG</strong> est supporté");
              return false;
          }
          else
          {
              var reader = new FileReader();
              reader.onload = imageIsLoaded;
              reader.readAsDataURL(this.files[0]);
          }
      });
      function imageIsLoaded(e) {
          $('.formulaire_inscription_photo_profil_avatar').attr('src', e.target.result);
          $('.formulaire_inscription_photo_profil_avatar').attr('width', '125px');
          $('.formulaire_inscription_photo_profil_avatar').attr('height', '125px');
      };

      //camera
      function camera() {
          var streaming = false,
                  video = document.querySelector('#avatar_camera'),
                  cover = document.querySelector('#cover_camera'),
                 canvas = document.querySelector('#canvas_camera'),
                  photo = document.querySelector('#photo_camera'),
            startbutton = document.querySelector('#startbutton_camera'),
                  width = 125,
                 height = 125,
             canTakePic = 0;

          navigator.getMedia = ( navigator.getUserMedia ||
                                 navigator.webkitGetUserMedia ||
                                 navigator.mozGetUserMedia ||
                                 navigator.msGetUserMedia );

          navigator.getMedia(
              {
                  video: true,
                  audio: false
              },
              function(stream)
              {
                  if (navigator.mozGetUserMedia)
                  {
                      video.mozSrcObject = stream;
                  }
                  else
                  {
                      var vendorURL = window.URL || window.webkitURL;
                      video.src = vendorURL.createObjectURL(stream);
                  }
                  video.play();
                  canTakePic = 1;
             },
             function(err)
             {
                 console.log("An error occured! " + err);
             }
          );

          video.addEventListener('canplay', function(ev)
                                            {
                                                if (!streaming)
                                                {
                                                    height = video.videoHeight / (video.videoWidth/width);
                                                    video.setAttribute('width', width);
                                                    video.setAttribute('height', height);
                                                    canvas.setAttribute('width', width);
                                                    canvas.setAttribute('height', height);
                                                    streaming = true;
                                                }
                                            }, false);

          function takepicture()
          {
            if(canTakePic == 1) {
              canvas.width = width;
              canvas.height = height;
              canvas.getContext('2d').drawImage(video, 0, 0, width, height);
              var data = canvas.toDataURL('image/jpg');
              photo.setAttribute('src', data);

              //On stocke le fichier en base64
              document.formulaire_camera.capture.value = data;
            }
          }

          startbutton.addEventListener('click', function(ev)
                                                {
                                                     takepicture();
                                                     ev.preventDefault();
                                                }, false);

      }//End of Camera
})();

</script>
