//Fonction de mouvement des boutons gauche.
            (function()
            {
                var Mem = [45], i = 0, transfert = 0, process = 0, buffer = 0, over = 0, tour = 0;

                var rest_top = 45, clap_top = 0, marge_top = 45, hauteur_top = 45;
                var rest_bottom = 600, clap_bottom = 0, marge_bottom = 600, hauteur_bottom = 45;
                var rest_menu = 145, clap_menu = 0, marge_menu = 145, hauteur_menu = 45;

                var relatedTarget = 0;
                var function_box_gauche = function(e)
                {     
                    e = e || window.event;
                    relatedTarget = e.relatedTarget || e.fromElement;
    
                    while (relatedTarget != pub_contener_vertical_gauche && relatedTarget.nodeName != 'BODY' && relatedTarget != document)
                    relatedTarget = relatedTarget.parentNode;

                    if (relatedTarget != pub_contener_vertical_gauche) 
                    {
                       if(e.type == 'mouseover')
                       over = 1;                                                                               
                        
                       else  //if(e.type == 'mouseout')
                       {
                           if(over == 1)
                           over = 0;
                           else
                           over = 'debug';
                       }
                              
                    
                       if(process == 0)
                       {
                          process = 1;
                          var intervalID = setInterval( function()
                          {   
                              if(over == 1)
                              {  
                                  if(rest_top > 0)   
                                  {
                                     //Debut de la Zone de la mort
                                     i++; 
                                              
                                     if(Mem[i] == null)
                                     {
                                         i--;          
                                         //On travaille sur le nombre                                                                            
                                         transfert = Mem[i]/2;
                                         buffer = buffer + ( transfert - parseInt(transfert) );
                                      
                                         if(buffer == 1)
                                         {
                                              transfert = parseInt(transfert) + buffer;
                                              buffer = 0;   
                                         }                                      
                                          
                                         i++;
                                         transfert = parseInt(transfert);
                                         Mem[i] = transfert;
                                      
                                         if(Mem[i] == 0)
                                         {
                                             Mem[i] = 1;  
                                             buffer = 0; 
                                         }                                               
                                     }                                                                                                                               

                                     //On effectue les calculs
                                     
                                     //top
                                     rest_top = rest_top - Mem[i];
                                     clap_top = marge_top - rest_top;
                                     clap_top = hauteur_top - clap_top;
                                     
                                     //menu
                                     rest_menu = rest_menu - Mem[i];
                                     clap_menu = marge_menu - rest_menu;
                                                                          
                                     //bottom
                                     rest_bottom = rest_bottom - Mem[i];
                                     clap_bottom = marge_bottom - rest_bottom;
                                     
                                     
                                     //On applique les résultats
                                     
                                     //top
                                     go_to_top.style.marginTop = '-' + rest_top + 'px';
                                     go_to_top.style.clip = 'rect( ' + clap_top + 'px, 45px, 45px, 0px)';                                                                              
                                     
                                     //menu
                                     go_to_menu.style.marginLeft = rest_menu + 'px';
                                     go_to_menu.style.clip = 'rect( 0px,' + clap_menu + 'px, 145px, 0px)';
                                     
                                     //bottom
                                     go_to_bottom.style.marginTop = rest_bottom + 'px';
                                     go_to_bottom.style.clip = 'rect( 0px, 45px,' + clap_bottom + 'px, 0px)';

                                     //alert(rest_top);
                                  
                                     if(rest_top == 0)   
                                     {
                                          clearInterval(intervalID);                                          
                                          buffer = 0;
                                          transfert = 0; 
                                          tour = 0;
                                          process = 0;
                                     } 
                                     //Fin de la Zone de la mort  
                                     tour = 1; 
                                 }
                             } 
                             else if(over == 0)
                             {          
                                 if(tour != 0)
                                 {
                                    //On effectue les calculs
                                     
                                    //top
                                    rest_top = rest_top + Mem[i];
                                    clap_top = marge_top - rest_top;
                                    clap_top = hauteur_top - clap_top;
                                     
                                    //menu
                                    rest_menu = rest_menu + Mem[i];
                                    clap_menu= marge_menu - rest_menu;
                                     
                                    //bottom
                                    rest_bottom = rest_bottom + Mem[i];
                                    clap_bottom = marge_bottom - rest_bottom;  
                                     
                                   
                                    //On applique les resultats
                                   
                                    go_to_top.style.marginTop = '-' + rest_top + 'px';
                                    go_to_top.style.clip = 'rect( ' + clap_top + 'px, 45px, 45px, 0px)'; 
                                 
                                    go_to_menu.style.marginLeft = rest_menu + 'px';
                                    go_to_menu.style.clip = 'rect( 0px,' + clap_menu + 'px, 145px, 0px)';
                                     
                                    go_to_bottom.style.marginTop = rest_bottom + 'px';
                                    go_to_bottom.style.clip = 'rect( 0px, 45px,' + clap_bottom + 'px, 0px)';
                                          
                                    //alert(rest_top);                                      
                                     
                                    if(i != 0)
                                    i--; 
                                    
                                    if(rest_bottom == 600)   
                                    {
                                        clearInterval(intervalID);
                                        tour = 0;
                                        process = 0;                                         
                                    }                                                                   
                                 }
                             }
                             else if(over == 'debug')
                             {
                                 clearInterval(intervalID);
                                 tour = 0;
                                 process = 0;                                 
                             }                                 
                          }, 0); 
                       }
                    }
                 };              
             
                 var pub_box_gauche = document.querySelector('#pub_contener_vertical_gauche');
       
                 pub_box_gauche.addEventListener('mouseover',function_box_gauche,false);      
                 pub_box_gauche.addEventListener('mouseout',function_box_gauche,false); 
             })();

