<?php

/*Cette page permet à l'administrateur après authentification de modifier les informations du restaurant ainsi que les images du slider :



*/

session_start();
require_once '../../inc/connect.php';

if(!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] == false || $_SESSION['role'] != 'role_admin'){
// Redirection vers la page de connexion si non connecté
    
header('Location: ../login.php');
die;
}



$maxSize = (1024 * 1000) * 2; // Taille maximum du fichier
$uploadDir = '../../assets/img/slider/'; // Répertoire d'upload
$mimeTypeAvailable = ['image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'];

$errors = [];
$post = [];






/****************************************************************
 | Traitement du formulaire /changement de l'image de couverture |
********************************************************************/

if(!empty($_POST['cover'])){
	foreach($_POST as $key => $value){
		$post[$key] = trim(strip_tags($value));
	}

/*************
 | IMAGE 1 |
***************/	
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
		$errors[] = 'Aucune image sélectionnée pour l\'image N° 1 du SLIDER';
	}
	
/*************
 | IMAGE 2 |
***************/	
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
		$errors[] = 'Aucune image sélectionnée pour l\'image N° 1 du SLIDER';
	}
	
	
/*************
 | IMAGE 3 |
***************/
	
	
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
		$errors[] = 'Aucune image sélectionnée pour l\'image N° 1 du SLIDER';
	}
	

/*************************
 |  Si aucune erreurs   |
************************/	

	if(count($errors) === 0){
		
		
		$update = $bdd->prepare('UPDATE options SET cover = :dataPicture');

			$update->bindValue(':dataPicture', $uploadDir.$newPictureName);

			if($update->execute())
			{
				$success = 'Vous avez modifié la photo de couverture avec succès';
			}
			else
			{
				var_dump($update->errorInfo());
			}
		}
		else
		{
			$textErrors = implode('<br>', $errors);
		}

	}

/********************************************************
 | Traitement du formulaire /changement des infos resto |
**********************************************************/



		if(!empty($_POST['coordonnees'])){

		// équivalent au foreach de nettoyage
		$post = array_map('trim', array_map('strip_tags', $_POST)); 

		if(strlen($post['name']) < 2) {
			$errors[] = "Le champ Nom du Restaurant doit avoir au minimum 2 caractères";
		}


		//pour la validation du téléphone
		if(!preg_match('/^[0-9]{10}$/', $post['tel'])){
				$errors[] = "Le numéro de téléphone doit contenir obligatoirement 10 chiffres
				";
			}

		if(strlen($post['address']) < 2) {
			$errors[] = "Le champ Adresse doit avoir au minimum 2 caractères";
		}
			


		//pour la validation de l'email
		 $pattern  = "/^([^@\s<&>]+)@(?:([-a-z0-9]+)\.)+([a-z]{2,})$/iD";

			 if(!preg_match($pattern, $post['email']))
			{
				$errors[] = "Le champ Email n'est vraiment pas conforme";
			}


		if(count($errors) === 0){
		

			$update = $bdd->prepare('UPDATE options SET name = :restname, tel = :restphone, address = :restadress, email = :restemail');

			
			$update->bindValue(':restname', $post['name']);
			$update->bindValue(':restphone', $post['tel']);
			$update->bindValue(':restadress', $post['address']);
			$update->bindValue(':restemail', $post['email']);

			if($update->execute())
			{
				$success = 'Félicitations les informations du Restaurant ont été modifiées';
			}
			else
			{
				var_dump($update->errorInfo());
			}
		}
		else
		{
			$errorsText = implode('<br>', $errors);
		}

	}	

<?php
//Intégration du Header
	
/************************************************************************************************************
 | Selection des informations du Restaurant pour affichage dans le formulaire (compris dans le header) |
************************************************************************************************************/	
	
require_once '../../inc/header.php';
?>
 <br>
 <br>
<h1>SECTION D'ADMINISTRATION</h1>
 <br>
 <br>
<h2>Que souhaitez vous modifier ?</h2>
 
        <div>

          <a  href="#" onclick="bascule('coordonnees');">Modifier les Coordonnées du Restaurant</a>

        </div>   

        <div>   

          <a href="#" onclick="bascule('cover');">Modifier l'Image de couverture</a>

        <div>   


   
   <div id="cover">
       <h2>Veuillez choisir l'image de couverture</h2>
       <br>
       <br>
       	<?php if(isset($errorsText)): ?>
		<p style="color:red;"><?php echo $errorsText; ?></p>
		<?php endif; ?>

		<?php if(isset($success)): ?>
		<p style="color:green;"><?php echo $success; ?></p>
		<?php endif; ?>
      	
      	
      	<form>
      	
			<label for="picture">Image N°1</label>
			<input type="file" name="picture"  accept="image/*">
			
			<label for="picture">Image N°2</label>
			<input type="file" name="picture2"  accept="image/*">
			
			<label for="picture">Image N°3</label>
			<input type="file" name="picture3"  accept="image/*">
			
			<input type="submit" name="cover" value="Mettre à jour l'image de couverture">
     	
     	
      	</form>
       
   </div>
   
   
   
<!-- 
*********************************
 |changement des infos resto |
********************************/
-->
   <div id="coordonnees">
   	    <h2>Coordonnées du restaurant</h2>
       <br>
       <br>

       	<?php if(isset($errorsText)): ?>
		<p style="color:red;"><?php echo $errorsText; ?></p>
		<?php endif; ?>

		<?php if(isset($success)): ?>
		<p style="color:green;"><?php echo $success; ?></p>
		<?php endif; ?>
       
       <form>
       
      
       	<br>
		<label for="name">Nom du Restaurant</label>
		<input type="text" name="name"  value="<?=$options['name'];?>">


		<br>
		<label for="phone">Téléphone</label>
		<input type="text" name="tel" value="<?=$options['tel'];?>">

		<br>
		<label for="address">Adresse</label>
		<input type="text" name="address" value="<?=$options['address'];?>">
      	
       	<br>
		<label for="address">Adresse</label>
		<input type="text" name="email" value="<?=$options['email'];?>">
  			
   			<input type="submit"  name="coordonnees" value="Mettre à jour l'image de couverture">
   	
   	   </form>
   	   
   </div>
    
<script type="text/javascript"> 
	
	
		function bascule(id) 
								{ 
									if (document.getElementById(id).style.visibility == "hidden")

											document.getElementById(id).style.visibility = "visible"; 

									else	document.getElementById(id).style.visibility = "hidden"; 
								} 
	
</script> 

<?php
			
//Intégration du footer
require_once '../../inc/footer.php';
			
?>




