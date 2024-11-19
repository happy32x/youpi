<script>

(function(){
      var RefresheFilterBouton = document.getElementsByClassName('filter_ultra_content_liste_content_bouton'),
          RefresheFilterContent = document.getElementsByClassName('filter_ultra_content_liste_content_bas'),
          noTwoTime = 0;


      function userResults(){
         //On efface l'écran
         RefresheFilterContent[0].innerHTML = '';
         //On charge l'image wait
         $('.filter_ultra_content_liste_content_wait').show(100);

         var xhr = new XMLHttpRequest();
         xhr.onreadystatechange = function()
                                  {
                                       if (xhr.readyState == 4 && xhr.status == 200)
                                       {
                                           //On recupère les résulats
                                           var receptResultText = xhr.responseText;
                                           //On affiche le résultat
                                           $(".filter_ultra_content_liste_content_bas").prepend(receptResultText);
                                           //On enleve l'image wait
                                           $('.filter_ultra_content_liste_content_wait').hide(100);
                                           //On ouvre la porte
                                           noTwoTime = 0;
                                       }
                                  };
         //Assignation des variables
         var name = '<?php echo $_SESSION['name'] ?>';

         xhr.open("POST", "liste.php", true);
         xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
         xhr.send("name="+name);
      }

      RefresheFilterBouton[0].addEventListener('click', function(e) //e.keyCode == 13
                                              {
                                                  if (noTwoTime == 0)
                                                  {
                                                      //On ferme la porte
                                                      noTwoTime = 1;
                                                      userResults();
                                                  }
                                              }, false);
})();

</script>
