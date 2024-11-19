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

  	$reponse = $bdd->prepare('SELECT * FROM ' . $_SESSION['name'] . '_messages WHERE nouveau = :old');
    $reponse->execute(array('old' => 0));

    $_SESSION['messages'] = 0;

	  while ($donnees = $reponse->fetch())
    {
         $_SESSION['messages']++;
	  }

    $reponse->closeCursor();

    echo $_SESSION['messages'];
?>
