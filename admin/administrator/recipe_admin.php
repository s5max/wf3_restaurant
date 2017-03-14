<?php

	//inclure le header

	//SELECT * recipes	ORDER BY DESC
	//fetchAll

session_start(); // Permet de démarrer la session
require_once '../../inc/connect.php';


if(!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] == false || $_SESSION['role'] != 'role_admin'){
// Redirection vers la page de connexion si non connecté
header('Location: ../login.php');
die;
}

$errors = [];
$post = []; // Contiendra les données épurées
$title = 'Liste des recettes';
$displayformlist=true;
$displayformsearch=true;
$donnees= [];

 // Jointure SQL permettant de récupérer la recette & le prénom & nom de l'utilisateur l'ayant publié
$select = $bdd->prepare('SELECT r.*, u.firstname, u.lastname FROM recipes AS r INNER JOIN users AS u ON r.userId = u.userId');

if($select->execute()){
    $recipes = $select->fetchAll(PDO::FETCH_ASSOC);
    $displayformlist=true;
    $displayformsearch=false;
        
        
	}
	else {
		// Erreur de développement
		var_dump($select->errorInfo());
		die; // alias de exit(); => die('Hello world');
	}

if(!empty($_POST)){

	// équivalent au foreach de nettoyage
	$post = array_map('trim', array_map('strip_tags', $_POST)); 
    
    if(isset($post['search'])) {
        
    if(strlen($post['search']) < 1){
		$errors[] = 'Il faut au moins rentrer un caractère';
	}    
    $chainesearch = $post['search'];  
    

     
        
//        $requete = $bdd->prepare("SELECT r.*, u.firstname, u.lastname FROM recipes AS r INNER JOIN users AS u ON r.userId = u.userId WHERE r.title LIKE '". $chainesearch 
//	."%' OR r.content LIKE '". $chainesearch 
//	."%' OR u.firstname LIKE '". $chainesearch 
//    ."%' OR u.lastname LIKE '". $chainesearch ."%'"); 
      
    if(count($errors) === 0){
        
        $requete = $bdd->prepare("SELECT r.*, u.firstname, u.lastname FROM recipes AS r INNER JOIN users AS u ON r.userId = u.userId WHERE r.title LIKE '%". $chainesearch 
        ."%' OR r.content LIKE '%". $chainesearch 
        ."%' OR u.firstname LIKE '%". $chainesearch 
        ."%' OR u.lastname LIKE '%". $chainesearch 
        ."%'"); 

        // Exécution de la requête SQL
        if($requete->execute()){

        $donnees = $requete->fetchAll(PDO::FETCH_ASSOC);
        $displayformlist=false;  
        $displayformsearch=true;    
   
   
        
        
        }else {
            // Erreur de développement
            var_dump($requete->errorInfo());
            die; // alias de exit(); => die('Hello world');
        }
        
//        // Jointure SQL permettant de récupérer la recette & le prénom & nom de l'utilisateur l'ayant publié
//    $select = $bdd->prepare('SELECT r.*, u.firstname, u.lastname FROM recipes AS r INNER JOIN users AS u ON r.userId = u.userId');
//
//	if($select->execute()){
//		$recipes = $select->fetchAll(PDO::FETCH_ASSOC);
//        $displayformlist=true;
//        $displayformsearch=false;
//        
//        
//	}
//	else {
//		// Erreur de développement
//		var_dump($select->errorInfo());
//		die; // alias de exit(); => die('Hello world');
//	}
    }
	else
	{
		$textErrors = implode('<br>', $errors);
	}    
        
	}
    }
       




?>
<?php
require_once '../../inc/header.php';
?>

	<h1>Les recettes</h1>
   
    <?php if(isset($textErrors)){
			echo '<p style="color:red">'.$textErrors.'</p>';
		}
    ?>
    <form action ="" method="post">
    
	<span>Recherche par nom :</span> 
	<input type="text" id="search" name="search" minlength="1">
	<input type="submit" value="Envoyer" >
	
    </form>
    
    <a href="recipes_list.php">Liste complète des recettes</a>
    
    <?php if (isset($post['search']) && $displayformsearch==true){ 
    echo 'Vous avez recherché : ' . $chainesearch . '<br />'; 
    ?>
    
    <br>
	<table>
		<thead>
			<tr>
                <th colspan="5">Résultats de la recherche</th>
			</tr>
		</thead>

		<tbody>
			<!-- foreach permettant d'avoir une ligne <tr> par ligne SQL -->
			<?php foreach($donnees as $donnee): ?>
			    <tr>
			        <td colspan="5"><strong><?= preg_replace('`'.$chainesearch.'`isU','<span style="font-weight: bold; color: orange; font-size:25px">$0</span>', $donnee['title']); ?></strong></td>
			    </tr>
				<tr>
					<td><?= "<img src='../../uploads/".$donnee['picture']."' alt='".$donnee['title']."' height='200' width='200'>"; ?></td>
					<td><?= preg_replace('`'.$chainesearch.'`isU','<span style="font-weight: bold; color: orange; font-size:25px">$0</span>', $donnee['content']) ?></td>
					<td><?= "auteur: ".preg_replace('`'.$chainesearch.'`isU','<span style="font-weight: bold; color: orange; font-size:25px">$0</span>', $donnee['firstname'])." ".preg_replace('`'.$chainesearch.'`isU','<span style="font-weight: bold; color: orange; font-size:25px">$0</span>', $donnee['lastname']); ?></td>
					<td>
						<!-- view_recipe.php?id=6 -->
						<a href="../../view_recipe.php?id=<?=$donnee['recipeId']; ?>">
							voir la recette
						</a>
					</td>
					<td>
						<!-- recipe_update.php?id=6 -->
						<a href="recipe_update.php?id=<?=$donnee['recipeId']; ?>">
							Modifier
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
    <?php if ($donnees==[]){
        echo 'Il n\'y a pas de résultat';
    }
    } ; ?>
    
    
    
    <?php if (empty($_POST['search']) && $displayformlist==true){ ?>
	<br>
	<table>
		<thead>
			<tr>
                <th colspan="5">Liste des recettes</th>
			</tr>
		</thead>

		<tbody>
			<!-- foreach permettant d'avoir une ligne <tr> par ligne SQL -->
			<?php foreach($recipes as $recipe): ?>
			    <tr>
			        <td colspan="5"><strong><?=$recipe['title']; ?></strong></td>
			    </tr>
				<tr>
					<td><?= "<img src='../../uploads/".$recipe['picture']."' alt='".$recipe['title']."' height='200' width='200'>"; ?></td>
					<td><?=$recipe['content']; ?></td>
					<td><?= "auteur: ".$recipe['firstname']." ".$recipe['lastname']; ?></td>
					<td>
						<!-- view_menu.php?id=6 -->
						<a href="../../view_recipe.php?id=<?=$recipe['recipeId']; ?>">
							voir la recette
						</a>
					</td>
					<td>
						<!-- recipe_update.php?id=6 -->
						<a href="recipe_update.php?id=<?=$recipe['recipeId']; ?>">
							Modifier
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
    <?php }; ?>
    
<?php
require_once '../../inc/footer.php';
?>