<?php

	

session_start(); // Permet de démarrer la session
require_once 'inc/connect.php';


$errors = [];
$post = [];
$displayForm = true;
$title = 'Formulaire de contact';
    
if(!empty($_POST)){
	foreach($_POST as $key => $value){
		$post[$key] = trim(strip_tags($value));
	}

	if(strlen($post['firstname']) < 2 || strlen($post['libelle']) > 50){
		$errors[] = 'Le Prénom doit comporter entre 5 et 50 caractères';
	}

    if(strlen($post['lastname']) < 2 || strlen($post['libelle']) > 50){
		$errors[] = 'Le Nom doit comporter entre 5 et 50 caractères';
	}

    if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Le champ Email n'est pas conforme";
	}
    
	if(strlen($post['subject']) < 20){
		$errors[] = 'Le sujet doit comporter au moins 20 caractères';
	}
    


	if(count($errors) === 0){



		$insert = $bdd->prepare('INSERT INTO users (firstname, lastname, email, subject) VALUES (:firstname, :lastname, :email, :subject)');
		$insert->bindValue(':firstname', $post['firstname']);
		$insert->bindValue(':lastname', $post['lastname']);
		$insert->bindValue(':email', $post['email']);
		$insert->bindValue(':subject', $post['subject']);

		if($insert->execute()){
			$success = 'Youpi, le produit a été entré avec succès';
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
			echo '<p style="color:green">'.$success.'<a href="list_product.php">Liste des produits</a></p>';
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

            <label for="subject">sujet</label>
            <textarea name="subject" id="subject">Entrez votre sujet...</textarea>


            <input type="submit" value="Envoyer mon message">
                                    
        </form>
    </fieldset>
    <?php endif; ?>
    
    
    
    
    


<?php
require_once 'inc/footer.php';
?>