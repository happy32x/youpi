<script>

(function(){

    var searchElement = document.getElementById('Mega_search_input'),
        results = document.getElementById('Mega_search_result'),
        searchButton = document.getElementById('Mega_search_bouton'),
        previousRequest,
        previousValue = searchElement.value;

    function getResults(tape_name)
    {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function()
                                 {
                                      if (xhr.readyState == 4 && xhr.status == 200)
                                      {
                                           results.innerHTML = xhr.responseText;

                                           if(xhr.responseText == '')
                                           backend();
                                           else
                                           frontend();
                                      }
                                 };
        //Assignation des variables
        var name = '<?php echo $_SESSION['name'] ?>';

        xhr.open("POST", "auto_completion.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("name="+name+"&tape_name="+tape_name);

        return xhr;
    }

    searchElement.addEventListener('keyup', function(e) //e.keyCode == 13
                                            {
                                                if (searchElement.value != previousValue)
                                                {
                                                    previousValue = searchElement.value;

                                                    if (previousRequest && previousRequest.readyState < 4)
                                                    previousRequest.abort();

                                                    previousRequest = getResults(previousValue);
                                                }
                                            }, false);

    searchElement.addEventListener('click', function(e)
                                            {
                                                if(results.style.minHeight != '70px' && searchElement.value && results.innerHTML != '')
                                                frontend();
                                            }, false);

    searchButton.addEventListener('click', function(e)
                                           {
                                                if(results.style.minHeight != '70px' && searchElement.value && results.innerHTML != '')
                                                frontend();
                                           }, false);

})();

function KillResults(t)
{
    message_nouveau_arrivant(t);
    backend();
}

$("#Mega_search_input").blur(function(e){
    backend();
});
$("#Mega_search_bouton").blur(function(){
    backend();
});

function frontend(){
    var msr = document.getElementById('Mega_search_result');
    msr.style.borderTop = '1px solid black';
    msr.style.maxHeight = '400px';
    msr.style.minHeight = '70px';
    msr.style.boxShadow = '1px 1px 10px gray';
}
function backend(){
    var msr = document.getElementById('Mega_search_result');
    msr.style.borderTop = '0px';
    msr.style.maxHeight = '0px';
    msr.style.minHeight = '0px';
    msr.style.boxShadow = '0px';
}

</script>
