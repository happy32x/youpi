<?php
    session_start();
    header("Content-Type: text/html; charset=iso-8859-1");

    //réception des donnees
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['tape_name'] = $_POST['tape_name'];

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

    //On selectionne tous les noms qui se trouve dans la table utilisateur
    $reqa = $bdd->prepare('SELECT name FROM utilisateur WHERE name != :user_name');
    $reqa->execute(array('user_name' => $_SESSION['name']));

    while ($data = $reqa->fetch())
    {
         if (stripos($data['name'], $_SESSION['tape_name']) === 0)
         {
              echo '<div id="Mega_search_result_element" onclick="KillResults(this);">
                        <img title="' . $data['name'] . '" src="utilisateur/' . $data['name'] . '/' . $data['name'] . '.jpg" id="Mega_search_result_element_photo"/>
                        <span>' . $data['name'] . '</span>
                    </div>';
         }
    }

    $reqa->closeCursor();
?>
