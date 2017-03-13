<?php

    //Ce fichie inclu les liens vers les fichiers qui permettront à l'administrateur de :

	/*
    
    - Gérer les coordonnées du restaurant 
    - Modifier la photo de couverture 
    - Gérer les recettes (titre + contenu + photo + date & heure + id auteur) 
    - Traiter les réponses du formulaire de contact en marquant comme lu une réponse (par défaut, non lu)(lien:contact_treatment)
	- Créer un nouvel utilisateur (lien)
    */

	//inclure le footer



session_start();
//require_once 'inc/connect.php'; PAS DE CONNEXION A LA BASE DE DONNEE NECESSAIRE


if(!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] == false || $_SESSION['role'] != 'role_admin'){
// Redirection vers la page de connexion si non connecté
header('Location: ../login.php');
die;
}

/*************************************
 | Definition des vaiables |
**************************************/
//--- Titre de la page (définie dans le header)
$title = 'Section d\'Administration';

//-- Si l'on veut afficher sur la page une bienvenue à l'admin avec son nom et son prénom
$_SESSION['prenom'] = $lastname;
$_SESSION['nom'] = $firstname;



?>
<?php
//Intégration du Header
require_once '../../inc/header.php';
?>
 <br>
 <br>
<h1>SECTION D'ADMINISTRATION</h1>
 <br>
 <br>
<h2>Bonjour <?=$firstname.' '.$lastname.',' ?> Bienvenu(e) dans la section d'Administration</h2>
 <h3>Ici vous pourrez :</h3>
<div>
    <ul>
       
        <li>
            <a href="change_restinfo.php">Modifier les coordonnées du Restaurant ou Changer la photo de couverture</a>
        </li>
            
        <li>
            <a href="delete_recipe.php">Supprimer des recettes</a>
        </li>
              
        <li>
            <a href="add_recipe.php">Ajouter des recettes</a>
        </li>
        <li>
            <a href="add_user.php">Créer un Utilisateurs</a>
        </li>
        <li>
            <a href="contact_treatment.php">Traiter les Formulaires de Contact</a>
        </li>
        <li>
            <a href="recipe_admin.php">Gérer les recettes</a>
        </li>
        <li>
            <a href="../logout.php">Vous Déconnecter</a>
        </li>

    </ul>
 </div>


<?php
			
//Intégration du footer
require_once '../../inc/footer.php';
			
?>


