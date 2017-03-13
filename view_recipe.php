<?php
	
	//inclure le header

	//SELECT une en passant par l'id de l'url view_recipe.php?id=...


	//inclure le footer
session_start(); // Permet de démarrer la session
require_once 'inc/connect.php';
$title = 'Voir la recette';

$recette = [];


// view_menu.php?id=6
if(isset($_GET['id']) && !empty($_GET['id'])){

	$idRecette = (int) $_GET['id'];

	// Jointure SQL permettant de récupérer la recette & le prénom & nom de l'utilisateur l'ayant publié
	$selectOne = $bdd->prepare('SELECT r.*, u.firstname, u.lastname FROM recipes AS r INNER JOIN users AS u ON r.userId = u.userId WHERE r.recipeId = :idRecette');
	$selectOne->bindValue(':idRecette', $idRecette, PDO::PARAM_INT);

	if($selectOne->execute()){
		$recette = $selectOne->fetch(PDO::FETCH_ASSOC);
        $date= date_create($recette['datehr']);
        
	}
	else {
		// Erreur de développement
		var_dump($selectOne->errorInfo());
		die; // alias de exit(); => die('Hello world');
	}
}


?>
<?php
require_once 'inc/header.php';
?>

<?php if(!empty($recette)): ?>

	<h1>Détail d'une recette</h1>

	<h2><?php echo $recette['title'];?></h2>

	<p><?php echo nl2br($recette['content']); ?></p>

	<img src="admin/user/<?=$recette['picture'];?>" alt="<?php echo $recette['title'];?>" height="200" width="200" >

	<p>Publié le <?php echo date_format($date, 'd-m-Y'); ?> à <?php echo date_format($date, 'H:i:s'); ?></p>

	<p>Publié par <?php echo $recette['firstname'].' '.$recette['lastname'];?></p>
<?php else: ?>

	Aucune recette trouvée !
<?php endif; ?>

<?php
require_once 'inc/footer.php';
?>