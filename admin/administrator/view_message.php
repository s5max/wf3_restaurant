<?php
	
	//inclure le header

	//SELECT une en passant par l'id de l'url view_recipe.php?id=...


	//inclure le footer
session_start(); // Permet de démarrer la session
require_once '../../inc/connect.php';


if(!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] == false || $_SESSION['role'] != 'role_admin'){
// Redirection vers la page de connexion si non connecté
header('Location: ../login.php');
die;
}

$title = 'Voir le message';

$recette = [];


// view_menu.php?id=6
if(isset($_GET['id']) && !empty($_GET['id'])){

	$idmessage = (int) $_GET['id'];
    
    $updatechecked = $bdd->prepare('UPDATE contact_user SET checked = :checked WHERE id= :id');
//pour réccupérer l'id de l'user -- penser à décommenter
		$updatechecked->bindValue(':checked', true, PDO::PARAM_BOOL); 
		$updatechecked->bindValue(':id', $idmessage, PDO::PARAM_INT); 
    
    if($updatechecked->execute()){
			
		}
		else {
			// Erreur de développement
			var_dump($updatechecked>errorInfo());
			die; // alias de exit(); => die('Hello world');
		}

	// Jointure SQL permettant de récupérer la recette & le prénom & nom de l'utilisateur l'ayant publié
	$selectOne = $bdd->prepare('SELECT * FROM contact_user WHERE id= :idmessage');
	$selectOne->bindValue(':idmessage', $idmessage, PDO::PARAM_INT);

	if($selectOne->execute()){
		$message = $selectOne->fetch(PDO::FETCH_ASSOC);
        $date= date_create($message['datehr']);
        
	}
	else {
		// Erreur de développement
		var_dump($selectOne->errorInfo());
		die; // alias de exit(); => die('Hello world');
	}
}


?>
<?php
require_once '../../inc/header.php';
?>

<?php if(!empty($message)): ?>

	<h1>Message de l'email: <?= $message['email'] ?></h1><a href="contact_treatment.php">Revenir à la liste des messages</a>

	<h2><?php echo $message['object'];?></h2>

	<p><?php echo nl2br($message['subject']); ?></p>
	
	<p>Publié le <?php echo date_format($date, 'd-m-Y'); ?> à <?php echo date_format($date, 'H:i:s'); ?></p>

	<p>Publié par <?php echo $message['firstname'].' '.$message['lastname'];?></p>
	
	<p><?php if ($message['checked']==true){
        echo 'Message lu';
    }else{
    echo 'Message non lu';
}
    ?>
    </p>
    
<?php else: ?>

	Aucun message trouvé !
<?php endif; ?>

<?php
require_once '../../inc/footer.php';
?>