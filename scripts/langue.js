(function()
             {
                 var function_langue = function(e)
                                       {          
                                          if(e.target.id != 'liste_de_langue' && e.target.parentNode.id != 'liste_de_langue')
                                          {
            
                                              var body = document.querySelector('body');
                                              var header = document.querySelector('header');  

                                              var trans = document.createElement('div'); 
                                              var lang = document.createElement('div');
                                                
                                              trans.className = 'papier_transparent';
                                              lang.id = 'liste_de_langue';            
                                                
                                              trans.addEventListener('click',
                                                                     function()
                                                                     {
                                                                         trans.parentNode.removeChild(trans);
                                                                         lang.parentNode.removeChild(lang);
                                                                     }                                                                       
                                                                     ,false);
                           
                
                                              body.insertBefore(trans, header);    
                                              language_button.insertBefore(lang, language_button.firstChild);
                                          }
                                       };         
                       
                var language_button = document.querySelector('#language_button');
                language_button.addEventListener('click',function_langue,false);   
            })();


