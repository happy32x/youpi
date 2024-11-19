//Fonction de mouvement des boutons droit.
            (function()
            {
                var Mem_2 = [45], i_2 = 0, transfert_2 = 0, process_2 = 0, buffer_2 = 0, over_2 = 0, tour_2 = 0;

                var rest_top_2 = 45, clap_top_2 = 0, marge_top_2 = 45, hauteur_top_2 = 45;
                var rest_bottom_2 = 600, clap_bottom_2 = 0, marge_bottom_2 = 600, hauteur_bottom_2 = 45;
                var rest_menu_2 = -45, clap_menu_2 = 0, marge_menu_2 = 45, hauteur_menu_2 = 45;

                var relatedTarget_2 = 0;
                var function_box_droit = function(e_2)
                {     
                    
                    e_2 = e_2 || window.event;
                    relatedTarget_2 = e_2.relatedTarget || e_2.fromElement;
    
                    while (relatedTarget_2 != pub_contener_vertical_droit && relatedTarget_2.nodeName != 'BODY' && relatedTarget_2 != document)
                    relatedTarget_2 = relatedTarget_2.parentNode;

                    //alert('Ta mère pond !!!');
                    
                    if (relatedTarget_2 != pub_contener_vertical_droit) 
                    {
                       if(e_2.type == 'mouseover')
                       over_2 = 1;
                                                           
                       else //if(e_2.type == 'mouseout')
                       {
                           if(over_2 == 1)
                           over_2 = 0;
                           else
                           over_2 = 'debug';
                       }
                              
                    
                       if(process_2 == 0)
                       {
                          process_2 = 1;
                          var intervalID_2 = setInterval( function()
                          {   
                              if(over_2 == 1)
                              { 
                                 if(rest_top_2 > 0)   
                                 {
                                     //Debut de la Zone de la mort
                                     i_2++; 
                                              
                                     if(Mem_2[i_2] == null)
                                     {
                                         i_2--;          
                                         //On travaille sur le nombre                                                                            
                                         transfert_2 = Mem_2[i_2]/2;
                                         buffer_2 = buffer_2 + ( transfert_2 - parseInt(transfert_2) );
                                      
                                         if(buffer_2 == 1)
                                         {
                                              transfert_2 = parseInt(transfert_2) + buffer_2;
                                              buffer_2 = 0;   
                                         }                                      
                                          
                                         i_2++;
                                         transfert_2 = parseInt(transfert_2);
                                         Mem_2[i_2] = transfert_2;
                                      
                                         if(Mem_2[i_2] == 0)
                                         {
                                             Mem_2[i_2] = 1;  
                                             buffer_2 = 0; 
                                         }                                             
                                     }                                                                                                                               

                                     //On effectue les calculs
                                     
                                     //top
                                     rest_top_2 = rest_top_2 - Mem_2[i_2];
                                     clap_top_2 = marge_top_2 - rest_top_2;
                                     clap_top_2 = hauteur_top_2 - clap_top_2;
                                     
                                     //menu
                                     rest_menu_2 = rest_menu_2 + Mem_2[i_2];
                                     clap_menu_2 = -rest_menu_2;
                                     
                                     //bottom
                                     rest_bottom_2 = rest_bottom_2 - Mem_2[i_2];
                                     clap_bottom_2 = marge_bottom_2 - rest_bottom_2;
                                     
                                     
                                     //On applique les résultats
                                     
                                     //top
                                     go_to_top_2.style.marginTop = '-' + rest_top_2 + 'px';
                                     go_to_top_2.style.clip = 'rect( ' + clap_top_2 + 'px, 45px, 45px, 0px)';                                                                              
                                     
                                     //menu
                                     go_to_menu_2.style.marginLeft = rest_menu_2 + 'px';
                                     go_to_menu_2.style.clip = 'rect( 0px, 45px, 145px,' + clap_menu_2 + 'px)';
                                     
                                     //bottom
                                     go_to_bottom_2.style.marginTop = rest_bottom_2 + 'px';
                                     go_to_bottom_2.style.clip = 'rect( 0px, 45px,' + clap_bottom_2 + 'px, 0px)';

                                     //alert(rest_top_2);
                                  
                                     if(rest_top_2 == 0)   
                                     {
                                          clearInterval(intervalID_2);                                          
                                          buffer_2 = 0;
                                          transfert_2 = 0; 
                                          tour_2 = 0;
                                          process_2 = 0;
                                     } 
                                     //Fin de la Zone de la mort                                     
                                     tour_2 = 1; 
                                 }
                             } 
                             else if(over_2 == 0)
                             {                                    
                                 if(tour_2 != 0)
                                 {                                                                                                      
                                    //On effectue les calculs
                                     
                                    //top
                                    rest_top_2 = rest_top_2 + Mem_2[i_2];
                                    clap_top_2 = marge_top_2 - rest_top_2;
                                    clap_top_2 = hauteur_top_2 - clap_top_2;
                                     
                                    //menu
                                    rest_menu_2 = rest_menu_2 - Mem_2[i_2];
                                    clap_menu_2 = -rest_menu_2;
                                     
                                    //bottom
                                    rest_bottom_2 = rest_bottom_2 + Mem_2[i_2];
                                    clap_bottom_2 = marge_bottom_2 - rest_bottom_2;  
                                     
                                    go_to_top_2.style.marginTop = '-' + rest_top_2 + 'px';
                                    go_to_top_2.style.clip = 'rect( ' + clap_top_2 + 'px, 45px, 45px, 0px)'; 
                                 
                                    go_to_menu_2.style.marginLeft = rest_menu_2 + 'px';
                                    go_to_menu_2.style.clip = 'rect( 0px, 45px, 145px,' + clap_menu_2 + 'px)';
                                     
                                    go_to_bottom_2.style.marginTop = rest_bottom_2 + 'px';
                                    go_to_bottom_2.style.clip = 'rect( 0px, 45px,' + clap_bottom_2 + 'px, 0px)';
                                            
                                    //alert(rest_top_2); 
                                     
                                    if(i_2 != 0)
                                    i_2--; 
                                    
                                    if(rest_bottom_2 == 600)   
                                    {
                                        clearInterval(intervalID_2);
                                        tour_2 = 0;
                                        process_2 = 0;
                                    }                                                                         
                                 }
                             }
                             else if(over_2 == 'debug')
                             {
                                 clearInterval(intervalID_2);
                                 tour_2 = 0;
                                 process_2 = 0;
                             }                                 
                          }, 0); 
                       }
                    }
                 };              
             
                 var pub_box_droit = document.querySelector('#pub_contener_vertical_droit');
       
                 pub_box_droit.addEventListener('mouseover',function_box_droit,false);      
                 pub_box_droit.addEventListener('mouseout',function_box_droit,false);               
                 
             })();