//Fonction de defilement des pub gauche.
             (function()
             {
                 var Mem_pub = [600], i_pub = 1, transfert_pub = 0, buffer_pub = 0, process_pub = 0;                                
                 var rest_pub = 0 , clap_pub_haut = 0 , clap_pub_bas = 0, marge_pub = 0;
                 var over_up = 'null', delai = 0, term = 1, sens = 'up', fini = 1;  
                 
                 var function_pub_gauche = function(e)
                 {    
                      if(e != null)
                      {
                         if(e.target.id == 'go_to_top' || e.keyCode == 38)
                         {                            
                             over_up = 1;
                             delai = 0;
                             if(fini == 1)
                             {
                                 sens = 'up';
                                 i_pub = 1;
                                 term = 1;
                             }
                             if(fini == 0)
                             {
                                 if(sens == 'up')
                                 term = 1;
                                 if(sens == 'down')
                                 term = 0;
                             }
                         }                                
                     
                         if(e.target.id == 'go_to_bottom' || e.keyCode == 40)
                         {                                  
                             over_up = 0;
                             delai = 0;
                             if(fini == 1)
                             {
                                 sens = 'down';
                                 i_pub = 1;
                                 term = 1;
                             }
                             if(fini == 0)
                             {
                                 if(sens == 'up')
                                 term = 0;
                                 if(sens == 'down')
                                 term = 1;
                             }                         
                         }                  
                     }                     
                 
                     if(process_pub == 0)
                     {
                         //Une fois que l'on est entré, on en ressort plus.
                         process_pub = 1;
               
                         var intervalID_pub = setInterval( function()
                         {
                            if(delai != 500)
                            delai++;
                            else if(delai == 500)
                            term = 1;                                                    
                             
                            if(over_up == 1 || (delai == 500 && sens == 'up'))
                            {
                                if(rest_pub != -3000)
                                {      
                                    if(term == 1)
                                    {
                                       fini = 0;
                                        
                                       //Ce calcul ne s'effectue qu'uniquement dans cette section
                                       if(Mem_pub[i_pub] == null)
                                       {
                                           i_pub--;  
                                           
                                           //On travaille sur le nombre                                                                            
                                           transfert_pub = Mem_pub[i_pub]/2;
                                           buffer_pub = buffer_pub + ( transfert_pub - parseInt(transfert_pub) );
                                      
                                           if(buffer_pub == 1)
                                           {
                                                transfert_pub = parseInt(transfert_pub) + buffer_pub;
                                                buffer_pub = 0;   
                                           }                                      
                                          
                                           i_pub++;
                                           transfert_pub = parseInt(transfert_pub);
                                           Mem_pub[i_pub] = transfert_pub;
                                      
                                           if(Mem_pub[i_pub] == 0)
                                           {
                                               Mem_pub[i_pub] = 1;  
                                               buffer_pub = 0; 
                                           }      
                                       }                          
                         
                                       //On bouf grace à i_pub
                                       rest_pub = rest_pub - Mem_pub[i_pub];
                                       clap_pub_haut = marge_pub - rest_pub;
                                       clap_pub_bas = clap_pub_haut + 600;                                     
                                       pub_actuel.style.marginTop = rest_pub + 'px';
                                       pub_actuel.style.clip = 'rect( ' + clap_pub_haut + 'px, 145px,' + clap_pub_bas + 'px, 0px)';
                                                            
                                       if(i_pub == 11)   
                                       {                                           
                                            i_pub = 1;
                                            over_up = 'null';
                                            delai = 0;
                                            fini = 1;
                                       }  
                                       else
                                       i_pub++;
                                    }
                                    else if(term == 0)
                                    {
                                        delai = 0;
                                        i_pub--;
                                            
                                        //On bouf grace à i_pub
                                        rest_pub = rest_pub - Mem_pub[i_pub];
                                        clap_pub_haut = marge_pub - rest_pub;
                                        clap_pub_bas = clap_pub_haut + 600;                                     
                                        pub_actuel.style.marginTop = rest_pub + 'px';
                                        pub_actuel.style.clip = 'rect( ' + clap_pub_haut + 'px, 145px,' + clap_pub_bas + 'px, 0px)';
                                            
                                        if(i_pub == 1) 
                                        {                                           
                                             over_up = 'null';
                                             term = 1;
                                             fini = 1;
                                        }  
                                    }
                                }
                                else                                
                                {  
                                   sens = 'down';
                                   over_up = 'null';
                                }
                             }
                             else if(over_up == 0 || (delai == 500 && sens == 'down'))
                             {        
                                 if(rest_pub != 0)
                                 {
                                     if(term == 1)
                                     {
                                         fini = 0;                                                               
                         
                                         //On bouf grace à i_pub
                                         rest_pub = rest_pub + Mem_pub[i_pub];
                                         clap_pub_haut = marge_pub - rest_pub;
                                         clap_pub_bas = clap_pub_haut + 600;                                    
                                         pub_actuel.style.marginTop = rest_pub + 'px';
                                         pub_actuel.style.clip = 'rect( ' + clap_pub_haut + 'px, 145px,' + clap_pub_bas + 'px, 0px)';                                                             

                                         if(i_pub == 11)   
                                         {                                           
                                             i_pub = 1;
                                             over_up = 'null';
                                             delai = 0;
                                             fini = 1;
                                         }  
                                         else
                                         i_pub++;
                                     }
                                     else if(term == 0)
                                     {
                                         delai = 0;
                                         i_pub--;
                                         
                                         //On bouf grace à i_pub
                                         rest_pub = rest_pub + Mem_pub[i_pub];
                                         clap_pub_haut = marge_pub - rest_pub;
                                         clap_pub_bas = clap_pub_haut + 600;                                    
                                         pub_actuel.style.marginTop = rest_pub + 'px';
                                         pub_actuel.style.clip = 'rect( ' + clap_pub_haut + 'px, 145px,' + clap_pub_bas + 'px, 0px)'; 
                                         
                                         if(i_pub == 1) 
                                         {                                           
                                             over_up = 'null';
                                             term = 1;
                                             fini = 1;
                                         }  
                                     }
                                 }
                                 else                                 
                                 sens = 'up';                                                                                                     
                             }
                         }, 20 );
                         
                         if(ephemere != 'null')
                         {
                             clearInterval(ephemere);
                             ephemere = 'null';
                         }
                     }
                 };
                 
                 var go_to_top = document.querySelector('#go_to_top');
                 var go_to_bottom = document.querySelector('#go_to_bottom');                 
                 
                 go_to_top.addEventListener('click',function_pub_gauche,false);
                 go_to_bottom.addEventListener('click',function_pub_gauche,false);
                 
                 document.addEventListener('keydown',function_pub_gauche, false); 
                 var ephemere = setInterval(function_pub_gauche , 1);
             })();