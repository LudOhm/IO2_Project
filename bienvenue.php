<?php function display_Bienvenue(){
    $html =  "<html lang=\"fr\"> 
    <head>
    <meta  http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>InstaPets</title> 
    <link href=\"accueil.css\" rel=\"stylesheet\">
    </head>
    <body>
    <header>
    </header>
    <main>
    <h2>Bienvenue sur Instapets, le réseau social pour les détenteurs d'animaux qui veulent partager 
    et communiquer avec les autres détenteurs d'animaux qui partagent un intérêt commun.</h2><br>
    <li><a href=\"index.php?action=inscription\">Rejoignez-nous!</a></li><li><a href=\"index.php?action=connexion\">J'ai déjà un compte!</a></li>";

    return $html;
}
?>