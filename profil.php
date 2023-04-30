<?php 
  include('suppressionPublication.php');

  function count_Followers($id){
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    $followers = $pdo->prepare('SELECT count(*) FROM Followers WHERE user_id = ?');
    $followers->execute(array($id));
    $num = $followers->fetchColumn();
    return (string) $num;
}


  function is_Logged_User_Subscribed($id){
    // si la fonction est appelée c que id != userLoggedID donc pas besoin de revérifier
    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    $followers = $pdo->prepare('SELECT count(*) FROM Followings WHERE following_id = ? AND user_id = ?');
    $followers->execute(array($id, $_SESSION['LOGGED_ID']));
    $num = $followers->fetchAll();
    return ($num > 0 );
  }
  
  function display_Profil($id){

    $pdo = new PDO('mysql:host=localhost;dbname=instapets', 'root', 'root');
    // on recupere l'utilisateur en parametres
    $Recup = $pdo->prepare('SELECT * FROM Users WHERE user_id = ?');
    $Recup->execute(array($id));
    // on vérifie que l'id correspond bien à un utilisateur
    if($Recup->rowCount()==0){/*message erreur profil inexistant*/} 
    $pseudo_profil = $Recup->fetch()['user_pseudo'];

    //pour test admin car sinon les false ne passent pas dans un fetch tout court
    $result = $Recup->fetch();
    $isAdmin = $result ? $result['user_admin'] : false;

    // ... peut etre recuperer d'autres infos selon nos preferences a voir +tard
    $affichageH2 ="&commat;"; //'@'
    if($id != $_SESSION['LOGGED_ID']){
	$affichageH2 .= $pseudo_profil;
	if($isAdmin) {$affichageH2.=" &#9733;"; }// petie étoile de certification ;)
    } else{
      	$affichageH2 .= "Moi";
	if($isAdmin){$affichageH2.=" &#9733;"; }
    }
 
    $html = "<html lang=\"fr\"> <head><meta  http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>InstaPets</title><link href=\"profil.css\" rel=\"stylesheet\"></head><body>
    <h2>".$affichageH2."</h2><h3>Publications</h3><main>";

        
    // afficher nombre d'abonnes et abonnement corespondants à $id EN PARAMETRES DE LA FONCTION

    $html.="<p>".count_Followers($id)." abonné(s)</p>";

    // afficher les posts du profil
		$stmt2 = $pdo->prepare('SELECT Posts.post_title, Posts.post_content, Posts.post_picture, Users.user_pseudo FROM Posts INNER JOIN Users ON Posts.user_id = ? ORDER BY DESC LIMIT 20');
		$stmt2->execute([$id]);
		$posts = $stmt2->fetchAll();
		foreach ($posts as $post) {
				$html .= "<article><h3>" . htmlspecialchars($post['post_title']) . "</h3><p>" . htmlspecialchars($post['post_picture']) . "</p><p>" . htmlspecialchars($post['post_content']) .
        "</p><p class=\"meta\">Posted by" . htmlspecialchars($post['user_pseudo'])."</p></article>";// verifer si conenu et picture ne sont pas null ???
        if($isAdmin){
          $html.=delete(); // a créer
        } 
		}
	// en dessous je vais m'occuper d'un peu réorganiser tout ça je fais une petite pause
	  $html = $html. "</main><aside><form action=\"index.php?action=search\" method=\"post\"><input type=\"search\" name=\"q\" placeholder=\"Rechercher\">
  		<input type=\"submit\" value=\"Ok !\"></form> 
        	<ul>
        	<li><a href=\"index.php?action=publier\">Publier</a></li>
        	<li><a href=\"index.php?action=profil&amp;id=".$_SESSION['LOGGED_ID']."\">MonCompte</a></li>
        	</ul>
       		</aside>";
        if($id != $_SESSION['LOGGED_ID']){
            if(is_Logged_User_Subscribed($id)){
              $html .= "<li><a href=\"index.php?action=unfollow&ampid=;".$id."\">Se désabonner</a></li>";
            }else{
              $html .= "<li><a href=\"index.php?action=subscribe&ampid=;".$id."\">Suivre</a></li>";
            }
        }else{
          $html .=  "<li><a href=\"index.php?action=publier\">Ajouter une nouvelle publication></a></li>
          <li><a href=\"index.php?action=modifier\">Modifier mes infos></a></li>";
        }

    $html .="</body></html>";
 
    return $html;
    }
    ?>
    

    
    
