<script>

(function(){

    var searchElement = document.getElementById('Mega_search_input'),
        results = document.getElementById('Mega_search_result'),
        selectedResult = -1, // Permet de savoir quel résultat est sélectionné : -1 signifie "aucune sélection"
        previousRequest, // On stocke notre précédente requête dans cette variable
        previousValue = searchElement.value; // On fait de même avec la précédente valeur

    function getResults(tape_name) // Effectue une requête et récupère les résultats
    {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function()
                                 {
                                      if (xhr.readyState == 4 && xhr.status == 200)
                                      {
                                            displayResults(xhr.responseText);
                                      }
                                 };

        //Assignation des variables
        var name = '<?php echo $_SESSION['name'] ?>';

        xhr.open("POST", "auto_completion.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("name="+name+"&tape_name="+tape_name);

        return xhr;
    }

    searchElement.addEventListener('keyup', function(e)
                                            {
                                                var divs = results.getElementsByTagName('div');
                                                if (e.keyCode == 38 && selectedResult > -1) // Si la touche pressée est la flèche "haut"
                                                {
                                                    divs[selectedResult--].className = '';

                                                    if (selectedResult > -1) // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
                                                    {
                                                        divs[selectedResult].className = 'result_focus';
                                                    }
                                                }
                                                else if (e.keyCode == 40 && selectedResult < divs.length - 1) // Si la touche pressée est la flèche "bas"
                                                {
                                                    results.style.display = 'block'; // On affiche les résultats

                                                    if (selectedResult > -1) // Cette condition évite une modification de childNodes[-1], qui n'existe pas, bien entendu
                                                    {
                                                        divs[selectedResult].className = '';
                                                    }

                                                    divs[++selectedResult].className = 'result_focus';
                                                }
                                                else if (e.keyCode == 13 && selectedResult > -1) // Si la touche pressée est "Entrée"
                                                {
                                                    chooseResult(divs[selectedResult]);
                                                }
                                                else if (searchElement.value != previousValue) // Si le contenu du champ de recherche a changé
                                                {
                                                    previousValue = searchElement.value;

                                                    if (previousRequest && previousRequest.readyState < 4)
                                                    {
                                                        previousRequest.abort(); // Si on a toujours une requête en cours, on l'arrête
                                                    }

                                                    previousRequest = getResults(previousValue); // On stocke la nouvelle requête
                                                    selectedResult = -1; // On remet la sélection à "zéro" à chaque caractère écrit
                                                }
                                            }, false);

})();

</script>
