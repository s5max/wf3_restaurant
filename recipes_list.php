<?php

	//inclure le header

	//SELECT * recipes	ORDER BY DESC
	//fetchAll

session_start(); // Permet de démarrer la session
require_once 'inc/connect.php';

$title = 'Liste des recettes';
//// On selectionne les toutes les colonnes de la table users
//$select = $bdd->prepare('SELECT * FROM recipes ORDER BY recipeId DESC');
//if($select->execute()){
//	$recipes = $select->fetchAll(PDO::FETCH_ASSOC);
//}
//else {
//	// Erreur de développement
//	var_dump($select->errorInfo());
//	die; // alias de exit(); => die('Hello world');
//}

// Jointure SQL permettant de récupérer la recette & le prénom & nom de l'utilisateur l'ayant publié
    $select = $bdd->prepare('SELECT r.*, u.firstname, u.lastname FROM recipes AS r INNER JOIN users AS u ON r.userId = u.userId');

	if($select->execute()){
		$recipes = $select->fetchAll(PDO::FETCH_ASSOC);
	}
	else {
		// Erreur de développement
		var_dump($select->errorInfo());
		die; // alias de exit(); => die('Hello world');
	}


?>
<?php
require_once 'inc/header.php';
?>

	<h1>Les recettes</h1>

	<br>
	<table>
		<thead>
			<tr>
                <th colspan="4">Liste des recettes</th>
			</tr>
		</thead>

		<tbody>
			<!-- foreach permettant d'avoir une ligne <tr> par ligne SQL -->
			<?php foreach($recipes as $recipe): ?>
			    <tr>
			        <td colspan="4"><strong><?=$recipe['title']; ?></strong></td>
			    </tr>
				<tr>
					<td><?= "<img src='admin/user/".$recipe['picture']."' alt='".$recipe['title']."' height='200' width='200'>"; ?></td>
					<td><?=$recipe['content']; ?></td>
					<td><?= "by".$recipe['firstname']." ".$recipe['lastname']; ?></td>
					<td>
						<!-- view_menu.php?id=6 -->
						<a href="view_recipe.php?id=<?=$recipe['recipeId']; ?>">
							voir la recette
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>


<?php
require_once 'inc/footer.php';
?>