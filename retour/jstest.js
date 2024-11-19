

  //JavaScript
                                    var access_KEY = 0;
                                    var actuel_old = 0;

                                    //Fonction j'ai nommé complexator
                                    function nouveau_arrivant(act)
                                    {
                                        var N_A_A = document.getElementById('nouveau_arrivant'),
                                            child_N_A_A = N_A_A.childNodes,
                                            child_N_A_A_2 = 0;

                                        for( i = 0, c = 0, l = child_N_A_A.length; c == 0 && i < l ; i++ )
                                        {
                                            if( child_N_A_A[i].nodeType === 1 )
                                            {
                                                if( child_N_A_A[i].id == 'haut_nkam' )
                                                {
                                                    if( child_N_A_A[i].firstElementChild.title == act )
                                                    {
                                                        c = 1;
                                                        N_A_A.removeChild( child_N_A_A[i] );
                                                    }
                                                }
                                                else if( child_N_A_A[i].firstElementChild.id == 'haut_nkam' )
                                                {
                                                    child_N_A_A_2 = child_N_A_A[i].childNodes;
                                                    for( i_2 = 0, c_2 = 0, l_2 = child_N_A_A_2.length; c_2 == 0 && i_2 < l_2 ; i_2++ )
                                                    {
                                                        if( child_N_A_A_2[i_2].nodeType === 1 )
                                                        {
                                                            if( child_N_A_A_2[i_2].firstElementChild.title == act )
                                                            {
                                                                c = 1;
                                                                c_2 = 1;
                                                                child_N_A_A[i].removeChild( child_N_A_A_2[i_2] );
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    function message_nouveau_arrivant(t)
                                    {
                                        if( access_KEY == 0 )
                                        {
                                           access_KEY = 1;

                                           //récupération du nom cliqué
                                           var actuel = t.firstElementChild.title;

                                           if( actuel_old != actuel )
                                           {
                                              //Variables utiles
                                              var name = '<?php echo $_SESSION['name'] ?>',
                                                  decision_GNU = 'no';

                                              //la
                                              var xhr_GNU = new XMLHttpRequest();
                                              xhr_GNU.onreadystatechange = function()
                                              {
                                                 if (xhr_GNU.readyState == 4 && xhr_GNU.status == 200)
                                                 {
                                                      decision_GNU = xhr_GNU.responseText;

                                                      //Si l'image cliquée n'a pas été modifiée
                                                      if(decision_GNU == 'no')
                                                      {
                                                           var trust_GNU_2 = 'no';
                                                           var xhr_GNU_2 = new XMLHttpRequest();

                                                           xhr_GNU_2.onreadystatechange = function()
                                                           {
                                                                if (xhr_GNU_2.readyState == 4 && xhr_GNU_2.status == 200)
                                                                {
                                                                    trust_GNU_2 = xhr_GNU_2.responseText;

                                                                    //Si l'image cliquée n'a pas été modifiée
                                                                    if( trust_GNU_2 == 'no' )
                                                                    {
                                                                       //Détermination de la méthode de suppression
                                                                       if(t.id == 'haut_nkam')
                                                                          t.parentNode.removeChild(t);
                                                                       else
                                                                          nouveau_arrivant(actuel);

                                                                       var xhr = new XMLHttpRequest();
                                                                       xhr.onreadystatechange = function()
                                                                       {
                                                                           if (xhr.readyState == 4 && xhr.status == 200)
                                                                           {
                                                                                //On stoppe les appels
                                                                                clearInterval(time_tohonor);
                                                                                clearInterval(time_together);
                                                                                //On vide l'élément receptacle
                                                                                document.getElementById('receptacle').innerHTML = "";

                                                                                //Changement de la big photo du recepteur
                                                                                document.getElementById('bloc_recepteur_actuel').innerHTML = xhr.responseText;

                                                                                //On communique les autres sections
                                                                                reponse(actuel);
                                                                                message_number();
                                                                                load_thunder();

                                                                                //On rétabli les appels
                                                                                time_together = setInterval( count_gordon ,5000);
                                                                                time_tohonor = setInterval( count_sonic ,5000);

                                                                                //variable de non retour
                                                                                actuel_old = actuel;
                                                                                access_KEY = 0;
                                                                           }
                                                                       };

                                                                       //Assignation des variables
                                                                       var id = <?php echo $_SESSION['id'] ?>,
                                                                           status = <?php echo $_SESSION['status'] ?>,
                                                                           name = '<?php echo $_SESSION['name'] ?>',
                                                                           origine = t.id;

                                                                       xhr.open("POST", "transmission.php", true);
                                                                       xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                                       xhr.send("id="+id+"&name="+name+"&status="+status+"&actuel="+actuel+"&origine="+origine);
                                                                   }
                                                                   else
                                                                   access_KEY = 0;
                                                               }
                                                           };

                                                           var name = '<?php echo $_SESSION['name'] ?>';
                                                           var origine = t.id;

                                                           xhr_GNU_2.open("POST", "SCAN.php", true);
                                                           xhr_GNU_2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                           xhr_GNU_2.send("name="+name+"&actuel="+actuel+"&origine="+origine);
                                                       }
                                                       else
                                                       access_KEY = 0;
                                                   }
                                               };

                                               var name = '<?php echo $_SESSION['name'] ?>';
                                               var origine = t.id;

                                               xhr_GNU.open("POST", "no_repeat.php", true);
                                               xhr_GNU.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                               xhr_GNU.send("name="+name+"&actuel="+actuel+"&origine="+origine);
                                            }
                                            else
                                            access_KEY = 0;
                                        }
                                    }

                                    function message_number()
                                    {
                                        var xhr_o = new XMLHttpRequest();

                                        xhr_o.onreadystatechange = function()
                                        {
                                             if (xhr_o.readyState == 4 && xhr_o.status == 200)
                                             {
                                                 document.getElementById('message_number').innerHTML = xhr_o.responseText;
                                             }
                                        };

                                        //Assignation des variables
                                        var name = '<?php echo $_SESSION['name'] ?>';

                                        xhr_o.open("POST", "transmission_0.php", true);
                                        xhr_o.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                        xhr_o.send("name="+name);
                                    }

                                    function reponse(actuel)
                                    {
                                        var xhr_i = new XMLHttpRequest();

                                        xhr_i.onreadystatechange = function()
                                        {
                                          if (xhr_i.readyState == 4 && xhr_i.status == 200)
                                          {
                                             document.getElementById('reponse').innerHTML = xhr_i.responseText;
                                          }
                                        };

                                        //Assignation des variables
                                        var id = <?php echo $_SESSION['id'] ?>,
                                            name = '<?php echo $_SESSION['name'] ?>';

                                        xhr_i.open("POST", "transmission_2.php", true);
                                        xhr_i.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                        xhr_i.send("id="+id+"&name="+name+"&actuel="+actuel);
                                    }

                                    function dialog()
                                    {
                                        var  text_dialog = document.getElementById('dialog').value;

                                        //On vérifie si on a le droit d'enclencher la procédure dialog()
                                        if(text_dialog != '')
                                        {
                                           //On desactive time_tohonor (On arrete de compter les nouveaux commentaires dans receptacle_content)
                                           clearInterval(time_tohonor);

                                           //On vide l'élément dialog
                                           document.getElementById('dialog').value = "";

                                           var xhr_ii = new XMLHttpRequest();

                                           xhr_ii.onreadystatechange = function()
                                           {
                                                if (xhr_ii.readyState == 4 && xhr_ii.status == 200)
                                                {
                                                     //variables utiles
                                                     var nouvar_ii = document.getElementById('reponse');
                                                     var res_Text_ii = xhr_ii.responseText;
                                                     var division_node_ii = document.createElement('div');

                                                     //insertion des nouveaux éléments
                                                     division_node_ii.innerHTML = res_Text_ii;
                                                     nouvar_ii.insertBefore(division_node_ii, nouvar_ii.firstChild);

                                                     //On active time_tohonor
                                                     time_tohonor = setInterval( count_sonic ,5000);
                                                }
                                           };

                                           //Assignation des variables
                                           var id = <?php echo $_SESSION['id'] ?>,
                                               name = '<?php echo $_SESSION['name'] ?>',
                                               status = <?php echo $_SESSION['status'] ?>,
                                               dialog = text_dialog;


                                           xhr_ii.open("POST", "transmission_1.php", true);
                                           xhr_ii.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                           xhr_ii.send("id="+id+"&name="+name+"&status="+status+"&dialog="+dialog);
                                        }
                                    }
  //messages
                                    var count_gordon = function()
                                    {
                                        //On desactive time_together
                                        clearInterval(time_together);
                                        //On lance la requete
                                        var xhr_c = new XMLHttpRequest();

                                        xhr_c.onreadystatechange = function()
                                        {
                                             if (xhr_c.readyState == 4 && xhr_c.status == 200)
                                             {
                                                  //on insere le nouveau receptacle_floral_content
                                                  document.getElementById('receptacle_floral').innerHTML = xhr_c.responseText;
                                                  //On retabli l'appel
                                                  time_together = setInterval( count_gordon ,5000);
                                             }
                                        };

                                        var name = '<?php echo $_SESSION['name'] ?>';

                                        xhr_c.open("POST", "countage.php", true);
                                        xhr_c.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                        xhr_c.send("name="+name);
                                    }

                                    function flash_gordon()
                                    {
                                        //On desactive time_together
                                        clearInterval(time_together);

                                        //On supprime l'element receptacle_floral_content
                                        var R_F_C = document.getElementById('receptacle_floral_content');
                                            R_F_C.parentNode.removeChild(R_F_C);

                                        var xhr_f = new XMLHttpRequest();

                                        xhr_f.onreadystatechange = function()
                                        {
                                             if (xhr_f.readyState == 4 && xhr_f.status == 200)
                                             {
                                                  //On actualise le nombre total de messages
                                                  message_number();

                                                  //On
                                                  var res_Text = xhr_f.responseText;
                                                  $("#nouveau_arrivant").prepend(res_Text);

                                                  //On active time_together
                                                  time_together = setInterval( count_gordon ,5000);
                                              }
                                         };

                                         var name = '<?php echo $_SESSION['name'] ?>';

                                         xhr_f.open("POST", "flashage.php", true);
                                         xhr_f.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                         xhr_f.send("name="+name);
                                    }

                                    var time_together = setInterval( count_gordon ,5000);
  //commentaires
                                    var count_sonic = function()
                                    {
                                        //On desactive time_tohonor
                                        clearInterval(time_tohonor);
                                        //On lance la requete
                                        var xhr_cs = new XMLHttpRequest();
                                        xhr_cs.onreadystatechange = function()
                                        {
                                             if (xhr_cs.readyState == 4 && xhr_cs.status == 200)
                                             {
                                                 //on insere le nouveau receptacle_content
                                                 document.getElementById('receptacle').innerHTML = xhr_cs.responseText;
                                                 //On retabli les appels
                                                 time_tohonor = setInterval( count_sonic ,5000);
                                             }
                                        };

                                        var name = '<?php echo $_SESSION['name'] ?>';

                                        xhr_cs.open("POST", "countage_c.php", true);
                                        xhr_cs.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                        xhr_cs.send("name="+name);
                                    };

                                    function flash_sonic()
                                    {
                                        //On desactive time_tohonor
                                        clearInterval(time_tohonor);

                                        //On supprime l'element receptacle_content
                                        var R_C = document.getElementById('receptacle_content');
                                        R_C.parentNode.removeChild(R_C);

                                        var xhr_cf = new XMLHttpRequest();

                                        xhr_cf.onreadystatechange = function()
                                        {
                                             if (xhr_cf.readyState == 4 && xhr_cf.status == 200)
                                             {
                                                  //variables utiles
                                                  var nouvar_cf = document.getElementById('reponse');
                                                  var res_Text_cf = xhr_cf.responseText;
                                                  var division_node_cf = document.createElement('div');

                                                  //insertion des nouveaux éléments
                                                  division_node_cf.innerHTML = res_Text_cf;
                                                  nouvar_cf.insertBefore(division_node_cf, nouvar_cf.firstChild);

                                                  //On active time_tohonor
                                                  time_tohonor = setInterval( count_sonic ,5000);
                                             }
                                        };

                                        var name = '<?php echo $_SESSION['name'] ?>',
                                              id = <?php echo $_SESSION['id'] ?>;

                                        xhr_cf.open("POST", "flashage_c.php", true);
                                        xhr_cf.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                        xhr_cf.send("name="+name+"&id="+id);
                                    }

                                    var time_tohonor = setInterval( count_sonic ,5000);


  //last FUNCTION
                                    function load_thunder()
                                    {
                                        //On vide receptacle_floral
                                        document.getElementById('receptacle_floral').innerHTML = "";

                                        //count_gordon
                                        var xhr_c = new XMLHttpRequest();

                                        xhr_c.onreadystatechange = function()
                                        {
                                           if (xhr_c.readyState == 4 && xhr_c.status == 200)
                                           {
                                               //on insere le nouveau receptacle_floral_content
                                               document.getElementById('receptacle_floral').innerHTML = xhr_c.responseText;
                                           }
                                        };

                                        var name = '<?php echo $_SESSION['name'] ?>';

                                        xhr_c.open("POST", "countage.php", true);
                                        xhr_c.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                        xhr_c.send("name="+name);

                                        //On vide receptacle
                                        document.getElementById('receptacle').innerHTML = "";

                                        //count_sonic
                                        var xhr_cs = new XMLHttpRequest();

                                        xhr_cs.onreadystatechange = function()
                                        {
                                           if (xhr_cs.readyState == 4 && xhr_cs.status == 200)
                                           {
                                              //on insere le nouveau receptacle_content
                                              document.getElementById('receptacle').innerHTML = xhr_cs.responseText;
                                           }
                                        };

                                        var name = '<?php echo $_SESSION['name'] ?>',
                                            id = <?php echo $_SESSION['id'] ?>;

                                        xhr_cs.open("POST", "countage_c.php", true);
                                        xhr_cs.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                        xhr_cs.send("name="+name+"&id="+id);
                                    }
