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


//Pour ajouter une recette l'utilisateur devra avoir été préalablement authentifié

//Penser à décommenter lors de la mise en place de la session dans le projet

/*


if(!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] == false){
 	// Redirection vers la page de connexion si non connecté
 	header('Location: login.php');
 	die; 
}


*/



/*---------------------------------------------------------------- 
|~ ~ ~ ~ ~       Déclaration des variables       ~ ~ ~ ~ ~ ~  |
-----------------------------------------------------------------*/

// Taille maximum du fichier photo de la recette
$maxSize = (1024 * 1000) * 2; 


// Répertoire d'upload - ou seront téléchargés les photos

$uploadDir = 'uploads/';

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


		$addRecipe = $bdd->prepare('INSERT INTO recipes (userId, title, content, picture, datehr) VALUES(:dataUserId, :dataTitle, :dataContent,  :dataPicture, :datadatehr)');

		
		//préparation de l'affichage de la date et de l'heure
		$dateAndTime = date('Y/m/d h:i:s');
		
		
//pour réccupérer l'id de l'user -- penser à décommenter
		$addRecipe->bindValue(':dataUserId', $_SESSION['userId'] , PDO::PARAM_INT); 
		$addRecipe->bindValue(':dataTitle', $post['title']); 
		$addRecipe->bindValue(':dataContent', $post['content']);
		$addRecipe->bindValue(':dataPicture', $uploadDir.$newPictureName);
		$addRecipe->bindValue(':datadatehr', $dateAndTime);

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

require_once '../../inc/header.php';	

?>





	<h1>Ajouter une recette</h1>

	<?php if(isset($errorsText)): ?>
		<p style="color:red;"><?php echo $errorsText; ?></p>
	<?php endif; ?>

	<?php if(isset($success)): ?>
		<p style="color:green;"><?php echo $success; ?></p>
	<?php endif; ?>

<!--
	-->

	<?php if($displayForm === true): ?>
	<form method="post" enctype="multipart/form-data">
		<label for="title">Titre de la recette</label>
		<input type="text" name="title" id="title">

		<br>
		<label for="content">Description</label>
		<textarea name="content" id="content"></textarea>

		<br>
		<label for="picture">Photo</label>
		<input type="file" name="picture" id="picture" accept="image/*">

		

		<br>
		<input type="submit" value="Envoyer ma recette">
	</form>
	<?php endif; ?>




<?php

require_once '../../inc/footer.php';
	//inclure le header





	//Formulaire d'ajout de rectte

	//Traitement et vérification du formulaire

	//inclure le footer

?>




