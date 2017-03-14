<?php

	//inclure le header

	//Formulaire d'ajout de recettes

	//inclure le footer



/*---------------------------------------------------------------- 
|~ ~ ~ ~ ~   10 mars 2017 projet : my_restaurant   ~ ~ ~ ~ ~ ~  |
------------------------------------------------------------*/ 
session_start();

//Appel du ficher de connexion a la base de donnée my_restaurant

require_once '../../inc/connect.php';


if(!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] == false || $_SESSION['role'] != 'role_admin'){
// Redirection vers la page de connexion si non connecté
header('Location: ../login.php');
die;
}


date_default_timezone_set('America/Martinique');

//Pour ajouter une recette l'utilisateur devra avoir été préalablement authentifié

//Penser à décommenter lors de la mise en place de la session dans le projet


/*---------------------------------------------------------------- 
|~ ~ ~ ~ ~       Déclaration des variables       ~ ~ ~ ~ ~ ~  |
-----------------------------------------------------------------*/

// Taille maximum du fichier photo de la recette
$maxSize = (1024 * 1000) * 2; 


// Répertoire d'upload - ou seront téléchargés les photos

$uploadDir = '../../uploads/';

//Type d'images acceptées en téléchargement
$mimeTypeAvailable = ['image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'];


//Titre de la page
$title = 'Ajout d\'une recette';

//Tableau des erreurs
$errors = [];

//Tableau contenant les valeurs entrées dans les champs du formulaire
$post = [];

//Gestion de l'affichage (ou pas ) du formulaire.
$displayForm = true;

// Définit le fuseau horaire par défaut à utiliser.
date_default_timezone_set('America/Martinique');

/*---------------------------------------------------------------- 
|~ ~ ~ ~ ~       Validation du formulaire      ~ ~ ~ ~ ~ ~  |
-----------------------------------------------------------------*/
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
	$recipeid = (int) $_GET['id'];

if(!empty($_POST)){
	foreach($_POST as $key => $value){
		$post[$key] = trim(strip_tags($value));
	}

	if(strlen($post['title']) < 5 || strlen($post['title']) > 50){
		$errors[] = 'Le titre doit comporter entre 5 et 50 caractères';
	}

	if(strlen($post['content']) < 20){
		$errors[] = 'La description doit comporter au moins 20 caractères';
	}

    if(!is_numeric($post['iduser'])){
		$errors[] = 'Il faut entre le nombre de correspondant à l\'id de l\'utilisateur';
	}
//Traitement de la photo de la recette
	if(isset($_FILES['picture']) && $_FILES['picture']['error'] === 0){

		$finfo = new finfo();
		$mimeType = $finfo->file($_FILES['picture']['tmp_name'], FILEINFO_MIME_TYPE);

		$extension = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

		if(in_array($mimeType, $mimeTypeAvailable)){

			if($_FILES['picture']['size'] <= $maxSize){

				if(!is_dir($uploadDir)){
					mkdir($uploadDir, 0755);
				}

				$newPictureName = uniqid('picture_').'.'.$extension;

				if(!move_uploaded_file($_FILES['picture']['tmp_name'], $uploadDir.$newPictureName)){
					$errors[] = 'Erreur lors de l\'upload de la photo';
				}
			}
			else {
				$errors[] = 'La taille du fichier excède 2 Mo';
			}

		}
		else {
			$errors[] = 'Le fichier n\'est pas une image valide';
		}
	}
	else {
		$errors[] = 'Aucune photo sélectionnée';
	}



	if(count($errors) === 0){

		if(isset($post['selected'])){
			$isSelected = 1;
		}
		else {
			$isSelected = 0;	
		}


		$addRecipe = $bdd->prepare('UPDATE recipes SET userId = :dataUserId, title= :dataTitle, content= :dataContent, picture= :dataPicture, datehr= :datadatehr WHERE recipeId=:id');
$date= date($post['datehr']);
//pour réccupérer l'id de l'user -- penser à décommenter
		$addRecipe->bindValue(':dataUserId', $post['iduser'], PDO::PARAM_INT); 
		$addRecipe->bindValue(':dataTitle', $post['title']); 
		$addRecipe->bindValue(':dataContent', $post['content']);
		$addRecipe->bindValue(':dataPicture', $newPictureName);
		$addRecipe->bindValue(':datadatehr', $date);
        $addRecipe->bindValue(':id', $recipeid, PDO::PARAM_INT);

		if($addRecipe->execute()){
			$success = 'Youpi, la recette est ajoutée avec succès';
			$displayForm = false;
		}
		else {
			// Erreur de développement
			var_dump($addRecipe->errorInfo());
			die; // alias de exit(); => die('Hello world');
		}

	}
	else {
		$errorsText = implode('<br>', $errors); 
	}
}
    $select = $bdd->prepare('SELECT * FROM recipes WHERE recipeId = :id');
$select->bindValue(':id',$recipeid, PDO::PARAM_INT);
    
if($select->execute()){
    
$users = $select->fetchAll(PDO::FETCH_ASSOC);
}
}

require_once '../../inc/header.php';	

?>





	<h1>Modifier la recette</h1>

	<?php if(isset($errorsText)): ?>
		<p style="color:red;"><?php echo $errorsText; ?></p>
	<?php endif; ?>

	<?php if(isset($success)): ?>
		<p style="color:green;"><?php echo $success; ?></p>
	<?php endif; ?>

<!--
	-->

	<?php if($displayForm === true): ?>
	<?php foreach($users as $user): ?>
	<form method="post" enctype="multipart/form-data">
		<label for="title">Titre de la recette</label>
		<input type="text" name="title" id="title"value="<?php echo $user['title']; ?>">

		<br>
		<label for="content">Description</label>
		<textarea name="content" id="content" placeholder="<?php echo $user['content']; ?>"></textarea>

		<br>
		<label for="picture">Photo</label>
		<input type="file" name="picture" id="picture" accept="image/*" value="<?php echo $user['picture']; ?>">

		<br>
        <label for="iduser">ID de l'utilisateur</label>
		<input type="text" name="iduser" id="iduser"value="<?php echo $user['userId']; ?>">
		
		<br>
        <label for="datehr">date</label>
		<input type="text" name="datehr" id="datehr" value="<?php echo $user['datehr']; ?>">
		
		<br>
		<input type="submit" value="Envoyer ma recette">
	</form>
	 <?php endforeach; ?>
	<?php endif; ?>




<?php

require_once '../../inc/footer.php';
	//inclure le header





	//Formulaire d'ajout de rectte

	//Traitement et vérification du formulaire

	//inclure le footer

?>
