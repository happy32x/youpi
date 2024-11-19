<script>
(function(){
   var refresh_connect_process = 0;

   var refresh_user_connect = function() {
        if(refresh_connect_process == 0)
        {
              refresh_connect_process = 1;
              var xhr_connect = new XMLHttpRequest();

              xhr_connect.onreadystatechange = function()
              {
                   if (xhr_connect.readyState == 4 && xhr_connect.status == 200)
                   {
                       var number_connect = xhr_connect.responseText;
                       document.getElementById('person_actual_connect_number').innerHTML = number_connect;                       
                       refresh_connect_process = 0;
                   }
              };
              xhr_connect.open("POST", "total_connect_refresh.php", true);
              xhr_connect.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
              xhr_connect.send();
        }
   };

   var connect_refresh = setInterval( refresh_user_connect , 5000 );
   //clearInterval(time_tohonor);
})();
</script>
