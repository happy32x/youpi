//Fonction de mouvement des boutons middle.
            (function()
            {
                var Mem_3 = [45], i_3 = 0, transfert_3 = 0, process_3 = 0, buffer_3 = 0, over_3 = 0, tour_3 = 0;

                var rest_top_3 = -45, clap_top_3 = 0, marge_top_3 = 45, hauteur_top_3 = 45;
                var rest_bottom_3 = 780, clap_bottom_3 = 0, marge_bottom_3 = 780, hauteur_bottom_3 = 45;
                var rest_menu_3 = 135, clap_menu_3 = 0, marge_menu_3 = 135, hauteur_menu_3 = 45;

                var relatedTarget_3 = 0;
                var function_box_milieu = function(e_3)
                {

                    e_3 = e_3 || window.event;
                    relatedTarget_3 = e_3.relatedTarget || e_3.fromElement;

                    while (relatedTarget_3 != pub_contener_bloc_haut_bloc_haut && relatedTarget_3.nodeName != 'BODY' && relatedTarget_3 != document)
                    relatedTarget_3 = relatedTarget_3.parentNode;

                    //alert('Ta mère pond !!!');

                    if (relatedTarget_3 != pub_contener_bloc_haut_bloc_haut)
                    {
                       if(e_3.type == 'mouseover')
                       over_3 = 1;

                       else  //if(e_3.type == 'mouseout')
                       {
                           if(over_3 == 1)
                           over_3 = 0;
                           else
                           over_3 = 'debug';
                       }

                       if(process_3 == 0)
                       {
                          process_3 = 1;
                          var intervalID_3 = setInterval( function()
                          {
                              if(over_3 == 1)
                              {
                                 if(rest_top_3 < 0)
                                 {
                                     //Debut de la Zone de la mort
                                     i_3++;

                                     if(Mem_3[i_3] == null)
                                     {
                                         i_3--;
                                         //On travaille sur le nombre
                                         transfert_3 = Mem_3[i_3]/2;
                                         buffer_3 = buffer_3 + ( transfert_3 - parseInt(transfert_3) );

                                         if(buffer_3 == 1)
                                         {
                                              transfert_3 = parseInt(transfert_3) + buffer_3;
                                              buffer_3 = 0;
                                         }

                                         i_3++;
                                         transfert_3 = parseInt(transfert_3);
                                         Mem_3[i_3] = transfert_3;

                                         if(Mem_3[i_3] == 0)
                                         {
                                             Mem_3[i_3] = 1;
                                             buffer_3 = 0;
                                         }
                                     }

                                     //On effectue les calculs

                                     //top
                                     rest_top_3 = rest_top_3 + Mem_3[i_3];
                                     clap_top_3 = -rest_top_3;

                                     //menu
                                     rest_menu_3 = rest_menu_3 - Mem_3[i_3];
                                     clap_menu_3 = marge_menu_3 - rest_menu_3;

                                     //bottom
                                     rest_bottom_3 = rest_bottom_3 - Mem_3[i_3];
                                     clap_bottom_3 = marge_bottom_3 - rest_bottom_3;


                                     //On applique les résultats

                                     //top
                                     go_to_top_3.style.marginLeft = rest_top_3 + 'px';
                                     go_to_top_3.style.clip = 'rect( 0px, 45px, 45px,' + clap_top_3 + 'px)';

                                     //menu
                                     go_to_menu_3.style.marginTop = rest_menu_3 + 'px';
                                     go_to_menu_3.style.clip = 'rect( 0px, 145px,' + clap_menu_3 + 'px, 0px)';

                                     //bottom
                                     go_to_bottom_3.style.marginLeft = rest_bottom_3 + 'px';
                                     go_to_bottom_3.style.clip = 'rect( 0px,' + clap_bottom_3 + 'px, 45px, 0px)';

                                     //alert(rest_top_3);

                                     if(rest_top_3 == 0)
                                     {
                                          clearInterval(intervalID_3);
                                          buffer_3 = 0;
                                          transfert_3 = 0;
                                          tour_3 = 0;
                                          process_3 = 0;
                                     }
                                     //Fin de la Zone de la mort
                                     tour_3 = 1;
                                 }
                             }
                             else if(over_3 == 0)
                             {
                                 if(tour_3 != 0)
                                 {
                                    //On effectue les calculs

                                    //top
                                    rest_top_3 = rest_top_3 - Mem_3[i_3];
                                    clap_top_3 = -rest_top_3;

                                    //menu
                                    rest_menu_3 = rest_menu_3 + Mem_3[i_3];
                                    clap_menu_3 = marge_menu_3 - rest_menu_3;

                                    //bottom
                                    rest_bottom_3 = rest_bottom_3 + Mem_3[i_3];
                                    clap_bottom_3 = marge_bottom_3 - rest_bottom_3;


                                    go_to_top_3.style.marginLeft = rest_top_3 + 'px';
                                    go_to_top_3.style.clip = 'rect( 0px, 45px, 45px,' + clap_top_3 + 'px)';

                                    go_to_menu_3.style.marginTop = rest_menu_3 + 'px';
                                    go_to_menu_3.style.clip = 'rect( 0px, 145px,' + clap_menu_3 + 'px, 0px)';

                                    go_to_bottom_3.style.marginLeft = rest_bottom_3 + 'px';
                                    go_to_bottom_3.style.clip = 'rect( 0px,' + clap_bottom_3 + 'px , 45px, 0px)';

                                    //alert(rest_top_3);

                                    if(i_3 != 0)
                                    i_3--;

                                    if(rest_bottom_3 == 780)
                                    {
                                        clearInterval(intervalID_3);
                                        tour_3 = 0;
                                        process_3 = 0;
                                    }
                                 }
                             }
                             else if(over_3 == 'debug')
                             {
                                 clearInterval(intervalID_3);
                                 tour_3 = 0;
                                 process_3 = 0;
                             }
                          }, 0);
                       }
                    }
                 };

                 var pub_box_milieu = document.querySelector('#pub_contener_bloc_haut_bloc_haut');

                 pub_box_milieu.addEventListener('mouseover',function_box_milieu,false);
                 pub_box_milieu.addEventListener('mouseout',function_box_milieu,false);

             })();

