<?php
    session_start();
    include_once('inscription.php');
    include_once('bienvenue.php');
    include_once('traitementInscription.php');
    include_once('connexion.php');
    include_once('traitementConnexion.php');
    include_once('felicitations.php');
    include_once('traitementModification.php');
   if(!isset($_SESSION['LOGGED_MDP'])){
        if(isset($_GET['action'])){
            switch($_GET['action']){
                case 'bienvenue' :
                    $fonction = display_Bienvenue();
                    $title = "Bienvenue sur InstaPets";
                    break;
                case 'inscription' :
                    $fonction = print_form(false);
                    $title = "Inscription";
                    break;
                case 'connexion' :
                    $fonction = print_Login();
                    $title = "Connexion";
                    break;
                case 'sauvegarder' :
                    if(inscriptionValidee()){
                        $fonction =felicitations(false);
                        $title = "Inscription Réussie";
                        break;
                    }else{
                        $fonction = print_form(false);
                        $title = "Inscription";
                        break;
                        }
               case 'check' :
                    if(connexion_check()){
                        $fonction = display_Accueil();
                        $title = "Mon fil d'actualité";
                        break;
                    }else {
                        $fonction = print_Login();
                        $title = "Connexion";
                        break;
                    }
                default : $fonction = display_Bienvenue();$title = "Bienvenue sur InstaPets";
            }
        }else{
            $fonction = display_Bienvenue();
            $title = "Bienvenue sur InstaPets";
        }
   } else {
    if(isset($_GET['action'])){
        switch($_GET['action']){
            case 'modifier' :
                $fonction = print_form(true);
                $title = "Modification des informations";
                break;
            case 'update' :
                if(modificationValidee()){
                    $fonction =felicitations(true);
                    $title = "Modifications des informations enregistrée";
                    break;
                }else{
                    $fonction = print_form(true);
                    break;
                }
                
            default : $fonction = "EN CONSTRUCTION";
        }
    }else{
        $fonction = "EN CONSTRUCTION";
    }
   }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php  echo $title ?></title>
</head>
<body>
<h1> Insta Pets</h1>
<main><?php echo $fonction?></main>
<footer>
		<p>&copy; 2023 InstaPets</p>
        <p>KACI Amel & PERRIER-BABIN Ludivine</p>
</footer>
</body>
</html>