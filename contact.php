<?php

	//inclure le header

	//Formulaire de contact

	//Traitement et vérification du formulaire

	//inclure le footer

session_start(); // Permet de démarrer la session
require_once 'inc/connect.php';


$errors = [];
$post = [];
$displayForm = true;
$title = 'Formulaire de contact';
// Définit le fuseau horaire par défaut à utiliser.
date_default_timezone_set('America/Martinique');

if(!empty($_POST)){
	foreach($_POST as $key => $value){
		$post[$key] = trim(strip_tags($value));
	}

	if(strlen($post['firstname']) < 2 || strlen($post['firstname']) > 50){
		$errors[] = 'Le Prénom doit comporter entre 5 et 50 caractères';
	}

    if(strlen($post['lastname']) < 2 || strlen($post['lastname']) > 50){
		$errors[] = 'Le Nom doit comporter entre 5 et 50 caractères';
	}

    if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Le champ Email n'est pas conforme";
	}
    
    if(strlen($post['object']) < 2){
		$errors[] = 'L\'objet doit comporter au moins 2 caractères';
	}
    
	if(strlen($post['subject']) < 20){
		$errors[] = 'Le sujet doit comporter au moins 20 caractères';
	}
    


	if(count($errors) === 0){



		$insert = $bdd->prepare('INSERT INTO contact_user (firstname, lastname, email, object, subject, checked, datehr) VALUES (:firstname, :lastname, :email, :object, :subject, :checked, :datehr)');
        
        //préparation de l'affichage de la date et de l'heure
		$dateAndTime = date('Y/m/d H:i:s');
        
		$insert->bindValue(':firstname', $post['firstname']);
		$insert->bindValue(':lastname', $post['lastname']);
		$insert->bindValue(':email', $post['email']);
		$insert->bindValue(':object', $post['object']);
		$insert->bindValue(':subject', $post['subject']);
		$insert->bindValue(':checked', false,PDO::PARAM_BOOL);
		$insert->bindValue(':datehr', $dateAndTime);

		if($insert->execute()){
			$success = 'Youpi, votre message va être traité par un administrateur';
			$displayForm = false;
            
		}
		else {
			// Erreur de développement
			var_dump($insert->errorInfo());
			die; // alias de exit(); => die('Hello world');
		}

	}
	else {
		$errorsText = implode('<br>', $errors); 
	}
}

?>
<?php
require_once 'inc/header.php';
?>



    <?php
		if(isset($textErrors)){
			echo '<p style="color:red">'.$textErrors.'</p>';
		}

		if(isset($success)){
			echo '<p style="color:green">'.$success.'</p>';
		}
	?>
   <?php if($displayForm === true): ?>
    <fieldset>
        <form method="post" >

                                    
            <label for="firstname">Nom</label>
            <input type="text" name="firstname" id="firstname" placeholder="nom">

            <label for="lastname">Prénom</label>
            <input type="text" name="lastname" id="lastname" placeholder="Prénom">

            <label for="email">Entrez votre email</label>
            <input type="text" name="email" id="email" placeholder="Email">
            
            <label for="object">Objet du message</label>
            <input type="text" name="object" id="object" placeholder="Objet">

            <label for="subject">sujet</label>
            <textarea name="subject" id="subject">Entrez votre message...</textarea>


            <input type="submit" value="Envoyer mon message">
                                    
        </form>
    </fieldset>
    <?php endif; ?>
    
    
    
    
    


<?php
require_once 'inc/footer.php';
?>