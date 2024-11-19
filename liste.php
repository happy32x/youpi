<?php
    session_start();
    header("Content-Type: text/html; charset=iso-8859-1");

    //réception des donnees
    $_SESSION['name'] = $_POST['name'];

    $host = $_SESSION['host'];
    $dbname = $_SESSION['dbname'];
    $root = $_SESSION['root'];
    $pass = $_SESSION['pass'];

    //Ouverture de la base de donnees
    try
		{
			  $bdd = new PDO("mysql:host=$host;dbname=$dbname", $root, $pass);
		}
		catch (Exception $e)
		{
			  die('Erreur : ' . $e->getMessage());
		}

    $ryu = $bdd->prepare('SELECT * FROM utilisateur WHERE name != :user_name');
    $ryu->execute(array('user_name' => $_SESSION['name']));

    while ($dyu = $ryu->fetch())
    {
         //On converti les genres (1 -> malle - 0 -> femelle)
         if($dyu['genre'] == 1)
         $dyu['genre'] = 'male';
         else
         $dyu['genre'] = 'femelle';

         if($dyu['status'] == 1){
              echo '<div class="filter_ultra_content_liste_content_element" onclick="message_nouveau_arrivant(this);">
                        <img class="filter_ultra_content_liste_content_element_snap" title="'.$dyu['name'].'" src="utilisateur/'.$dyu['name'].'/'.$dyu['name'].'.jpg"/>
                        <img class="filter_ultra_content_liste_content_element_snap_genre" src="images/'.$dyu['genre'].'.png">
                        <p class="filter_ultra_content_liste_content_element_name">'.$dyu['name'].'<br><strong>'.$dyu['classe'].'</strong></p>
                    </div>';
         }
         else{
              echo '<div class="filter_ultra_content_liste_content_element" onclick="message_nouveau_arrivant(this);">
                        <img class="filter_ultra_content_liste_content_element_snap_offline" title="'.$dyu['name'].'" src="utilisateur/'.$dyu['name'].'/'.$dyu['name'].'.jpg"/>
                        <img class="filter_ultra_content_liste_content_element_snap_genre" src="images/'.$dyu['genre'].'.png">
                        <p class="filter_ultra_content_liste_content_element_name">'.$dyu['name'].'<br><strong>'.$dyu['classe'].'</strong></p>
                    </div>';
         }
    }
    $ryu->closeCursor();
?>
