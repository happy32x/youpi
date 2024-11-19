//Fonction de mouvement des boutons list.
            (function()
            {
                var Mem_4 = [45], i_4 = 0, transfert_4 = 0, process_4 = 0, buffer_4 = 0, over_4 = 0, tour_4 = 0;
                
                var rest_top_4 = -45, clap_top_4 = 0, marge_top_4 = 45, hauteur_top_4 = 45;   
                var rest_bottom_4 = 895, clap_bottom_4 = 0, marge_bottom_4 = 895, hauteur_bottom_4 = 45;  
                var rest_menu_4 = 83, clap_menu_4 = 0, marge_menu_4 = 83, hauteur_menu_4 = 45;

                var relatedTarget_4 = 0;
                var function_box_list = function(e_4)
                {     
                    
                    e_4 = e_4 || window.event;
                    relatedTarget_4 = e_4.relatedTarget || e_4.fromElement;
    
                    while (relatedTarget_4 != conteneur_affichage_de_personnes && relatedTarget_4.nodeName != 'BODY' && relatedTarget_4 != document)
                    relatedTarget_4 = relatedTarget_4.parentNode;

                    //alert('Ta mère pond !!!');
                    
                    if (relatedTarget_4 != conteneur_affichage_de_personnes) 
                    {
                       if(e_4.type == 'mouseover')
                       over_4 = 1;                                   
                        
                       if(e_4.type == 'mouseout')
                       {
                           if(over_4 == 1)
                           over_4 = 0;
                           else
                           over_4 = 'debug';
                       }                             
                    
                       if(process_4 == 0)
                       {
                          process_4 = 1;
                          var intervalID_4 = setInterval( function()
                          {   
                              if(over_4 == 1)
                              {
                                 if(rest_top_4 < 0)   
                                 {
                                     //Debut de la Zone de la mort
                                     i_4++; 
                                              
                                     if(Mem_4[i_4] == null)
                                     {
                                         i_4--;          
                                         //On travaille sur le nombre                                                                            
                                         transfert_4 = Mem_4[i_4]/2;
                                         buffer_4 = buffer_4 + ( transfert_4 - parseInt(transfert_4) );
                                      
                                         if(buffer_4 == 1)
                                         {
                                              transfert_4 = parseInt(transfert_4) + buffer_4;
                                              buffer_4 = 0;   
                                         }                                      
                                          
                                         i_4++;
                                         transfert_4 = parseInt(transfert_4);
                                         Mem_4[i_4] = transfert_4;
                                      
                                         if(Mem_4[i_4] == 0)
                                         {
                                             Mem_4[i_4] = 1;  
                                             buffer_4 = 0; 
                                         }                                               
                                     }                                                                                                                               

                                     //On effectue les calculs
                                     
                                     //top
                                     rest_top_4 = rest_top_4 + Mem_4[i_4];
                                     clap_top_4 = -rest_top_4;                                                                                                              
                                     
                                     //menu
                                     rest_menu_4 = rest_menu_4 - Mem_4[i_4];
                                     clap_menu_4 = marge_menu_4 - rest_menu_4;
                                     
                                     //bottom
                                     rest_bottom_4 = rest_bottom_4 - Mem_4[i_4];
                                     clap_bottom_4 = marge_bottom_4 - rest_bottom_4;
                                     
                                     
                                     //On applique les résultats
                                     
                                     //top
                                     go_to_top_4.style.marginLeft = rest_top_4 + 'px';
                                     go_to_top_4.style.clip = 'rect( 0px, 45px, 45px,' + clap_top_4 + 'px)';                                                                              
                                     
                                     //menu
                                     go_to_menu_4.style.marginTop = rest_menu_4 + 'px';
                                     go_to_menu_4.style.clip = 'rect( 0px, 145px,' + clap_menu_4 + 'px, 0px)';
                                                                          
                                     //bottom
                                     go_to_bottom_4.style.marginLeft = rest_bottom_4 + 'px';
                                     go_to_bottom_4.style.clip = 'rect( 0px,' + clap_bottom_4 + 'px, 45px, 0px)';
                                     
                                     //alert(rest_top_4);

                                     if(rest_top_4 == 0)   
                                     {
                                          clearInterval(intervalID_4);                                          
                                          buffer_4 = 0;
                                          transfert_4 = 0; 
                                          tour_4 = 0;
                                          process_4 = 0;
                                     } 
                                     //Fin de la Zone de la mort                                     
                                     tour_4 = 1;
                                 }
                             } 
                             else if(over_4 == 0)
                             {   
                                 if(tour_4 != 0)
                                 {                                                                                                      
                                    //On effectue les calculs
                                     
                                    //top
                                    rest_top_4 = rest_top_4 - Mem_4[i_4];
                                    clap_top_4 = -rest_top_4;
                                     
                                    //menu
                                    rest_menu_4 = rest_menu_4 + Mem_4[i_4];
                                    clap_menu_4 = marge_menu_4 - rest_menu_4;
                                     
                                    //bottom
                                    rest_bottom_4 = rest_bottom_4 + Mem_4[i_4];
                                    clap_bottom_4 = marge_bottom_4 - rest_bottom_4;  
                                                                          
                                     
                                    go_to_top_4.style.marginLeft = rest_top_4 + 'px';
                                    go_to_top_4.style.clip = 'rect( 0px, 45px, 45px,' + clap_top_4 + 'px)'; 

                                    go_to_menu_4.style.marginTop = rest_menu_4 + 'px';
                                    go_to_menu_4.style.clip = 'rect( 0px, 145px,' + clap_menu_4 + 'px, 0px)';
                                     
                                    go_to_bottom_4.style.marginLeft = rest_bottom_4 + 'px';
                                    go_to_bottom_4.style.clip = 'rect( 0px,' + clap_bottom_4 + 'px , 45px, 0px)';  
                                               
                                    //alert(rest_top_4); 
                                     
                                    if(i_4 != 0)
                                    i_4--; 
                                    
                                    if(rest_bottom_4 == 895)   
                                    {
                                        clearInterval(intervalID_4);
                                        tour_4 = 0;
                                        process_4 = 0;
                                    }                                                                 
                                 }
                             }
                             else if(over_4 == 'debug')
                             {
                                 clearInterval(intervalID_4);
                                 tour_4 = 0;
                                 process_4 = 0;
                             }                                 
                          }, 0); 
                       }
                    }
                 };              
             
                 var list_box_bouton = document.querySelector('#conteneur_affichage_de_personnes');
       
                 list_box_bouton.addEventListener('mouseover',function_box_list,false);      
                 list_box_bouton.addEventListener('mouseout',function_box_list,false);               
                 
             })();