//Fonction de defilement des pub middle.
             (function()
             {
                 var Mem_pub_3 = [780], i_pub_3 = 1, transfert_pub_3 = 0, buffer_pub_3 = 0, process_pub_3 = 0;
                 var rest_pub_3 = 0 , clap_pub_haut_3 = 0 , clap_pub_bas_3 = 0, marge_pub_3 = 0;
                 var over_up_3 = 'null', delai_3 = 0, term_3 = 1, sens_3 = 'up', fini_3 = 1;

                 var function_pub_milieu = function(e_3)
                 {
                      if(e_3 != null)
                      {
                         if(e_3.target.id == 'go_to_top_3' || e_3.keyCode == 37)
                         {
                             over_up_3 = 1;
                             delai_3 = 0;
                             if(fini_3 == 1)
                             {
                                 sens_3 = 'up';
                                 i_pub_3 = 1;
                                 term_3 = 1;
                             }
                             if(fini_3 == 0)
                             {
                                 if(sens_3 == 'up')
                                 term_3 = 1;
                                 if(sens_3 == 'down')
                                 term_3 = 0;
                             }
                         }

                         if(e_3.target.id == 'go_to_bottom_3' || e_3.keyCode == 39)
                         {
                             over_up_3 = 0;
                             delai_3 = 0;
                             if(fini_3 == 1)
                             {
                                 sens_3 = 'down';
                                 i_pub_3 = 1;
                                 term_3 = 1;
                             }
                             if(fini_3 == 0)
                             {
                                 if(sens_3 == 'up')
                                 term_3 = 0;
                                 if(sens_3 == 'down')
                                 term_3 = 1;
                             }

                             //else
                             //over_up = 'debug';
                         }
                     }

                     if(process_pub_3 == 0)
                     {
                         //Une fois que l'on est entré, on en ressort plus.
                         process_pub_3 = 1;

                         var intervalID_pub_3 = setInterval( function()
                         {
                            if(delai_3 != 500)
                            delai_3++;
                            else if(delai_3 == 500)
                            term_3 = 1;

                            if(over_up_3 == 1 || (delai_3 == 500 && sens_3 == 'up'))
                            {
                                //alert(rest_pub_3);
                                if(rest_pub_3 != -3900)
                                {
                                    if(term_3 == 1)
                                    {
                                       fini_3 = 0;

                                       //Ce calcul ne s'effectue qu'uniquement dans cette section
                                       if(Mem_pub_3[i_pub_3] == null)
                                       {
                                           i_pub_3--;

                                           //On travaille sur le nombre
                                           transfert_pub_3 = Mem_pub_3[i_pub_3]/2;
                                           buffer_pub_3 = buffer_pub_3 + ( transfert_pub_3 - parseInt(transfert_pub_3) );

                                           if(buffer_pub_3 == 1)
                                           {
                                                transfert_pub_3 = parseInt(transfert_pub_3) + buffer_pub_3;
                                                buffer_pub_3 = 0;
                                           }

                                           i_pub_3++;
                                           transfert_pub_3 = parseInt(transfert_pub_3);
                                           Mem_pub_3[i_pub_3] = transfert_pub_3;

                                           if(Mem_pub_3[i_pub_3] == 0)
                                           {
                                               Mem_pub_3[i_pub_3] = 1;
                                               buffer_pub_3 = 0;
                                           }
                                       }

                                       //On bouf grace à i_pub
                                       rest_pub_3 = rest_pub_3 - Mem_pub_3[i_pub_3];
                                       clap_pub_haut_3 = marge_pub_3 - rest_pub_3;
                                       clap_pub_bas_3 = clap_pub_haut_3 + 780;

                                       pub_actuel_3.style.marginLeft = rest_pub_3 + 'px';
                                       pub_actuel_3.style.clip = 'rect( 0px,' + clap_pub_bas_3 + 'px, 135px,' + clap_pub_haut_3 + 'px)';

                                       if(i_pub_3 == 11)
                                       {
                                            i_pub_3 = 1;
                                            over_up_3 = 'null';
                                            delai_3 = 0;
                                            fini_3 = 1;
                                       }
                                       else
                                       i_pub_3++;
                                    }
                                    else if(term_3 == 0)
                                    {
                                        delai_3 = 0;
                                        i_pub_3--;

                                        //On bouf grace à i_pub
                                        rest_pub_3 = rest_pub_3 - Mem_pub_3[i_pub_3];
                                        clap_pub_haut_3 = marge_pub_3 - rest_pub_3;
                                        clap_pub_bas_3 = clap_pub_haut_3 + 780;

                                        pub_actuel_3.style.marginLeft = rest_pub_3 + 'px';
                                        pub_actuel_3.style.clip = 'rect( 0px,' + clap_pub_bas_3 + 'px, 135px,' + clap_pub_haut_3 + 'px)';

                                        if(i_pub_3 == 1)
                                        {
                                             over_up_3 = 'null';
                                             term_3 = 1;
                                             fini_3 = 1;
                                        }
                                    }
                                }
                                else
                                {
                                    sens_3 = 'down';
                                    over_up_3 = 'null';
                                }
                             }
                             else if(over_up_3 == 0 || (delai_3 == 500 && sens_3 == 'down'))
                             {
                                 if(rest_pub_3 != 0)
                                 {
                                     if(term_3 == 1)
                                     {
                                         fini_3 = 0;

                                         //On bouf grace à i_pub
                                         rest_pub_3 = rest_pub_3 + Mem_pub_3[i_pub_3];
                                         clap_pub_haut_3 = marge_pub_3 - rest_pub_3;
                                         clap_pub_bas_3 = clap_pub_haut_3 + 780;

                                         pub_actuel_3.style.marginLeft = rest_pub_3 + 'px';
                                         pub_actuel_3.style.clip = 'rect( 0px,' + clap_pub_bas_3 + 'px, 135px,' + clap_pub_haut_3 + 'px)';

                                         if(i_pub_3 == 11)
                                         {
                                             i_pub_3 = 1;
                                             over_up_3 = 'null';
                                             delai_3 = 0;
                                             fini_3 = 1;
                                         }
                                         else
                                         i_pub_3++;
                                     }
                                     else if(term_3 == 0)
                                     {
                                         delai_3 = 0;
                                         i_pub_3--;

                                         //On bouf grace à i_pub
                                         rest_pub_3 = rest_pub_3 + Mem_pub_3[i_pub_3];
                                         clap_pub_haut_3 = marge_pub_3 - rest_pub_3;
                                         clap_pub_bas_3 = clap_pub_haut_3 + 780;

                                         pub_actuel_3.style.marginLeft = rest_pub_3 + 'px';
                                         pub_actuel_3.style.clip = 'rect( 0px,' + clap_pub_bas_3 + 'px, 135px,' + clap_pub_haut_3 + 'px)';

                                         if(i_pub_3 == 1)
                                         {
                                             over_up_3 = 'null';
                                             term_3 = 1;
                                             fini_3 = 1;
                                         }
                                     }
                                 }
                                 else
                                 sens_3 = 'up';
                             }
                         }, 20 );

                         if(ephemere_3 != 'null')
                         {
                             clearInterval(ephemere_3);
                             ephemere_3 = 'null';
                         }
                     }
                 };

                 var go_to_top_3 = document.querySelector('#go_to_top_3');
                 var go_to_bottom_3 = document.querySelector('#go_to_bottom_3');

                 go_to_top_3.addEventListener('click',function_pub_milieu,false);
                 go_to_bottom_3.addEventListener('click',function_pub_milieu,false);

                 document.addEventListener('keydown',function_pub_milieu, false);
                 var ephemere_3 = setInterval(function_pub_milieu , 1);
             })();