//Fonction de defilement des pub droit.
             (function()
             {
                 var Mem_pub_2 = [600], i_pub_2 = 1, transfert_pub_2 = 0, buffer_pub_2 = 0, process_pub_2 = 0;                                
                 var rest_pub_2 = 0 , clap_pub_haut_2 = 0 , clap_pub_bas_2 = 0, marge_pub_2 = 0;
                 var over_up_2 = 'null', delai_2 = 0, term_2 = 1, sens_2 = 'up', fini_2 = 1;  
                 
                 var function_pub_droit = function(e_2)
                 {    
                      if(e_2 != null)
                      {
                         if(e_2.target.id == 'go_to_top_2' || e_2.keyCode == 38)
                         {
                             over_up_2 = 1;
                             delai_2 = 0;
                             if(fini_2 == 1)
                             {
                                 sens_2 = 'up';
                                 i_pub_2 = 1;
                                 term_2 = 1;
                             }
                             if(fini_2 == 0)
                             {
                                 if(sens_2 == 'up')
                                 term_2 = 1;
                                 if(sens_2 == 'down')
                                 term_2 = 0;
                             }
                         }                                
                     
                         if(e_2.target.id == 'go_to_bottom_2' || e_2.keyCode == 40)
                         {
                             over_up_2 = 0;
                             delai_2 = 0;
                             if(fini_2 == 1)
                             {
                                 sens_2 = 'down';
                                 i_pub_2 = 1;
                                 term_2 = 1;
                             }
                             if(fini_2 == 0)
                             {
                                 if(sens_2 == 'up')
                                 term_2 = 0;
                                 if(sens_2 == 'down')
                                 term_2 = 1;
                             }
                         
                             //else
                             //over_up = 'debug';
                         }                  
                     }                     
                 
                     if(process_pub_2 == 0)
                     {
                         //Une fois que l'on est entré, on en ressort plus.
                         process_pub_2 = 1;
               
                         var intervalID_pub_2 = setInterval( function()
                         {
                            if(delai_2 != 500)
                            delai_2++;
                            else if(delai_2 == 500)
                            term_2 = 1;                                                    
                             
                            if(over_up_2 == 1 || (delai_2 == 500 && sens_2 == 'up'))
                            {
                                if(rest_pub_2 != -3000)
                                {      
                                    if(term_2 == 1)
                                    {
                                       fini_2 = 0;
                                        
                                       //Ce calcul ne s'effectue qu'uniquement dans cette section
                                       if(Mem_pub_2[i_pub_2] == null)
                                       {
                                           i_pub_2--;  
                                           
                                           //On travaille sur le nombre                                                                            
                                           transfert_pub_2 = Mem_pub_2[i_pub_2]/2;
                                           buffer_pub_2 = buffer_pub_2 + ( transfert_pub_2 - parseInt(transfert_pub_2) );
                                      
                                           if(buffer_pub_2 == 1)
                                           {
                                                transfert_pub_2 = parseInt(transfert_pub_2) + buffer_pub_2;
                                                buffer_pub_2 = 0;   
                                           }                                      
                                          
                                           i_pub_2++;
                                           transfert_pub_2 = parseInt(transfert_pub_2);
                                           Mem_pub_2[i_pub_2] = transfert_pub_2;
                                      
                                           if(Mem_pub_2[i_pub_2] == 0)
                                           {
                                               Mem_pub_2[i_pub_2] = 1;  
                                               buffer_pub_2 = 0; 
                                           }      
                                       }                          
                         
                                       //On bouf grace à i_pub
                                       rest_pub_2 = rest_pub_2 - Mem_pub_2[i_pub_2];
                                       clap_pub_haut_2 = marge_pub_2 - rest_pub_2;
                                       clap_pub_bas_2 = clap_pub_haut_2 + 600;       
                                        
                                       pub_actuel_2.style.marginTop = rest_pub_2 + 'px';
                                       pub_actuel_2.style.clip = 'rect( ' + clap_pub_haut_2 + 'px, 145px,' + clap_pub_bas_2 + 'px, 0px)';
                                                            
                                       if(i_pub_2 == 11)   
                                       {                                           
                                            i_pub_2 = 1;
                                            over_up_2 = 'null';
                                            delai_2 = 0;
                                            fini_2 = 1;
                                       }  
                                       else
                                       i_pub_2++;
                                    }
                                    else if(term_2 == 0)
                                    {
                                        delai_2 = 0;
                                        i_pub_2--;
                                            
                                        //On bouf grace à i_pub
                                        rest_pub_2 = rest_pub_2 - Mem_pub_2[i_pub_2];
                                        clap_pub_haut_2 = marge_pub_2 - rest_pub_2;
                                        clap_pub_bas_2 = clap_pub_haut_2 + 600;
                                        
                                        pub_actuel_2.style.marginTop = rest_pub_2 + 'px';
                                        pub_actuel_2.style.clip = 'rect( ' + clap_pub_haut_2 + 'px, 145px,' + clap_pub_bas_2 + 'px, 0px)';
                                            
                                        if(i_pub_2 == 1) 
                                        {                                           
                                             over_up_2 = 'null';
                                             term_2 = 1;
                                             fini_2 = 1;
                                        }  
                                    }
                                }
                                else
                                {
                                    sens_2 = 'down';
                                    over_up_2 = 'null';
                                }
                             }
                             else if(over_up_2 == 0 || (delai_2 == 500 && sens_2 == 'down'))
                             {        
                                 if(rest_pub_2 != 0)
                                 {
                                     if(term_2 == 1)
                                     {
                                         fini_2 = 0;                                                               
                         
                                         //On bouf grace à i_pub
                                         rest_pub_2 = rest_pub_2 + Mem_pub_2[i_pub_2];
                                         clap_pub_haut_2 = marge_pub_2 - rest_pub_2;
                                         clap_pub_bas_2 = clap_pub_haut_2 + 600; 
                                         
                                         pub_actuel_2.style.marginTop = rest_pub_2 + 'px';
                                         pub_actuel_2.style.clip = 'rect( ' + clap_pub_haut_2 + 'px, 145px,' + clap_pub_bas_2 + 'px, 0px)';                                                             

                                         if(i_pub_2 == 11)   
                                         {                                           
                                             i_pub_2 = 1;
                                             over_up_2 = 'null';
                                             delai_2 = 0;
                                             fini_2 = 1;
                                         }  
                                         else
                                         i_pub_2++;
                                     }
                                     else if(term_2 == 0)
                                     {
                                         delai_2 = 0;
                                         i_pub_2--;
                                         
                                         //On bouf grace à i_pub
                                         rest_pub_2 = rest_pub_2 + Mem_pub_2[i_pub_2];
                                         clap_pub_haut_2 = marge_pub_2 - rest_pub_2;
                                         clap_pub_bas_2 = clap_pub_haut_2 + 600;     
                                         
                                         pub_actuel_2.style.marginTop = rest_pub_2 + 'px';
                                         pub_actuel_2.style.clip = 'rect( ' + clap_pub_haut_2 + 'px, 145px,' + clap_pub_bas_2 + 'px, 0px)'; 
                                         
                                         if(i_pub_2 == 1) 
                                         {                                           
                                             over_up_2 = 'null';
                                             term_2 = 1;
                                             fini_2 = 1;
                                         }  
                                     }
                                 }
                                 else
                                 sens_2 = 'up';
                             }
                         }, 20 );
                         
                         if(ephemere_2 != 'null')
                         {
                             clearInterval(ephemere_2);
                             ephemere_2 = 'null';
                         }
                     }
                 };
                 
                 var go_to_top_2 = document.querySelector('#go_to_top_2');
                 var go_to_bottom_2 = document.querySelector('#go_to_bottom_2');                 
                 
                 go_to_top_2.addEventListener('click',function_pub_droit,false);
                 go_to_bottom_2.addEventListener('click',function_pub_droit,false);
                 
                 document.addEventListener('keydown',function_pub_droit, false); 
                 var ephemere_2 = setInterval(function_pub_droit , 1);
             })();