//Fonction de mouvement des images de la list.
            (function()
            {
                 var process_pub_4 = 0, sens_4 = 0, count_4 = 0, decal_4 = 0,constant_4 = 10, limit_left_4 = 120, limit_right_4 = 0, clap_1eft_4 = 0, clap_right_4 = 895;
                 var function_photo_list = function(e_4)
                 {                       
                     if(e_4 != null)
                     {
                         if(e_4.type == 'mousedown' || e_4.type == 'keydown')
                         {
                              if(e_4.target.id == 'go_to_top_4' || e_4.keyCode == 39)                                                        
                              sens_4 = 'left';
                              if(e_4.target.id == 'go_to_bottom_4' || e_4.keyCode == 37)
                              sens_4 = 'right';   
                         }
                         if(e_4.type == 'mouseup' || e_4.type == 'keyup')                                                          
                         sens_4 = 0;
                     }                    
                 
                     if(process_pub_4 == 0)
                     {
                         //Une fois que l'on est entré, on en ressort plus.
                         process_pub_4 = 1;
               
                         var intervalID_pub_4 = setInterval( function()
                         {
                              if(sens_4 == 'left' && count_4 != limit_left_4)
                              {
                                  count_4++;
                                  decal_4 += constant_4;   
                                  
                                  clap_1eft_4 += constant_4;
                                  clap_right_4 += constant_4;
                                  
                                  conteneur_affichage_de_personnes_defil.style.marginLeft = '-' + decal_4 + 'px';                                                                    
                                  conteneur_affichage_de_personnes_defil.style.clip = 'rect( 0px,' + clap_right_4 + 'px, 85px,' + clap_1eft_4 + 'px)';
                              } 
                              if(sens_4 == 'right' && count_4 != limit_right_4)
                              {
                                  count_4--;
                                  decal_4 -= constant_4;   
                                  
                                  clap_1eft_4 -= constant_4;
                                  clap_right_4 -= constant_4;
                                  
                                  conteneur_affichage_de_personnes_defil.style.marginLeft = '-' + decal_4 + 'px';                                                                    
                                  conteneur_affichage_de_personnes_defil.style.clip = 'rect( 0px,' + clap_right_4 + 'px, 85px,' + clap_1eft_4 + 'px)';
                              }
                         }, 0 );
                     }
                 };
                         
                         
                 var go_to_top_4 = document.querySelector('#go_to_top_4');
                 var go_to_bottom_4 = document.querySelector('#go_to_bottom_4');                 
                 
                 go_to_top_4.addEventListener('mousedown',function_photo_list,false);
                 go_to_top_4.addEventListener('mouseup',function_photo_list,false);
                 
                 go_to_bottom_4.addEventListener('mousedown',function_photo_list,false);
                 go_to_bottom_4.addEventListener('mouseup',function_photo_list,false);
                 
                 document.addEventListener('keydown',function_photo_list,false); 
                 document.addEventListener('keyup',function_photo_list,false); 
            })();